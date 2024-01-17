<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::user()->schoolid;
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orders FROM orders WHERE school_id = ? AND MONTH(date_updated) = ? AND YEAR(date_updated) = ? AND status = ?', [$id, $i, $currentYear, 5])[0]->count_of_orders;
            $orderData[] = $total;
        }


        $orderYear = [];
        for ($i = 2023; $i <= 2030; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orderYear FROM orders WHERE school_id = ? AND YEAR(date_updated) = ?  AND status = ?', [$id, $i, 5])[0]->count_of_orderYear;
            $orderYear[] = $total;
        }


        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT SUM(total_amount) AS total_sales FROM orders WHERE school_id = ? AND MONTH(date_updated) = ? AND YEAR(date_updated) = ? AND status = ?', [$id, $i, $currentYear, 5])[0]->total_sales;
            $salesData[] = $total;
        }


        $salesYear = [];
        for ($i = 2023; $i <= 2030; $i++) {
            $total = DB::select('SELECT SUM(total_amount) AS total_sales_year FROM orders WHERE school_id = ? AND YEAR(date_updated) = ? AND status = ?', [$id, $i, 5])[0]->total_sales_year;
            $salesYear[] = $total;
        }

        $currentDate = Carbon::now()->toDateString();

        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();

        $start1 = $currentDate . ' 00:00:00';
        $end1 = $currentDate . ' 23:59:59';

        $courses = DB::select('SELECT
         courses.*,
         COUNT(orders.id) AS availed_service_count
         FROM courses 
         LEFT JOIN order_lists ON courses.id = order_lists.course_id
         LEFT JOIN orders ON order_lists.order_id = orders.id 
         WHERE orders.school_id = ? AND orders.date_updated BETWEEN ? AND ? AND orders.status = 5
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
        return view('school.features.report_management.index', ['orderData' => $orderData, 'orderYear' => $orderYear, 'courses' => $courses, 'start' => $start, 'end' => $end, 'salesData' => $salesData, 'salesYear' => $salesYear, 'sales' => $sales]);
    }


    public function retreiveWeeklyReport()
    {

        $id = Auth::user()->schoolid;

        $ordersTable = 'orders';

        // Get the current date
        $currentDate = Carbon::now();

        // Find the most recent Sunday
        $currentDate->startOfWeek(); // Move to the start of the week (default is Sunday)

        // Calculate the start and end dates for the week
        $startDate = $currentDate->format('Y-m-d');
        $endDate = $currentDate->addDays(6)->format('Y-m-d');




        // $query  = " 
        // WITH RECURSIVE DateSeries AS (
        //     SELECT '$startDate' AS date
        //   UNION
        //   SELECT
        //     date + INTERVAL 1 DAY
        //   FROM
        //     DateSeries
        //     WHERE date < '$endDate'
        // )
        // SELECT
        //   DAYNAME(ds.date) AS DAY,
        //   COUNT(o.id) AS total
        // FROM
        //   DateSeries ds
        //   LEFT JOIN $ordersTable o ON DATE(o.date_created) = ds.date
        //   AND o.school_id = '9a201bf3-1e3e-46ec-bb5c-283fb8f012f9'
        // GROUP BY
        //   DAY
        // ORDER BY
        //   DAYOFWEEK(ds.date)";


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
            LEFT JOIN orders o ON DATE(o.date_updated) = ds.date
                AND o.school_id = '$id' AND o.status = 5
        GROUP BY
            day_of_week, ds.date
        ORDER BY
            day_of_week

          ";

        $results = DB::select(DB::raw($query));



        //return dd($results);



        // Return the data as JSON
        return response()->json($results);
    }

    //////new sunday////
    public function viewCourseStudents($course_id, $course_name, $startDate, $endDate)
    {

        $currentDate = Carbon::now()->toDateString();
        $start = $startDate . ' 00:00:00';
        $end = $endDate . ' 23:59:59';


        $students = DB::select('SELECT
         students.*,
         users.email,
         users.phone_number,
         users.profile_image,
         courses_variant.duration
     FROM
         students
     LEFT JOIN
         users ON students.student_id = users.id
     LEFT JOIN
         orders ON students.student_id = orders.student_id
     LEFT JOIN
         order_lists ON orders.id = order_lists.order_id
     LEFT JOIN
         courses ON order_lists.course_id = courses.id
     LEFT JOIN
         courses_variant ON order_lists.variant_id = courses_variant.id 
     WHERE
         order_lists.course_id = ?
         AND orders.date_created BETWEEN ? AND ?
     ', [$course_id, $start, $end]);


        $variants = DB::select('SELECT * FROM courses_variant WHERE course_id = ?', [$course_id]);

        return view('school.features.report_management.courseStudents', ['students' => $students, 'course_id' => $course_id, 'course_name' => $course_name, 'variants' => $variants, 'start_date' => $startDate, 'end_date' => $endDate]);
    }







    public function retreiveWeeklyReportSales()
    {

        $id = Auth::user()->schoolid;

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
             LEFT JOIN orders o ON DATE(o.date_updated) = ds.date
                 AND o.school_id = '$id' AND o.status = 5
         GROUP BY
             day_of_week, ds.date
         ORDER BY
             day_of_week
 
           ";

        $results = DB::select(DB::raw($query));
        return response()->json($results);
    }


    public function viewCourseSalesStudents($course_id, $course_name, $startDate, $endDate)
    {

        $start = $startDate . ' 00:00:00';
        $end = $endDate . ' 23:59:59';


        $students = DB::select('SELECT
         students.*,
         users.email,
         users.phone_number,
         users.profile_image,
         courses_variant.duration,
         courses_variant.price,
         COALESCE(SUM(cash_payment.amount), 0) AS total_cash_payments
          FROM students 
          LEFT JOIN users ON students.student_id = users.id
          LEFT JOIN orders ON students.student_id = orders.student_id
          LEFT JOIN order_lists ON orders.id = order_lists.order_id
          LEFT JOIN courses ON order_lists.course_id = courses.id
         LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id 
         LEFT JOIN cash_payment ON order_lists.order_id = cash_payment.order_id
         WHERE order_lists.course_id = ? AND orders.date_created BETWEEN ? AND ?
         GROUP BY order_lists.order_id, students.student_id, students.firstname, students.middlename, students.lastname, students.sex, students.birthdate, students.address, students.date_created,students.date_updated, users.profile_image, users.phone_number, users.email, courses_variant.duration, courses_variant.price', [$course_id, $start, $end]);


        $variants = DB::select('SELECT * FROM courses_variant WHERE course_id = ?', [$course_id]);

        return view('school.features.report_management.courseStudentsSales', ['students' => $students, 'course_id' => $course_id, 'course_name' => $course_name, 'variants' => $variants, 'start_date' => $startDate, 'end_date' => $endDate]);
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
