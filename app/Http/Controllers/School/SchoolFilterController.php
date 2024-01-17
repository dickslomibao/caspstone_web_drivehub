<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SchoolFilterController extends Controller
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



    public function  filterOrdersPayment(Request $request)
    {

        $status = $request->input('status');
        $payment = $request->input('payment');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;


        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if (($status == 0) && ($payment == 0)) {
            $orders = DB::select('SELECT students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image, orders.*, sum(cash_payment.amount) as total_paid FROM orders 
            LEFT JOIN students ON orders.student_id = students.student_id 
            LEFT JOIN users ON students.student_id = users.id 
            LEFT JOIN cash_payment ON orders.id = cash_payment.order_id 
            WHERE orders.school_id=? 
            AND orders.date_created BETWEEN ? AND ?
            GROUP BY orders.school_id, orders.id, orders.student_id, 
            orders.total_amount, orders.payment_type, orders.status, orders.promo_id, orders.date_created, 
            orders.date_updated, students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image', [$id, $start, $end]);
        } else if (($status == 0) && ($payment !== 0)) {
            $orders = DB::select('SELECT students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image, orders.*, sum(cash_payment.amount) as total_paid FROM orders 
            LEFT JOIN students ON orders.student_id = students.student_id 
            LEFT JOIN users ON students.student_id = users.id 
            LEFT JOIN cash_payment ON orders.id = cash_payment.order_id 
            WHERE orders.school_id=? AND orders.payment_type = ? 
            AND orders.date_created BETWEEN ? AND ?
            GROUP BY orders.school_id, orders.id, orders.student_id, 
            orders.total_amount, orders.payment_type, orders.status, orders.promo_id, orders.date_created, 
            orders.date_updated, students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image', [$id, $payment, $start, $end]);
        } else if (($status !== 0) && ($payment == 0)) {
            $orders = DB::select('SELECT students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image, orders.*, sum(cash_payment.amount) as total_paid FROM orders 
            LEFT JOIN students ON orders.student_id = students.student_id 
            LEFT JOIN users ON students.student_id = users.id 
            LEFT JOIN cash_payment ON orders.id = cash_payment.order_id 
            WHERE orders.school_id=? AND orders.status = ? 
            AND orders.date_created BETWEEN ? AND ?
            GROUP BY orders.school_id, orders.id, orders.student_id, 
            orders.total_amount, orders.payment_type, orders.status, orders.promo_id, orders.date_created, 
            orders.date_updated, students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image', [$id, $status, $start, $end]);
        } else if (($status !== 0) && ($payment !== 0)) {
            $orders = DB::select('SELECT students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image, orders.*, sum(cash_payment.amount) as total_paid FROM orders 
            LEFT JOIN students ON orders.student_id = students.student_id 
            LEFT JOIN users ON students.student_id = users.id 
            LEFT JOIN cash_payment ON orders.id = cash_payment.order_id 
            WHERE orders.school_id=? AND orders.status = ? AND orders.payment_type = ? 
            AND orders.date_created BETWEEN ? AND ?
            GROUP BY orders.school_id, orders.id, orders.student_id, 
            orders.total_amount, orders.payment_type, orders.status, orders.promo_id, orders.date_created, 
            orders.date_updated, students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image', [$id, $status, $payment, $start, $end]);
        }


        return view('school.features.filter.filter_ordersPayment', ['orders' => $orders, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status, 'payment' => $payment]);
    }


    // public function filterOrdersPayment(Request $request)
    // {
    //     $status = $request->input('status');
    //     $payment = $request->input('payment');
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date');
    //     $id = Auth::user()->schoolid;

    //     $start = $start_date . ' 00:00:00';
    //     $end = $end_date . ' 23:59:59';

    //     $name = $this->getName();
    //     $school = $this->getSchool($id);

    //     $query = DB::table('orders')
    //         ->leftJoin('students', 'orders.student_id', '=', 'students.student_id')
    //         ->leftJoin('users', 'students.student_id', '=', 'users.id')
    //         ->leftJoin('cash_payment', 'orders.id', '=', 'cash_payment.order_id')
    //         ->where('orders.school_id', $id)
    //         ->whereBetween('orders.date_created', [$start, $end])
    //         ->groupBy(
    //             'orders.school_id',
    //             'orders.id',
    //             'orders.student_id',
    //             'orders.total_amount',
    //             'orders.payment_type',
    //             'orders.status',
    //             'orders.promo_id',
    //             'orders.date_created',
    //             'orders.date_updated',
    //             'students.student_id',
    //             'students.firstname',
    //             'students.middlename',
    //             'students.lastname',
    //             'users.email',
    //             'users.profile_image'
    //         );

    //     if ($status !== 0) {
    //         $query->where('orders.status', $status);
    //     }

    //     if ($payment !== 0) {
    //         $query->where('orders.payment_type', $payment);
    //     }

    //     $orders = $query->select(
    //         'students.student_id',
    //         'students.firstname',
    //         'students.middlename',
    //         'students.lastname',
    //         'users.email',
    //         'users.profile_image',
    //         'orders.*',
    //         DB::raw('SUM(cash_payment.amount) as total_paid')
    //     )->get();

    //     return view('school.features.filter.filter_ordersPayment', [
    //         'orders' => $orders,
    //         'start_date' => $start_date,
    //         'end_date' => $end_date,
    //         'status' => $status,
    //         'payment' => $payment
    //     ]);
    // }




    public function  filterAvailedCourses(Request $request)
    {

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;


        $start_date_with_time = $start_date . ' 00:00:00';
        $end_date_with_time = $end_date . ' 23:59:59';

        $name = $this->getName();
        $school = $this->getSchool($id);

        if ($status == 0) {
            $students = DB::table('order_lists')
                ->join('orders', 'order_lists.order_id', '=', 'orders.id')
                ->join('courses', 'order_lists.course_id', '=', 'courses.id')
                ->join('students', 'orders.student_id', '=', 'students.student_id')
                ->join('users', 'orders.student_id', '=', 'users.id')
                ->whereIn('orders.status', [4, 5])
                ->where('orders.school_id', $id)
                //->whereBetween('order_lists.date_created', [$start_date, $end_date])
                ->whereBetween('order_lists.date_created', [$start_date_with_time, $end_date_with_time])
                ->orderBy('order_lists.date_created', 'desc')
                ->select([
                    'order_lists.id',
                    'order_lists.duration',
                    'order_lists.type',
                    'order_lists.session',
                    'order_lists.status',
                    'order_lists.date_created',
                    'order_lists.remarks',
                    'students.firstname',
                    'students.middlename',
                    'students.lastname',
                    'users.email',
                    'users.profile_image',
                    'courses.name',
                    'students.student_id',
                ])
                ->get();
        } else {
            $students = DB::table('order_lists')
                ->join('orders', 'order_lists.order_id', '=', 'orders.id')
                ->join('courses', 'order_lists.course_id', '=', 'courses.id')
                ->join('students', 'orders.student_id', '=', 'students.student_id')
                ->join('users', 'orders.student_id', '=', 'users.id')
                ->where('orders.school_id', $id)
                ->where('order_lists.status', $status)
                ->whereIn('orders.status', [4, 5])
                //->whereBetween('order_lists.date_created', [$start_date, $end_date])
                ->whereBetween('order_lists.date_created', [$start_date_with_time, $end_date_with_time])
                ->orderBy('order_lists.date_created', 'desc')
                ->select([
                    'order_lists.id',
                    'order_lists.duration',
                    'order_lists.type',
                    'order_lists.session',
                    'order_lists.status',
                    'order_lists.date_created',
                    'order_lists.remarks',
                    'students.firstname',
                    'students.middlename',
                    'students.lastname',
                    'users.email',
                    'users.profile_image',
                    'courses.name',
                    'students.student_id',
                ])
                ->get();
        }


        return view('school.features.filter.filter_availedCourses', ['students' => $students, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }



    public function filterCourses(Request $request)
    {

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($status == 0) {
            $courses = DB::select('SELECT * FROM courses WHERE school_id = ? AND date_created BETWEEN ? AND ?', [$id, $start, $end]);
        } else {
            $courses = DB::select('SELECT * FROM courses WHERE status = ?  AND school_id = ? AND date_created BETWEEN ? AND ?', [$status, $id, $start, $end]);
        }

        return view('school.features.filter.filter_courses', ['courses' => $courses, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }


    public function filterTheoreticalSched(Request $request)
    {

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($status == 0) {
            $schedules = DB::select('SELECT theoritical_schedules.*, schedules.start_date, schedules.end_date, schedules.status FROM theoritical_schedules LEFT JOIN schedules ON theoritical_schedules.schedule_id = schedules.id WHERE schedules.school_id = ? AND schedules.start_date BETWEEN ? AND ?', [$id, $start, $end]);
        } else {
            $schedules = DB::select('SELECT theoritical_schedules.*, schedules.start_date, schedules.end_date, schedules.status FROM theoritical_schedules LEFT JOIN schedules ON theoritical_schedules.schedule_id = schedules.id WHERE schedules.school_id = ? AND schedules.status = ? AND schedules.start_date BETWEEN ? AND ?', [$id, $status, $start, $end]);
        }

        return view('school.features.filter.filter_theoreticalSched', ['schedules' => $schedules, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }

    public function filterVehicles(Request $request)
    {
        $type = $request->input('type');
        $transmission = $request->input('transmission');
        $fuel = $request->input('fuel');
        $id = Auth::user()->schoolid;

        $vehicles = DB::select('SELECT * FROM vehicles WHERE school_id = ? AND type = ? AND transmission = ? AND fuel = ?', [$id, $type, $transmission, $fuel]);
        return view('school.features.filter.filter_vehicles', ['vehicles' => $vehicles, 'type' => $type, 'transmission' => $transmission, 'fuel' => $fuel]);
    }


    public function  filterPromo(Request $request)
    {

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $promos = DB::select('SELECT * FROM promo WHERE school_id = ? AND
        start_date >= ?
        AND end_date <= ?
        ', [$id, $start, $end]);
        return view('school.features.filter.filter_promo', ['promos' => $promos, 'start_date' => $start_date, 'end_date' => $end_date]);
    }



    public function filterQuestions(Request $request)
    {

        $status = $request->input('status');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($status == 0) {
            $questions = DB::select('SELECT questions.*, question_choices.body FROM questions LEFT JOIN question_choices ON questions.id = question_choices.question_id AND questions.answer = question_choices.code WHERE questions.school_id = ? AND questions.date_created BETWEEN ? AND ?', [$id, $start, $end]);
        } else {
            $questions = DB::select('SELECT questions.*, question_choices.body FROM questions LEFT JOIN question_choices ON questions.id = question_choices.question_id AND questions.answer = question_choices.code WHERE questions.school_id = ? AND questions.status = ? AND questions.date_created BETWEEN ? AND ?', [$id, $status, $start, $end]);
        }

        return view('school.features.filter.filter_questions', ['questions' => $questions, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }


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


    public function getSchool($id)
    {
        $school = DB::select('Select schools.*, users.profile_image, users.phone_number, users.email FROM schools
        INNER JOIN users ON users.id = schools.user_id  WHERE schools.user_id=?', [$id]);

        return $school[0];
    }


    public function schoolReviewsFilter(Request $request)
    {

        $rating = $request->input('rating');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;

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

        return view('school.features.filter.filter_reviews', ['reviews' => $reviews, 'start_date' => $start_date, 'end_date' => $end_date, 'rating' => $rating]);
    }



    ///////new sunday///////////////
    public function viewCourseStudentsExportPDF($course_id, $course_name, $start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        // $currentDate = Carbon::now()->toDateString();
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

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

        $pdf = PDF::loadView('school.features.pdf.course_order_studentList', ['students' => $students, 'school' => $school, 'name' => $name, 'course_name' => $course_name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('Student List Who Ordered ' . $course_name . '.pdf');
    }


    public function  viewCourseStudentsDurationExportPDF($course_id, $course_name, $start_date, $end_date, $duration)
    {
        $id = Auth::user()->schoolid;
        // $currentDate = Carbon::now()->toDateString();
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

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
        AND orders.date_created BETWEEN ? AND ? AND courses_variant.duration = ? 
    ', [$course_id, $start, $end, $duration]);

        $pdf = PDF::loadView('school.features.pdf.filter_course_order_studentList', ['students' => $students, 'school' => $school, 'name' => $name, 'course_name' => $course_name, 'duration' => $duration, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('Student List Who Ordered ' . $course_name . '.pdf');
    }

    public function courseTotalOrderExportPDF()
    {
        $id = Auth::user()->schoolid;
        $currentDate = Carbon::now()->toDateString();


        $name = $this->getName();
        $school = $this->getSchool($id);

        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();

        $start1 = $currentDate . ' 00:00:00';
        $end1 = $currentDate . ' 23:59:59';
        ///revision
        $openHours = $this->getHour();

        $courses = DB::select('SELECT
    courses.*,
    COUNT(orders.id) AS availed_service_count
    FROM courses LEFT JOIN order_lists ON courses.id = order_lists.course_id
    LEFT JOIN orders ON order_lists.order_id = orders.id
    WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ? AND orders.status = 5
    GROUP BY
    courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility, courses.date_created, courses.date_updated', [$id, $start1, $end1]);

        $pdf = PDF::loadView('school.features.pdf.course_total_order', ['courses' => $courses, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);
        return $pdf->download('Total Course Order.pdf');
    }


    public function filterCourseTotalOrderExportPDF($start_date, $end_date)
    {

        $id = Auth::user()->schoolid;
        //$currentDate = Carbon::now()->toDateString();


        $name = $this->getName();
        $school = $this->getSchool($id);

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';
        ///revision
        $openHours = $this->getHour();

        $courses = DB::select('SELECT
    courses.*,
    COUNT(orders.id) AS availed_service_count
    FROM courses LEFT JOIN order_lists ON courses.id = order_lists.course_id
    LEFT JOIN orders ON order_lists.order_id = orders.id
    WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ? AND orders.status = 5
    GROUP BY
    courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility, courses.date_created, courses.date_updated', [$id, $start, $end]);

        $pdf = PDF::loadView('school.features.pdf.filter_course_total_order', ['courses' => $courses, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('Total Course Order.pdf');
    }

    public function courseTotalSalesExportPDF()
    {
        $id = Auth::user()->schoolid;
        $currentDate = Carbon::now()->toDateString();


        $name = $this->getName();
        $school = $this->getSchool($id);

        $start = Carbon::now()->toDateString();
        $end = Carbon::now()->toDateString();

        $start1 = $currentDate . ' 00:00:00';
        $end1 = $currentDate . ' 23:59:59';
        ///revision
        $openHours = $this->getHour();

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



        $pdf = PDF::loadView('school.features.pdf.course_total_sales', ['sales' => $sales, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);
        return $pdf->download('Total Course Sales.pdf');
    }



    public function filterCourseTotalSalesExportPDF($start_date, $end_date)
    {

        $id = Auth::user()->schoolid;
        //$currentDate = Carbon::now()->toDateString();


        $name = $this->getName();
        $school = $this->getSchool($id);

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';
        ///revision
        $openHours = $this->getHour();


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





        $pdf = PDF::loadView('school.features.pdf.filter_course_total_sales', ['sales' => $sales, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('Total Course Sales.pdf');
    }



    ///////new sunday///////////////
    public function viewCourseStudentsSalesExportPDF($course_id, $course_name, $start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        // $currentDate = Carbon::now()->toDateString();
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

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
        GROUP BY order_lists.order_id, students.student_id, students.firstname, students.middlename, students.lastname, students.sex, students.birthdate, 
        students.address, students.date_created,students.date_updated, users.profile_image, 
        users.phone_number, users.email, courses_variant.duration, 
        courses_variant.price', [$course_id, $start, $end]);


        $pdf = PDF::loadView('school.features.pdf.course_sales_studentList', ['students' => $students, 'school' => $school, 'name' => $name, 'course_name' => $course_name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('Sales and Student List Who Ordered ' . $course_name . '.pdf');
    }



    public function  viewSalesCourseStudentsDurationExportPDF($course_id, $course_name, $start_date, $end_date, $duration)
    {
        $id = Auth::user()->schoolid;
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();


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
        WHERE order_lists.course_id = ? AND orders.date_created BETWEEN ? AND ? AND courses_variant.duration = ?
        GROUP BY order_lists.order_id, students.student_id, students.firstname, students.middlename, students.lastname, students.sex, students.birthdate, 
        students.address, students.date_created,students.date_updated, users.profile_image, 
        users.phone_number, users.email, courses_variant.duration, 
        courses_variant.price', [$course_id, $start, $end, $duration]);

        $pdf = PDF::loadView('school.features.pdf.filter_course_sales_studentList', ['students' => $students, 'school' => $school, 'name' => $name, 'course_name' => $course_name, 'duration' => $duration, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);

        return $pdf->download('Sales and Student List Who Ordered ' . $course_name . '.pdf');
    }



    /////new from old before defense

    public function  filtercourseViewStudents(Request $request)
    {
        $id = Auth::user()->schoolid;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';



        $courses = DB::select('SELECT
            courses.*,
            COUNT(orders.id) AS availed_service_count
            FROM courses LEFT JOIN order_lists ON courses.id = order_lists.course_id
            LEFT JOIN orders ON order_lists.order_id = orders.id
            WHERE orders.school_id = ? AND orders.date_UPDATED BETWEEN ? AND ? AND orders.status = 5
            GROUP BY
            courses.id, courses.school_id, courses.name, courses.description, courses.type, courses.thumbnail, courses.status, courses.visibility, courses.date_created, courses.date_updated', [$id, $start, $end]);


        ///newest as in
        $orderData = DB::select("WITH DateSeries AS (
            SELECT '$start' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start' + INTERVAL x DAY <= '$end'
        )
        
        SELECT 
            DATE(ds.date_range) AS day,
            COUNT(o.id) AS count_of_orders
        FROM DateSeries ds
        LEFT JOIN orders o ON DATE(o.date_created) = DATE(ds.date_range) AND o.school_id = ?
        GROUP BY day
        ORDER BY day", [$id]);


        return view('school.features.filter.filter_reports_index_table', ['courses' => $courses, 'start_date' => $start_date, 'end_date' => $end_date, 'orderData' => $orderData]);
    }


    public function  courseViewStudents(Request $request)
    {

        $duration = $request->input('duration');
        $course_id = $request->input('course_id');
        $course_name = $request->input('course_name');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // $currentDate = Carbon::now()->toDateString();
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $students = DB::select('SELECT
            students.*,
            users.email,
            users.phone_number,
            users.profile_image,
            courses_variant.duration
        FROM students
        LEFT JOIN users ON students.student_id = users.id
        LEFT JOIN orders ON students.student_id = orders.student_id
        LEFT JOIN order_lists ON orders.id = order_lists.order_id
        LEFT JOIN courses ON order_lists.course_id = courses.id
        LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id 
        WHERE order_lists.course_id = ?
            AND orders.date_created BETWEEN ? AND ? AND courses_variant.duration = ?
        ', [$course_id, $start, $end, $duration]);


        return view('school.features.filter.filter_courseViewStudent', ['students' => $students, 'course_id' => $course_id, 'course_name' => $course_name, 'duration' => $duration, 'start_date' => $start_date, 'end_date' => $end_date]);
    }



    public function  filterReportSales(Request $request)
    {
        $id = Auth::user()->schoolid;
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


        return view('school.features.filter.filter_reports_sales_table', ['sales' => $sales, 'start_date' => $start_date, 'end_date' => $end_date]);
    }


    public function  courseSalesViewStudents(Request $request)
    {

        $duration = $request->input('duration');
        $course_id = $request->input('course_id');
        $course_name = $request->input('course_name');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // $currentDate = Carbon::now()->toDateString();
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

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
            WHERE order_lists.course_id = ? AND orders.date_created BETWEEN ? AND ? AND courses_variant.duration = ?
            GROUP BY order_lists.order_id, students.student_id, students.firstname, students.middlename, students.lastname, students.sex, students.birthdate, 
            students.address, students.date_created,students.date_updated, users.profile_image, 
            users.phone_number, users.email, courses_variant.duration, 
            courses_variant.price', [$course_id, $start, $end, $duration]);


        return view('school.features.filter.filter_courseSalesViewStudent', ['students' => $students, 'course_id' => $course_id, 'course_name' => $course_name, 'duration' => $duration, 'start_date' => $start_date, 'end_date' => $end_date]);
    }



    ///newest as in 
    public function filterSchoolDasboard(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $id = Auth::user()->schoolid;


        $start_date_with_time = $start_date . ' 00:00:00';
        $end_date_with_time = $end_date . ' 23:59:59';


        $totalstudents = DB::select('SELECT COUNT(DISTINCT student_id) AS total FROM school_students WHERE school_id = ? AND date_created BETWEEN ? AND ?', [$id, $start_date_with_time, $end_date_with_time])[0]->total;
        $totalcourses = DB::select('SELECT COUNT(*) as total FROM courses where school_id = ? AND date_created BETWEEN ? AND ?', [$id, $start_date_with_time, $end_date_with_time])[0]->total;
        $totalvehicles = DB::select('SELECT COUNT(*) as total FROM vehicles where school_id = ? AND date_created BETWEEN ? AND ?', [$id, $start_date_with_time, $end_date_with_time])[0]->total;
        $totalservices = DB::select('SELECT COUNT(*) as total FROM orders where school_id = ? AND date_created BETWEEN ? AND ? AND status = 5', [$id, $start_date_with_time, $end_date_with_time])[0]->total;
        $totalrevenue = DB::select('SELECT SUM(total_amount) as total FROM orders where school_id = ? AND date_created BETWEEN ? AND ? AND status = 5 ', [$id, $start_date_with_time, $end_date_with_time])[0]->total ?? 0;
        $totalpending = DB::select('SELECT COUNT(*) as total FROM orders where school_id = ? AND status = 1 AND date_created BETWEEN ? AND ?', [$id, $start_date_with_time, $end_date_with_time])[0]->total;


        $studentData = DB::select("WITH DateSeries AS (
            SELECT '$start_date_with_time' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start_date_with_time' + INTERVAL x DAY <= '$end_date_with_time'
        )
        
        SELECT DATE(ds.date_range) AS day, COUNT(DISTINCT ss.student_id) AS count_of_students
        FROM DateSeries ds
        LEFT JOIN school_students ss ON DATE(ss.date_created) = DATE(ds.date_range) AND ss.school_id = ?
        GROUP BY day
        ORDER BY day", [$id]);



        $orderData = DB::select("WITH DateSeries AS (
            SELECT '$start_date_with_time' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start_date_with_time' + INTERVAL x DAY <= '$end_date_with_time'
        )
        
        SELECT 
            DATE(ds.date_range) AS day,
            COUNT(o.id) AS count_of_orders
        FROM DateSeries ds
        LEFT JOIN orders o ON DATE(o.date_created) = DATE(ds.date_range) AND o.school_id = ? AND status = 5
        GROUP BY day
        ORDER BY day", [$id]);


        $revenueData = DB::select("WITH DateSeries AS (
            SELECT '$start_date_with_time' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start_date_with_time' + INTERVAL x DAY <= '$end_date_with_time'
        )
        
        SELECT 
            DATE(ds.date_range) AS day,
            COUNT(o.id) AS count_of_orders,
            SUM(CASE WHEN o.status = 5 THEN o.total_amount ELSE 0 END) AS total_revenue
        FROM DateSeries ds
        LEFT JOIN orders o ON DATE(o.date_created) = DATE(ds.date_range) AND o.school_id = ?
        GROUP BY day
        ORDER BY day", [$id]);


        //     $reviews = DB::select('SELECT
        //     students.firstname, students.middlename, students.lastname, schools_review.*,
        //     courses.name, courses_variant.duration
        // FROM
        //     schools_review
        // LEFT JOIN students ON schools_review.student_id = students.student_id
        // LEFT JOIN order_lists ON schools_review.order_id = order_lists.order_id
        // LEFT JOIN courses ON order_lists.course_id = courses.id 
        // LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id AND courses_variant.course_id = courses.id
        // WHERE
        //     schools_review.school_id = ? AND  schools_review.date_created BETWEEN ? AND ?
        // ORDER BY
        //     schools_review.date_created desc
        // LIMIT 5
        //     ', [$id, $start_date_with_time, $end_date_with_time]);


        $reviews = DB::table('schools_review')
            ->join('students', 'schools_review.student_id', '=', 'students.student_id')
            ->join('users', 'students.student_id', '=', 'users.id')
            ->where('schools_review.school_id', $id)
            ->whereBetween('schools_review.date_created', [$start_date_with_time, $end_date_with_time])
            ->select(['schools_review.*', 'students.student_id', 'students.firstname', 'students.middlename', 'students.lastname', 'users.profile_image'])
            ->orderBy('schools_review.date_created', 'DESC')
            ->get();

        return view('school.features.filter.filter_dashboard', ['totalstudents' => $totalstudents, 'totalcourses' => $totalcourses, 'totalvehicles' => $totalvehicles, 'totalservices' => $totalservices, 'totalrevenue' => $totalrevenue, 'studentData' => $studentData, 'orderData' => $orderData, 'revenueData' => $revenueData, 'totalpending' => $totalpending, 'reviews' => $reviews, 'start_date' => $start_date, 'end_date' => $end_date]);
    }





    public function  filterSalesReport(Request $request)
    {
        $id = Auth::user()->schoolid;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        $revenueData = DB::select("WITH DateSeries AS (
            SELECT '$start' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start' + INTERVAL x DAY <= '$end'
        )
        
        SELECT 
            DATE(ds.date_range) AS day,
            COUNT(o.id) AS count_of_orders,
            SUM(CASE WHEN o.status = 5 THEN o.total_amount ELSE 0 END) AS total_revenue
        FROM DateSeries ds
        LEFT JOIN orders o ON DATE(o.date_created) = DATE(ds.date_range) AND o.school_id = ?
        GROUP BY day
        ORDER BY day", [$id]);

        return view('school.features.filter.filter_reports_newSales', ['revenueData' => $revenueData, 'start_date' => $start_date, 'end_date' => $end_date]);
    }




    public function filterTotalNewSalesExportPDF($start_date, $end_date)
    {

        $id = Auth::user()->schoolid;

        $name = $this->getName();
        $school = $this->getSchool($id);

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';
        ///revision
        $openHours = $this->getHour();

        $revenueData = DB::select("WITH DateSeries AS (
            SELECT '$start' + INTERVAL x DAY AS date_range
            FROM (
                SELECT (ROW_NUMBER() OVER ()) - 1 AS x
                FROM information_schema.columns
            ) AS numbers
            WHERE '$start' + INTERVAL x DAY <= '$end'
        )
        
        SELECT 
            DATE(ds.date_range) AS day,
            COUNT(o.id) AS count_of_orders,
            SUM(CASE WHEN o.status = 5 THEN o.total_amount ELSE 0 END) AS total_revenue
        FROM DateSeries ds
        LEFT JOIN orders o ON DATE(o.date_created) = DATE(ds.date_range) AND o.school_id = ?
        GROUP BY day
        ORDER BY day", [$id]);

        // $pdf = PDF::loadView('school.features.pdf.filter_course_total_order', ['courses' => $courses, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date]);
        // return $pdf->download('Total Course Order.pdf');

        $pdf = PDF::loadView('school.features.pdf.filter_reports_new_sales', ['revenueData' => $revenueData, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);

        return $pdf->download('Sales.pdf');
    }

    public function filterLogs(Request $request)
    {

        $id = Auth::user()->schoolid;
        $type = $request->input('type');
        $operation = $request->input('operation');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';


        if ($type == 'All') {

            $logs = DB::select('SELECT * FROM logs where school_id = ? AND operation = ? AND date_created BETWEEN ? AND ? ORDER BY date_created desc', [$id, $operation, $start, $end]);
        } else {
            $logs = DB::select('SELECT * FROM logs where school_id = ? AND operation = ? AND management_type = ? AND date_created BETWEEN ? AND ? ORDER BY date_created desc', [$id, $operation, $type, $start, $end]);
        }

        return view('school.features.filter.filter_logs', ['logs' => $logs]);
    }


    ///revision 
    public function getHour()
    {

        $id = Auth::user()->schoolid;
        $openHours = DB::select('SELECT * FROM school_openhours WHERE school_id = ?', [$id]);

        return $openHours[0];
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
