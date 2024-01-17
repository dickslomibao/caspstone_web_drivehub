<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PromoController extends Controller
{
    private $promoRepository;
    private $promoItemRepository;
    private $coursesRepository;
    private $courseVariantRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepositoryInterface,
        PromoRepositoryInterface $promoRepositoryInterface,
        PromoItemRepositoryInterface $promoItemRepositoryInterface,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:6');
        $this->promoRepository = $promoRepositoryInterface;
        $this->coursesRepository = $courseRepositoryInterface;
        $this->promoItemRepository = $promoItemRepositoryInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
    }
    public function index()
    {
        return view('school.features.promo_management.index', [
            'promo' => $this->promoRepository->getSchoolPromo(auth()->user()->schoolid),
        ]);
    }



    public function show($promo_id)
    {

        $currentYear = Carbon::now()->year;

        $datarow = "";
        $courses = DB::select('SELECT courses.*, courses_variant.id AS variant_id, courses_variant.course_id, courses_variant.duration, courses_variant.price, promo.id, promo_items.variant_id FROM courses LEFT JOIN courses_variant ON courses_variant.course_id = courses.id LEFT JOIN promo_items ON promo_items.variant_id = courses_variant.id LEFT JOIN promo ON promo.id = promo_items.promo_id WHERE promo.id =? ', [$promo_id]);
        if (count($courses) <= 0) {
            $datarow = "None";
        }

        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orders FROM orders WHERE promo_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$promo_id, $i, $currentYear])[0]->count_of_orders;
            $orderData[] = $total;
        }


        return view('school.features.promo_management.view', [
            'promo' => $this->promoRepository->getSinglePromoUsingId($promo_id, auth()->user()->schoolid),
            'courses' => $courses,
            'datarow' => $datarow,
            'orderData' => $orderData,
            'promo_id' => $promo_id
        ]);
    }
    public function create()
    {

        $school_courses = [];
        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);
        foreach ($courses as $course) {
            $course->variants = $this->courseVariantRepository->getCourseVariant($course->id);
            array_push($school_courses, $course);
        }
        return view('school.features.promo_management.create', [
            'school_courses' => $school_courses,
        ]);
    }

    public function store(Request $request)
    {
        $temp_items = [];

        $promo_id = Str::random(10);
        $path = $request->file('thumbnail')->storePublicly('public/courseImages');
        $path = Str::replace('public', 'storage', $path);

        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);

        foreach ($courses as $course) {
            if ($request->exists($course->id)) {
                array_push($temp_items, [
                    'promo_id' => $promo_id,
                    'variant_id' => $request->input($course->id),
                ]);
            }
        }

        $this->promoRepository->create(
            [
                'id' => $promo_id,
                'school_id' => auth()->user()->schoolid,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'thumbnail' => $path,
            ]
        );
        foreach ($temp_items as $items) {
            $this->promoItemRepository->create($items);
        }

        $this->createPromoLog($request->name);

        return redirect()->route('index.promo')->with('message', 'Promo added Successfully');
    }



    public function updateView($promoid)
    {

        $school_courses = [];
        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);
        foreach ($courses as $course) {
            $course->variants = $this->courseVariantRepository->getCourseVariant($course->id);
            array_push($school_courses, $course);
        }



        $details = DB::select('Select * FROM promo WHERE id=?', [$promoid]);
        $promo = DB::select('Select * FROM promo_items WHERE promo_id=?', [$promoid]);

        return view('school.features.promo_management.update', [
            'school_courses' => $school_courses,
            'details' => $details[0],
            'promo_items' => $promo
        ]);

        // return  dd($promo);
    }




    public function promoFilterOrderGraph(Request $request)
    {

        $year = $request->input('year');
        $promo_id = $request->input('promo_id');

        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orders FROM orders WHERE promo_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$promo_id, $i, $year])[0]->count_of_orders;
            $orderData[] = $total;
        }


        return view('school.features.filter.promo_filter_order', ['orderData' => $orderData, 'year' => $year]);
    }


    // public function updatePromo(Request $request)
    // {






    //     $id = $request->input('promo_id');
    //     $code = 200;
    //     $message = "Update Successfully";
    //     $courses =  $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);
    //     $temp_items = [];

    //     try {

    //         $promoitems = DB::delete('delete from promo_items where promo_id=?', [$id]);

    //         $name = $request->input('name');
    //         $price = $request->input('price');
    //         $description = $request->input('description');
    //         $start_date = $request->input('start_date');
    //         $end_date = $request->input('end_date');



    //         if ($request->hasFile('image')) {
    //             $path = $request->file('image')->storePublicly('public/profile');
    //             $path = str_replace('public', 'storage', $path);

    //             $pic=DB::update(
    //                 'UPDATE promo SET thumbnail = ? WHERE id = ?',
    //                 [$path, $id]
    //             );
    //         }

    //         $promoupdate = DB::update(
    //             'UPDATE promo SET name = ?, price = ?, description = ?, start_date  = ?, end_date = ? WHERE user_id = ?',
    //             [$name, $price, $description, $start_date, $end_date, $id]
    //         );


    //         foreach ($courses as $course) {
    //             if ($request->exists($course->id)) {
    //                 array_push($temp_items, [
    //                     'promo_id' => $id,
    //                     'variant_id' => $request->input($course->id),
    //                 ]);
    //             }
    //         }


    //         foreach ($temp_items as $items) {
    //             $this->promoItemRepository->create($items);
    //         }


    //     } catch (Exception $ex) {
    //         $code = 500;
    //         $message = $ex->getMessage();
    //     }

    //     // Return only necessary instructor data
    //     return response()->json([
    //         'code' => $code,
    //         'message' => $message,

    //     ]);

    // }

    public function updatePromo(Request $request)
    {
        $id = $request->input('promo_id');
        $code = 200;
        $message = "Update Successfully";
        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);
        $temp_items = [];

        try {
            // Delete existing promo items
            DB::delete('DELETE FROM promo_items WHERE promo_id = ?', [$id]);

            $name = $request->input('name');
            $price = $request->input('price');
            $description = $request->input('description');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            // Update promo details
            if ($request->hasFile('image')) {
                $path = $request->file('image')->storePublicly('public/profile');
                $path = str_replace('public', 'storage', $path);

                DB::update('UPDATE promo SET thumbnail = ? WHERE id = ?', [$path, $id]);
            }

            DB::update('UPDATE promo SET name = ?, price = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?', [$name, $price, $description, $start_date, $end_date, $id]);

            // Create new promo items
            foreach ($courses as $course) {
                if ($request->has($course->id)) {
                    $temp_items[] = [
                        'promo_id' => $id,
                        'variant_id' => $request->input($course->id),
                    ];
                }
            }

            // Insert promo items
            foreach ($temp_items as $items) {
                $this->promoItemRepository->create($items);
            }

            $this->updatePromoLog($request->name);
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return response
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }



    public function deletePromo(Request $request)
    {
        $id = $request->input('promo_id');
        $message = "Delete Successfully";
        $code = 200;
        $details = DB::select('Select * FROM promo WHERE id=?', [$id]);
        $name = $details[0]->name; 

        try {
            $delete = DB::delete('DELETE from promo where id=?', [$id]);
            $this->deletePromoLog($name);

        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return response
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
    
    
        public function createPromoLog($name)
        {
            $this->logOperationToDatabase("Create Promo: $name", 1, 'Promo Management');
        }
    
        public function updatePromoLog($name)
        {
            $this->logOperationToDatabase("Update Promo: $name", 2, 'Promo Management');
        }
    
        public function deletePromoLog($name)
        {
            $this->logOperationToDatabase("Delete Promo: $name", 3, 'Promo Management');
        }
    
        public function logOperationToDatabase($description, $operation, $management)
        {
            $id = Auth::user()->schoolid;
            $user_id = Auth::user()->id;
            $name = $this->getName();
    
    
            $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
        }
}
