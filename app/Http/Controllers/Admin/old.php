<?php

namespace App\Http\Controllers\Admin;


use App\Classes\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;



class DrivingSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // $schools = DB::table('schools')->paginate(2);
        // return view('admin.features.driving_school_management.index', ['schools'=>$schools]);

    //     $schools = DB::select('
    //     SELECT
    //     schools.*,
    //     users.profile_image,
    //     COUNT(DISTINCT school_students.student_id) AS total_students,
    //     COUNT(DISTINCT instructors.user_id) AS total_instructors,
    //     COUNT(DISTINCT orders.id) AS availed_service_count,
    //     ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
    // FROM schools
    // LEFT JOIN users ON users.id = schools.user_id
    // LEFT JOIN school_students ON schools.user_id = school_students.school_id
    // LEFT JOIN instructors ON schools.user_id = instructors.school_id
    // LEFT JOIN orders ON schools.user_id = orders.school_id
    // LEFT JOIN order_lists ON orders.id = order_lists.order_id
    // WHERE schools.status = 1
    // GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude, schools.status, schools.date_created, 
    //    schools.date_updated, users.profile_image');


    $schools = DB::select('
    SELECT
    schools.*,
    users.profile_image,
    COUNT(DISTINCT school_students.student_id) AS total_students,
    COUNT(DISTINCT instructors.user_id) AS total_instructors,
    COUNT(DISTINCT orders.id) AS availed_service_count,
    ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
FROM schools
LEFT JOIN users ON users.id = schools.user_id
LEFT JOIN school_students ON schools.user_id = school_students.school_id
LEFT JOIN instructors ON schools.user_id = instructors.school_id
LEFT JOIN orders ON schools.user_id = orders.school_id
LEFT JOIN order_lists ON orders.id = order_lists.order_id

GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude,schools.date_created, 
   schools.date_updated, users.profile_image');

        return view('admin.features.driving_school_management.index', ['schools' => $schools]);
    }




    /*   public function retrieveDrivingSchools()
    {
        $schools = DB::table('schools')->get();


      $schools = DB::select('
        SELECT schools.*, 
               COUNT(DISTINCT school_students.student_id) AS total_students, 
               COUNT(DISTINCT instructors.user_id) AS total_instructors 
        FROM schools
        LEFT JOIN school_students ON schools.user_id = school_students.school_id
        LEFT JOIN instructors ON schools.user_id = instructors.school_id
        GROUP BY schools.user_id');*/


    // $schools = DB::table('schools')
    // ->select('schools.*')
    // ->selectRaw('COUNT(DISTINCT school_students.student_id) AS total_students')
    // ->selectRaw('COUNT(DISTINCT instructors.user_id) AS total_instructors')
    // ->leftJoin('school_students', 'schools.user_id', '=', 'school_students.school_id')
    // ->leftJoin('instructors', 'schools.user_id', '=', 'instructors.school_id')
    // ->groupBy('schools.user_id')
    // ->get();


    // return json_encode($schools);
    //  }




    public function redirectRegisterSchoolPage()
    {
        return view('admin.features.driving_school_management.register');
    }

    /////////////////////////////////////////////////////need 
    public function schoolDetails($id)
    {

        $details = $this->getSchoolDetails($id);

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $services = [];
        for ($i = 1; $i <= 12; $i++) {
            $result = DB::select('
            SELECT schools.user_id, schools.name,
            users.profile_image,
            COUNT(DISTINCT orders.id) AS availed_service_count
            FROM schools
            LEFT JOIN users ON users.id = schools.user_id
            LEFT JOIN orders ON schools.user_id = orders.school_id
            WHERE MONTH(orders.date_created) = ? AND YEAR(orders.date_created) = ? AND schools.user_id = ?
            GROUP BY schools.user_id, schools.name, users.profile_image', [$i, $currentYear, $id]);


            // Check if any rows were returned
            if (count($result) > 0) {
                $services[] = $result[0]->availed_service_count;
            } else {
                $services[] = 0;
            }
        }


        $completion = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT schools.user_id, schools.name,
            ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
            FROM schools
            LEFT JOIN orders ON schools.user_id = orders.school_id
            LEFT JOIN order_lists ON orders.id = order_lists.order_id
            LEFT JOIN school_students ON schools.user_id = school_students.school_id
            WHERE MONTH(orders.date_created) =? AND YEAR(orders.date_created) = ? AND schools.user_id = ?
            GROUP BY schools.user_id, schools.name', [$i, $currentYear, $id]);
            if (count($total) > 0) {
                $completion[] = $total[0]->completion_rate;
            } else {
                $completion[] = 0;
            }
        }




        return view('admin.features.driving_school_management.more_details', ['details' => $details, 'services' => $services, 'completion' => $completion]);
    }




    public function getSchoolDetails($id)
    {
        $details = DB::select('SELECT schools.*, 
            users.profile_image,
            COUNT(DISTINCT school_students.student_id) AS total_students, 
            COUNT(DISTINCT instructors.user_id) AS total_instructors,
            COUNT(orders.id) AS availed_service_count,
            ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
            FROM schools
            LEFT JOIN users ON users.id = schools.user_id
            LEFT JOIN orders ON schools.user_id = orders.school_id
            LEFT JOIN order_lists ON orders.id = order_lists.order_id
            LEFT JOIN school_students ON schools.user_id = school_students.school_id
            LEFT JOIN instructors ON schools.user_id = instructors.school_id
            WHERE users.id = ? 
            GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude, schools.status, schools.date_created, 
            schools.date_updated, users.profile_image', [$id]);

        return $details[0];
    }




    public function schoolCourses($id)
    {
        $details = $this->getSchoolDetails($id);

        $datarow = "";

        $courses = DB::select('SELECT * FROM courses WHERE school_id =?', [$id]);
        if (count($courses) <= 0) {
            $datarow = "None";
        }

        return view('admin.features.driving_school_management.courses', ['details' => $details, 'courses' => $courses, 'datarow' => $datarow]);
    }


    public function courseDetails($schoolID, $courseID)
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        if ($currentMonth == 1) {
            $lastMonth = 12;
            $currentYear = ($currentYear - 1);
        } else {
            $lastMonth = ($currentMonth - 1);
        }


        $details = $this->getSchoolDetails($schoolID);

        $datarow = "";

        $courses = DB::select('SELECT * FROM courses WHERE id =?', [$courseID]);
        $course = $courses[0];


        $students = DB::select('SELECT school_students.*, 
 		users.profile_image, users.email, orders.date_created, order_lists.status, order_lists.course_id
        FROM school_students
        LEFT JOIN users ON users.id = school_students.student_id
		LEFT JOIN orders ON school_students.student_id = orders.student_id and school_students.student_id = orders.student_id
		LEFT JOIN order_lists ON orders.id = order_lists.order_id
        WHERE orders.school_id=? AND order_lists.course_id=? and MONTH(orders.date_created) = ? and YEAR(orders.date_created) = ?', [$schoolID, $courseID, $lastMonth, $currentYear]);


        // $courses = DB::select('SELECT * FROM courses WHERE id =?', [$courseID]);


        return view('admin.features.driving_school_management.course_details', ['details' => $details, 'course' => $course, 'students' => $students]);
    }



    public function  schoolStudentsDetails($id)
    {
        $details = $this->getSchoolDetails($id);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        if ($currentMonth == 1) {
            $lastMonth = 12;
            $currentYear = ($currentYear - 1);
        } else {
            $lastMonth = ($currentMonth - 1);
        }

        $studentGraph = [];
        for ($i = 1; $i <= 12; $i++) {
            $result = DB::select('
            SELECT COUNT(*) AS count_of_students FROM school_students WHERE 
            school_id =? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear]);
            $studentGraph[] = $result[0]->count_of_students;
        }



        $students = DB::select('SELECT school_students.*, users.profile_image, users.email, COUNT(DISTINCT orders.id) AS availed_service_count, 
        order_lists.course_id, courses.name, ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(DISTINCT orders.id)) * 100, 2) AS completion_rate 
        FROM school_students LEFT JOIN users ON users.id = school_students.student_id 
        LEFT JOIN schools ON schools.user_id = school_students.school_id 
        LEFT JOIN orders ON school_students.student_id = orders.student_id AND school_students.school_id = orders.school_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id 
        LEFT JOIN courses ON order_lists.course_id = courses.id WHERE school_students.school_id = ? 
        AND MONTH(school_students.date_created) = ? AND YEAR(school_students.date_created) = ? 
        GROUP BY school_students.id, school_students.student_id, school_students.school_id, school_students.firstname, school_students.middlename, school_students.lastname, school_students.sex, school_students.mobile_number, school_students.birthdate, school_students.birthplace, school_students.address, school_students.date_created, school_students.date_updated, users.profile_image, users.email, order_lists.course_id, courses.name', [$id, $lastMonth, $currentYear]);

        return view('admin.features.driving_school_management.schoolStudents', ['details' => $details, 'studentGraph' => $studentGraph, 'students' => $students]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $message = "Added Successfully";
        $user = null;
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'name' => ['required', 'max:255'],
                'address' => ['required', 'max:255'],
                'latitude' => ['required'],
                'longitude' => ['required']
            ]);
            $path = $request->file('image')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);
            $user = Account::createAccount(
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'profile_image' => $path,
                ]
            );
            DB::table('schools')->insertGetId([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => $request->status,

            ]);

        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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