<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminFilterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function yearSchoolGraph(Request $request)
    {

        $year = $request->input('year');
        $schoolID = $request->input('schoolID');




        $services = [];
        for ($i = 1; $i <= 12; $i++) {
            $result = DB::select('SELECT schools.user_id, schools.name,
            users.profile_image,
            COUNT(DISTINCT orders.id) AS availed_service_count
            FROM schools
            LEFT JOIN users ON users.id = schools.user_id
            LEFT JOIN orders ON schools.user_id = orders.school_id
            WHERE MONTH(orders.date_created) = ? AND YEAR(orders.date_created) = ? AND schools.user_id = ?
            GROUP BY schools.user_id, schools.name, users.profile_image', [$i, $year, $schoolID]);

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
            LEFT JOIN students ON orders.student_id = students.student_id
            WHERE MONTH(orders.date_created) =? AND YEAR(orders.date_created) = ? AND schools.user_id = ?
            GROUP BY schools.user_id, schools.name', [$i, $year, $schoolID]);
            if (count($total) > 0) {
                $completion[] = $total[0]->completion_rate;
            } else {
                $completion[] = 0;
            }
        }

        return view('admin.features.filter.yearSchoolGraph', ['services' => $services, 'completion' => $completion]);
    }



    public function courseStudents(Request $request)
    {
        $year = $request->input('year');
        $schoolID = $request->input('schoolID');
        $courseID = $request->input('courseID');
        $monthStr = $request->input('month');


        $date = Carbon::createFromFormat('F', $monthStr);

        $month = $date->month;


        $students = DB::select('SELECT students.*, users.profile_image, users.email, orders.date_created, order_lists.status, order_lists.course_id 
        FROM students 
        LEFT JOIN users ON users.id = students.student_id 
        LEFT JOIN orders ON students.student_id = orders.student_id and students.student_id = orders.student_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id 
        WHERE orders.school_id=?  AND order_lists.course_id=? and MONTH(orders.date_created) = ? and YEAR(orders.date_created) = ?', [$schoolID, $courseID, $month, $year]);

        return view('admin.features.filter.courseStudent', ['students' => $students]);
    }





    public function studentGraph(Request $request)
    {
        $year = $request->input('year');
        $schoolID = $request->input('schoolID');


        $studentGraph = [];
        for ($i = 1; $i <= 12; $i++) {
            $result = DB::select('SELECT COUNT(DISTINCT student_id) AS count_of_students FROM school_students WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$schoolID, $i, $year]);
            $studentGraph[] = $result[0]->count_of_students;
        }

        return view('admin.features.filter.studentGrowthGraph', ['studentGraph' => $studentGraph]);
    }


    public function studentTable(Request $request)
    {
        $year = $request->input('year');
        $schoolID = $request->input('schoolID');
        $monthStr = $request->input('month');

        $date = Carbon::createFromFormat('F', $monthStr);
        $month = $date->month;


        $students = DB::table('school_students')
            ->join('users', 'users.id', '=', 'school_students.student_id')
            ->join('students', 'school_students.student_id', '=', 'students.student_id')
            ->where('school_students.school_id',  $schoolID)
            ->whereRaw('MONTH(school_students.date_created) = ?', [$month])
            ->whereRaw('YEAR(school_students.date_created) = ?', [$year])
            ->select(['students.*', 'users.email', 'users.phone_number', 'users.profile_image'])
            ->get();


        return view('admin.features.filter.schoolStudentTable', ['students' => $students]);
    }



    public function topSchool()
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $topSchool = DB::select(' SELECT 
        schools.user_id,
        schools.name, 
        schools.address, 
        users.profile_image,
        COUNT(orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate,
        AVG(schools_review.rating) AS average_rating
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN schools_review ON schools.user_id = schools_review.school_id
    WHERE MONTH(orders.date_created) = ? AND YEAR(orders.date_created) = ? 
    GROUP BY schools.user_id, schools.address, schools.name, users.profile_image
    ORDER BY availed_service_count DESC
    LIMIT 5', [$currentMonth, $currentYear]);

        return view('admin.features.filter.top_performing_school_page', ['topSchool' => $topSchool]);
    }



    public function filterTopSchool(Request $request)
    {
        $year = $request->input('year');
        $monthStr = $request->input('month');

        $date = Carbon::createFromFormat('F', $monthStr);
        $month = $date->month;



        $topSchool = DB::select(' SELECT 
        schools.user_id,
        schools.name, 
        schools.address, 
        users.profile_image,
        COUNT(orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate,
        AVG(schools_review.rating) AS average_rating
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN schools_review ON schools.user_id = schools_review.school_id
    WHERE MONTH(orders.date_created) = ? AND YEAR(orders.date_created) = ? 
    GROUP BY schools.user_id, schools.address, schools.name, users.profile_image
    ORDER BY availed_service_count DESC
    LIMIT 5 ', [$month, $year]);


        return view('admin.features.filter.top_performing_school_table', ['topSchool' => $topSchool, 'year' => $year, 'month' => $month]);
    }


    public function  adminFiltercourseViewStudents(Request $request)
    {
        $id = $request->input('school_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $courses = DB::select('SELECT
        courses.*,
        COUNT(orders.id) AS availed_service_count
        FROM courses LEFT JOIN order_lists ON courses.id = order_lists.course_id
        LEFT JOIN orders ON order_lists.order_id = orders.id
        WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ?
        GROUP BY
        courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility, courses.date_created, courses.date_updated', [$id, $start, $end]);

        return view('admin.features.filter.filter_reports_index_table', ['courses' => $courses, 'start_date' => $start_date, 'end_date' => $end_date]);
    }



    public function  adminFilterReportSales(Request $request)
    {
        $id = $request->input('school_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


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
        courses.date_created, courses.date_updated', [$id, $start, $end]);


        return view('admin.features.filter.filter_reports_sales_table', ['sales' => $sales, 'start_date' => $start_date, 'end_date' => $end_date]);
    }



    public function adminSchoolReviewsFilter(Request $request)
    {

        $rating = $request->input('rating');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = $request->input('school_id');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        if ($rating == 0) {
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
                schools_review.school_id = ? AND
                schools_review.date_created BETWEEN ? AND ?
                ', [$id, $start, $end]);
        } else {
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
            schools_review.school_id = ? AND
            schools_review.rating = ? AND 
            schools_review.date_created BETWEEN ? AND ?
            ', [$id, $rating, $start, $end]);
        }

        return view('admin.features.filter.filter_reviews', ['reviews' => $reviews, 'start_date' => $start_date, 'end_date' => $end_date, 'rating' => $rating]);
    }



    public function adminSchoolFilterAvailability(Request $request)
    {

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($status == 0) {
            $schools = DB::select('
            SELECT
            schools.*,
            users.profile_image,
            COUNT(DISTINCT orders.student_id) AS total_students,
            COUNT(DISTINCT instructors.user_id) AS total_instructors,
            COUNT(DISTINCT orders.id) AS availed_service_count,
            ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
        FROM schools
        LEFT JOIN users ON users.id = schools.user_id
        LEFT JOIN instructors ON schools.user_id = instructors.school_id
        LEFT JOIN orders ON schools.user_id = orders.school_id
        LEFT JOIN order_lists ON orders.id = order_lists.order_id
        LEFT JOIN students ON orders.student_id = students.student_id
        WHERE NOT schools.accreditation_status = ? AND schools.date_created BETWEEN ? AND ?
        GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude,schools.date_created, 
           schools.date_updated, users.profile_image, schools.accreditation_status', [1, $start, $end]);
        } else {
            $schools = DB::select('
            SELECT
            schools.*,
            users.profile_image,
            COUNT(DISTINCT orders.student_id) AS total_students,
            COUNT(DISTINCT instructors.user_id) AS total_instructors,
            COUNT(DISTINCT orders.id) AS availed_service_count,
            ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate
        FROM schools
        LEFT JOIN users ON users.id = schools.user_id
        LEFT JOIN instructors ON schools.user_id = instructors.school_id
        LEFT JOIN orders ON schools.user_id = orders.school_id
        LEFT JOIN order_lists ON orders.id = order_lists.order_id
        LEFT JOIN students ON orders.student_id = students.student_id
        WHERE NOT schools.accreditation_status = ?  AND schools.accreditation_status = ?
        AND schools.date_created BETWEEN ? AND ?
        GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude,schools.date_created, 
           schools.date_updated, users.profile_image, schools.accreditation_status', [1, $status, $start, $end]);
        }

        return view('admin.features.filter.filter_schoolAvailability', ['schools' => $schools, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }

    ///newest as in
    public function adminFilterLogs(Request $request)
    {


        $type = $request->input('type');
        $operation = $request->input('operation');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        if ($type == 'All') {
            $logs = DB::select('SELECT * FROM admin_logs where operation = ? AND date_created BETWEEN ? AND ? ORDER BY date_created desc', [$operation, $start, $end]);
        } else {
            $logs = DB::select('SELECT * FROM admin_logs where operation = ? AND management_type = ? AND date_created BETWEEN ? AND ? ORDER BY date_created desc', [$operation, $type, $start, $end]);
        }

        return view('admin.features.filter.filter_logs', ['logs' => $logs]);
    }


    ///revision

    public function filterAdminDasboard(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;


        $start_date_with_time = $start_date . ' 00:00:00';
        $end_date_with_time = $end_date . ' 23:59:59';


        $totalschool = DB::select('SELECT COUNT(*) as total FROM schools where accreditation_status = 2 AND date_created BETWEEN ? AND ?', [$start_date_with_time, $end_date_with_time])[0]->total;
        $totalstudents = DB::select('SELECT COUNT(*) as total FROM users where type = 3 AND created_at BETWEEN ? AND ?', [$start_date_with_time, $end_date_with_time])[0]->total;
        $totalservices = DB::select('SELECT COUNT(*) as total FROM orders where date_created BETWEEN ? AND ? AND status = 5', [$start_date_with_time, $end_date_with_time])[0]->total;
        $pending = DB::select('SELECT COUNT(*) as total FROM schools where accreditation_status = 1 AND date_created BETWEEN ? AND ?', [$start_date_with_time, $end_date_with_time])[0]->total;


        $schoolData = DB::select("
                WITH DateSeries AS (
                    SELECT '$start_date_with_time' + INTERVAL x DAY AS date_range
                    FROM (
                        SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                        FROM information_schema.columns
                    ) AS numbers
                    WHERE '$start_date_with_time' + INTERVAL x DAY <= '$end_date_with_time'
                )
                
                SELECT 
                    DATE(ds.date_range) AS day,
                    COUNT(s.id) AS count_of_schools
                FROM DateSeries ds
                LEFT JOIN schools s ON DATE(s.date_created) = DATE(ds.date_range)
                GROUP BY day
                ORDER BY day
            ");



            $studentData = DB::select("
            WITH DateSeries AS (
                SELECT '$start_date_with_time' + INTERVAL x DAY AS date_range
                FROM (
                    SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                    FROM information_schema.columns
                ) AS numbers
                WHERE '$start_date_with_time' + INTERVAL x DAY <= '$end_date_with_time'
            )
            
            SELECT 
                DATE(ds.date_range) AS day,
                COUNT(u.id) AS count_of_students
            FROM DateSeries ds
            LEFT JOIN users u ON DATE(u.created_at) = DATE(ds.date_range) AND u.type = 3
            GROUP BY day
            ORDER BY day
        ");


        $topSchool = DB::select(' SELECT 
        schools.user_id,
        schools.name, 
        schools.address, 
        users.profile_image,
        COUNT(orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate,
        AVG(schools_review.rating) AS average_rating
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN schools_review ON schools.user_id = schools_review.school_id
    WHERE orders.date_created BETWEEN ?  AND  ? 
    GROUP BY schools.user_id, schools.address, schools.name, users.profile_image
    ORDER BY availed_service_count DESC
    LIMIT 5', [$start_date_with_time, $end_date_with_time]);
        
        return view('admin.features.filter.filter_dashboard', ['totalschool' => $totalschool,'totalstudents' => $totalstudents, 'totalservices'=> $totalservices, 'pending' => $pending,'schoolData' => $schoolData, 'studentData' => $studentData, 'start_date' => $start_date, 'end_date' => $end_date, 'topSchool' => $topSchool]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
