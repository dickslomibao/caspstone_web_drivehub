<?php

namespace App\Http\Controllers\Admin;


use App\Classes\Account;
use App\Http\Controllers\Controller;
use App\Mail\NotifySchool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;
use Mail;


class DrivingSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        ///new
        $schools = DB::select('
        SELECT
        schools.*,
        users.profile_image,
        COUNT(DISTINCT orders.student_id) AS total_students,
        COUNT(DISTINCT instructors.user_id) AS total_instructors,
        COUNT(DISTINCT orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN instructors ON schools.user_id = instructors.school_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN students ON orders.student_id = students.student_id
    WHERE NOT schools.accreditation_status = ?
    GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude,schools.date_created, 
       schools.date_updated, users.profile_image, schools.accreditation_status', [1]);

        return view('admin.features.driving_school_management.index', ['schools' => $schools]);
    }

    public function notifySchool(Request $request, $id)
    {

        $school = DB::table('users')->where('id', $id)->first();
        Mail::to($school->email)->send(
            new NotifySchool(
                [
                    'content' => $request->content,
                ]
            )
        );
        return redirect()->back()->with('message', $school->email . ' Notify Successfully');
    }



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
            ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
            FROM schools
            LEFT JOIN orders ON schools.user_id = orders.school_id
            LEFT JOIN order_lists ON orders.id = order_lists.order_id
            LEFT JOIN students ON orders.student_id = students.student_id
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

        $details = DB::select('SELECT
        schools.*,
        users.profile_image,
        COUNT(DISTINCT orders.student_id) AS total_students,
        COUNT(DISTINCT instructors.user_id) AS total_instructors,
        COUNT(DISTINCT orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate,
       AVG(schools_review.rating) AS average_rating,
COUNT(DISTINCT schools_review.id) AS total_reviews
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN instructors ON schools.user_id = instructors.school_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN students ON orders.student_id = students.student_id
    LEFT JOIN schools_review ON schools.user_id = schools_review.school_id
     WHERE users.id = ?
    GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude,schools.date_created, 
       schools.date_updated, users.profile_image, schools.accreditation_status', [$id]);

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


        $students = DB::select('SELECT students.*, users.profile_image, users.email, orders.date_created, order_lists.status, order_lists.course_id 
        FROM students 
        LEFT JOIN users ON users.id = students.student_id 
        LEFT JOIN orders ON students.student_id = orders.student_id and students.student_id = orders.student_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id 
        WHERE orders.school_id=?  AND order_lists.course_id=? AND MONTH(orders.date_created) = ? and YEAR(orders.date_created) =? ', [$schoolID, $courseID, $lastMonth, $currentYear]);

        return view('admin.features.driving_school_management.course_details', ['details' => $details, 'course' => $course, 'students' => $students]);
    }



    public function schoolStudentsDetails($id)
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
            $result = DB::select('SELECT COUNT(DISTINCT student_id) AS count_of_students FROM school_students WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear]);
            $studentGraph[] = $result[0]->count_of_students;
        }

        $students = DB::table('school_students')
            ->join('users', 'users.id', '=', 'school_students.student_id')
            ->join('students', 'school_students.student_id', '=', 'students.student_id')
            ->where('school_students.school_id', $id)
            ->whereRaw('MONTH(school_students.date_created) = ?', [$lastMonth])
            ->whereRaw('YEAR(school_students.date_created) = ?', [$currentYear])
            ->select(['students.*', 'users.email', 'users.phone_number', 'users.profile_image'])
            ->get();

        //     $students = DB::select('SELECT
        //     students.*,
        //     users.profile_image,
        //     users.email,
        //     COUNT(DISTINCT orders.id) AS availed_service_count,
        //     order_lists.course_id,
        //     courses.name,
        //     ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(DISTINCT orders.id)) * 100, 2) AS completion_rate
        // FROM
        //     students
        // LEFT JOIN users ON users.id = students.student_id
        // LEFT JOIN orders ON students.student_id = orders.student_id
        // LEFT JOIN order_lists ON orders.id = order_lists.order_id
        // LEFT JOIN courses ON order_lists.course_id = courses.id
        // WHERE
        //     order_lists.course_id IS NOT NULL
        //     AND orders.school_id = ? AND MONTH(orders.date_created) = ?
        //     AND YEAR(orders.date_created) = ?
        // GROUP BY
        //     students.student_id, students.firstname, students.middlename, students.lastname,  students.sex, students.birthdate, students.address, students.date_created,students.date_updated, users.profile_image, users.email, order_lists.course_id, courses.name, MONTH(orders.date_created)', [$id, $lastMonth, $currentYear]);

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
            $lastInsertedId = $user->id;
            DB::table('schools')->insertGetId([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            $blank = "";
            $insert = DB::insert('insert into accreditation (school_id, validID1, validID2, DTI, LTO, city_permit, BFP) values (?, ?, ?, ?, ?, ?, ?)', [$lastInsertedId, $blank, $blank, $blank, $blank, $blank, $blank]);
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function schoolReportsDetails($id)
    {
        $details = $this->getSchoolDetails($id);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orders FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->count_of_orders;
            $orderData[] = $total;
        }

        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT SUM(total_amount) AS total_sales FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->total_sales;
            $salesData[] = $total;
        }


        $currentDate = Carbon::now()->toDateString();

        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();

        $start1 = $currentDate . ' 00:00:00';
        $end1 = $currentDate . ' 23:59:59';

        $courses = DB::select('SELECT
        courses.*,
        COUNT(orders.id) AS availed_service_count
        FROM courses LEFT JOIN order_lists ON courses.id = order_lists.course_id
        LEFT JOIN orders ON order_lists.order_id = orders.id
        WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ?
        GROUP BY
        courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility, courses.date_created, courses.date_updated', [$id, $start1, $end1]);

        $sales = DB::select('SELECT
        courses.*,
        COUNT(orders.id) AS availed_service_count,
        SUM(orders.total_amount) AS total_sales,
        COALESCE(SUM(cash_payment.amount), 0) AS total_cash_payments
        FROM courses
        LEFT JOIN order_lists ON courses.id = order_lists.course_id
        LEFT JOIN orders ON order_lists.order_id = orders.id
        LEFT JOIN cash_payment ON order_lists.order_id = cash_payment.order_id
        WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ?
        GROUP BY courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility,
        courses.date_created, courses.date_updated', [$id, $start1, $end1]);

        return view('admin.features.driving_school_management.schoolReports', ['details' => $details, 'orderData' => $orderData, 'courses' => $courses, 'start' => $start, 'end' => $end, 'sales' => $sales, 'salesData' => $salesData]);
    }


    public function adminRetreiveWeeklyReport($id)
    {

        $ordersTable = 'orders';

        // Get the current date
        $currentDate = Carbon::now();

        // Find the most recent Sunday
        $currentDate->startOfWeek(); // Move to the start of the week (default is Sunday)

        // Calculate the start and end dates for the week
        $startDate = $currentDate->format('Y-m-d');
        $endDate = $currentDate->addDays(6)->format('Y-m-d');


        $query = "

          WITH RECURSIVE DateSeries AS (
            SELECT '$startDate' AS date
            UNION
            SELECT date + INTERVAL 1 DAY
            FROM DateSeries
            WHERE date < '$endDate' 
        )
        SELECT
            CONCAT(DATE_FORMAT(ds.date, '%a'), ' ', DATE_FORMAT(ds.date, '%b %e')) AS formatted_date,
            (DAYOFWEEK(ds.date) + 5) % 7 + 1 AS day_of_week,
            COUNT(o.id) AS total
        FROM
            DateSeries ds
            LEFT JOIN orders o ON DATE(o.date_created) = ds.date
                AND o.school_id = '$id' AND o.status = 5
        GROUP BY
            day_of_week, ds.date
        ORDER BY
            day_of_week

          ";

        $results = DB::select(DB::raw($query));
        return response()->json($results);
    }


    public function adminRetreiveWeeklyReportSales($id)
    {



        $ordersTable = 'orders';

        // Get the current date
        $currentDate = Carbon::now();

        // Find the most recent Sunday
        $currentDate->startOfWeek(); // Move to the start of the week (default is Sunday)

        // Calculate the start and end dates for the week
        $startDate = $currentDate->format('Y-m-d');
        $endDate = $currentDate->addDays(6)->format('Y-m-d');


        $query = "

          WITH RECURSIVE DateSeries AS (
            SELECT '$startDate' AS date
            UNION
            SELECT date + INTERVAL 1 DAY
            FROM DateSeries
            WHERE date < '$endDate' 
        )
        SELECT
            CONCAT(DATE_FORMAT(ds.date, '%a'), ' ', DATE_FORMAT(ds.date, '%b %e')) AS formatted_date,
            (DAYOFWEEK(ds.date) + 5) % 7 + 1 AS day_of_week,
            COALESCE(SUM(o.total_amount), 0) AS total_amount
        FROM
            DateSeries ds
            LEFT JOIN orders o ON DATE(o.date_created) = ds.date
                AND o.school_id = '$id' AND o.status = 5
        GROUP BY
            day_of_week, ds.date
        ORDER BY
            day_of_week

          ";

        $results = DB::select(DB::raw($query));
        return response()->json($results);
    }


    public function schoolReviewsDetails($id)
    {
        $details = $this->getSchoolDetails($id);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $reviews = DB::select('SELECT
        students.firstname, students.middlename, students.lastname, schools_review.*,
        courses.name, courses_variant.duration
        FROM
        schools_review
        LEFT JOIN students ON schools_review.student_id = students.student_id
        LEFT JOIN order_lists ON schools_review.order_id = order_lists.order_id
        LEFT JOIN courses ON order_lists.course_id = courses.id 
        LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id AND courses_variant.course_id = courses.id
        WHERE
        schools_review.school_id = ?
        ORDER BY
        schools_review.date_created desc
        ', [$id]);


        return view('admin.features.driving_school_management.schoolReviews', ['details' => $details, 'reviews' => $reviews]);
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
