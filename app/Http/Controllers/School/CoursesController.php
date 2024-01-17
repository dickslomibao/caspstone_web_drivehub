<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\CourseVehicleRepository;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\CourseVehicleRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $courseRepository;
    private $progressRepository;
    private $courseVariantRepository;
    private $vehicleRepository;
    private $courseVehicleRepository;
    public function __construct(

        CourseRepositoryInterface $courseRepository,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
        ProgressRepositoryInterface $progressInterface,
        VehicleRepositoryInterface $vehicleRepositoryInterface,
        CourseVehicleRepositoryInterface $courseVehicleRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:3');
        $this->courseRepository = $courseRepository;
        $this->progressRepository = $progressInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
        $this->vehicleRepository = $vehicleRepositoryInterface;
        $this->courseVehicleRepository = $courseVehicleRepositoryInterface;
    }

    public function index()
    {
        return view('school.features.courses_management.index', [
            'progress' => $this->progressRepository->retrieveAll(auth()->user()->schoolid),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.features.courses_management.create', [
            'progress' => $this->progressRepository->retrieveAll(auth()->user()->schoolid),
            'vehicles' => $this->vehicleRepository->retrieveAllAvailable(auth()->user()->schoolid),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = 200;
        $message = "Added Succcessfully";
        $id = null;
        try {
            $path = $request->file('image')->storePublicly('public/courseImages');
            $path = Str::replace('public', 'storage', $path);
            $id = Str::random(10);
            $this->courseRepository->create([
                'id' => $id,
                'school_id' => auth()->user()->schoolid,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'thumbnail' => $path,
                'type' => $request->exists('type') ? 2 : 1,
            ]);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'course' => $this->courseRepository->retrieveFromId($id, auth()->user()->schoolid),
        ]);
    }

    public function storeFromWeb(Request $request)
    {
        $code = 200;
        $message = "Update Successfully";

        try {
            $path = $request->file('image')->storePublicly('public/courseImages');
            $path = Str::replace('public', 'storage', $path);
            $id = Str::random(10);
            $this->courseRepository->create([
                'id' => $id,
                'school_id' => auth()->user()->schoolid,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'thumbnail' => $path,
                'type' => $request->exists('type') ? 2 : 1,
            ]);

            $this->createCourseLog($request->name);


            if ($request->progress != null) {
                foreach ($request->progress as $value) {
                    $this->progressRepository->addCourseProgress(
                        [
                            'course_id' => $id,
                            'progress_id' => $value,
                        ]
                    );
                }
                foreach ($request->vehicles as $vehicle) {
                    $this->courseVehicleRepository->create(
                        [
                            'course_id' => $id,
                            'vehicle_id' => $vehicle,
                        ]
                    );
                }
            } else {
                $this->courseVariantRepository->create([
                    'course_id' => $id,
                    'duration' => 15,
                    'price' => $request->price,
                ]);
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return only necessary instructor data
        return response()->json([
            'code' => $code,
            'message' => $message,

        ]);
        //return redirect()->route('index.courses');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $course = $this->courseRepository->retrieveFromId($id, auth()->user()->schoolid);
        $variants = $this->courseVariantRepository->getCourseVariant($course->id);

        $coursesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) as total_order FROM order_lists WHERE MONTH(date_created) =? AND YEAR(date_created) = ? AND course_id=? ', [$i, $currentYear, $id])[0]->total_order;
            $coursesData[] = $total;
        }

        return view('school.features.courses_management.view', [
            'course' => $course,
            'variants' => $variants,
            'coursesData' => $coursesData,
            'courseID' => $id
        ]);
    }


    public function createVariant(Request $request, $id)
    {
        $this->courseVariantRepository->create([
            'course_id' => $id,
            'duration' => $request->duration,
            'price' => $request->price,
        ]);


        $details = DB::select('Select * FROM  courses WHERE id=?', [$id]);
        $name = $details[0]->name;

        $this->createCourseVariantLog($name, $request->duration . ' hrs');



        return redirect()->back()->with('course_message', 'Added Successfully');
    }




    public function updateView($course_id)
    {
        $details = DB::select('
        SELECT courses.*, course_progress.progress_id FROM courses 
        LEFT JOIN course_progress ON courses.id = course_progress.course_id WHERE courses.id= ?', [$course_id]);
        $c_v = [];
        foreach ($this->courseVehicleRepository->getCourseVehicle($course_id) as $v) {
            array_push($c_v, $v->id);
        }

        return view('school.features.courses_management.update', [
            'progress' => $this->progressRepository->retrieveAll(auth()->user()->schoolid),
            'details' => $details[0],
            'course_progress' => $details,
            'vehicles' => $this->vehicleRepository->retrieveAllAvailable(auth()->user()->schoolid),
            'c_v' => $c_v,
        ]);
    }



    public function updateFromWeb(Request $request)
    {


        $id = $request->input('course_id');
        $code = 200;
        $message = "Update Successfully";

        try {
            $delprogress = DB::delete('delete from course_progress where course_id=?', [$id]);
            $name = $request->name;
            $description = $request->description;
            $status = $request->status;
            $type = $request->exists('type') ? 2 : 1;

            $this->updateCourseLog($name);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->storePublicly('public/profile');
                $path = str_replace('public', 'storage', $path);

                $course = DB::update(
                    'UPDATE courses SET name = ?, description = ?, status = ?, thumbnail = ?, type = ? WHERE id = ?',
                    [$name, $description, $status, $path, $type, $id]
                );
            } else {

                $course = DB::update(
                    'UPDATE courses SET name = ?, description = ?, status = ?, type = ? WHERE id = ?',
                    [$name, $description, $status, $type, $id]
                );
            }
            $this->courseVehicleRepository->deletCourseVehicle($id);
            foreach ($request->vehicles as $vehicle) {
                $this->courseVehicleRepository->create(
                    [
                        'course_id' => $id,
                        'vehicle_id' => $vehicle,
                    ]
                );
            }
            foreach ($request->progress as $value) {
                $insert = DB::insert('insert into  course_progress (course_id, progress_id) values (?, ?)', [$id, $value]);
            }
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return only necessary instructor data
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
        //return redirect()->route('index.courses');
    }


    public function updateVariant(Request $request)
    {

        $id = $request->input('variant_id');
        $code = 200;
        $message = "Update Successfully";

        try {
            $duration = $request->input('duration1');
            $price = $request->input('price1');


            $instructorupdate = DB::update(
                'UPDATE courses_variant SET duration = ?, price = ? WHERE id = ?',
                [$duration, $price, $id]
            );


            $getID = DB::select('Select * FROM courses_variant WHERE id=?', [$id]);
            $courseID =  $getID[0]->course_id;

            $details = DB::select('Select * FROM  courses WHERE id=?', [$courseID]);
            $name = $details[0]->name;

            $this->updateCourseVariantLog($name, $duration . ' hrs');
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return only necessary instructor data
        return response()->json([
            'code' => $code,
            'message' => $message,

        ]);
    }




    public function filterCourseGraph(Request $request)
    {

        $year = $request->input('year');
        $courseID = $request->input('courseID');


        $coursesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) as total_order FROM order_lists WHERE MONTH(date_created) =? AND YEAR(date_created) = ? AND course_id=? ', [$i, $year, $courseID])[0]->total_order;
            $coursesData[] = $total;
        }

        return view('school.features.filter.filter_total_courseOrders', ['coursesData' => $coursesData, 'year' => $year]);
    }





    public function deleteCourse(Request $request)
    {
        $id = $request->input('course_id');
        $message = "Delete Successfully";
        $course = DB::select('SELECT * FROM order_lists WHERE course_id =?', [$id]);

        $details = DB::select('Select * FROM  courses WHERE id=?', [$id]);
        $name = $details[0]->name;

        if (count($course) >= 1) {
            $code = 500;
        } else {
            $delete = DB::delete('DELETE from courses where id=?', [$id]);
            $this->deleteCourseLog($name);
            $code = 200;
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    ///newest as in
    public function getName()
    {
        $userType = auth()->user()->type;
        $staff_id = Auth::user()->id;
        $name = '';
        if ($userType == 1) {
            $name = 'Driving School Admin';
        } else {
            $staff = DB::select('Select * FROM  staff WHERE staff_id=?', [$staff_id]);
            $name = $staff[0]->firstname . ' ' . $staff[0]->middlename . ' ' . $staff[0]->lastname;
        }

        return $name;
    }


    public function createCourseLog($name)
    {
        $this->logOperationToDatabase("Create Course: $name", 1, 'Course Management');
    }

    public function updateCourseLog($name)
    {
        $this->logOperationToDatabase("Update Course: $name", 2, 'Course Management');
    }

    public function deleteCourseLog($name)
    {
        $this->logOperationToDatabase("Delete Course: $name", 3, 'Course Management');
    }

    public function createCourseVariantLog($course, $variant)
    {
        $this->logOperationToDatabase("Create Course Variant under '$course': $variant", 1, 'Course Management');
    }

    public function updateCourseVariantLog($course, $variant)
    {
        $this->logOperationToDatabase("Update Course Variant under '$course': $variant", 2, 'Course Management');
    }

    public function deleteCourseVariantLog($course, $variant)
    {
        $this->logOperationToDatabase("Delete Course Variant under '$course': $variant", 3, 'Course Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
    }


    public function deleteVariant(Request $request)
    {
        $id = $request->input('variant_id');
        $message = "Delete Successfully";
        $code = 200;

        $getID = DB::select('Select * FROM courses_variant WHERE id=?', [$id]);
        $courseID =  $getID[0]->course_id;
        $duration =  $getID[0]->duration;

        $details = DB::select('Select * FROM  courses WHERE id=?', [$courseID]);
        $name = $details[0]->name;

        try {
           
            $delete = DB::delete('DELETE from courses_variant where id=?', [$id]);
            $this->deleteCourseVariantLog($name, $duration . ' hrs');

        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return response
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);




        $id = $request->input('variant_id');
        $message = "Delete Successfully";

        $course = DB::select('SELECT * FROM order_lists WHERE course_id =?', [$id]);

        $details = DB::select('Select * FROM  courses WHERE id=?', [$id]);
        $name = $details[0]->name;

        if (count($course) >= 1) {
            $code = 500;
        } else {
            $delete = DB::delete('DELETE from courses where id=?', [$id]);
            $this->deleteCourseLog($name);
            $code = 200;
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function retrieveAll()
    {
        return json_encode($this->courseRepository->retrieveAll(auth()->user()->schoolid));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
