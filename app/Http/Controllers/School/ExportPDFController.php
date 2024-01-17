<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon; ///////new sunday//////


class ExportPDFController extends Controller
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


    public function instructorExportPDF()
    {
        //$name = $request->input('name');
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        $openHours = $this->getHour();

        $instructors = DB::select('Select instructors.*, users.profile_image, users.phone_number, users.email FROM instructors
        INNER JOIN users ON users.id = instructors.user_id  WHERE instructors.school_id=?', [$id]);
        $pdf = PDF::loadView('school.features.pdf.instructors', ['instructors' => $instructors, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);
        return $pdf->download('List of Instructors.pdf');

        //return view('school.features.pdf.instructors', ['instructors' => $instructors, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        $openHours = $this->getHour();

        $students = DB::table('school_students')
            ->join('users', 'users.id', "=", "school_students.student_id")
            ->join('students', 'school_students.student_id', "=", 'students.student_id')
            ->where('school_students.school_id', $id)
            ->select(['students.*', 'users.email', 'users.phone_number'])->get();

        $pdf = PDF::loadView('school.features.pdf.students', ['students' => $students, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Students.pdf');
    }






    public function vehiclesExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $vehicles = DB::select('SELECT * FROM vehicles WHERE school_id = ?', [$id]);
        $pdf = PDF::loadView('school.features.pdf.vehicles', ['vehicles' => $vehicles, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Vehicles.pdf');
    }


    public function  coursesExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();
        $courses = DB::select('SELECT * FROM courses WHERE school_id = ?', [$id]);

        $pdf = PDF::loadView('school.features.pdf.courses', ['courses' => $courses, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Courses.pdf');
    }




    public function  promoExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();
        $promos = DB::select('SELECT * FROM promo WHERE school_id = ?', [$id]);

        $pdf = PDF::loadView('school.features.pdf.promo', ['promos' => $promos, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Promo.pdf');
    }


    public function staffExportPDF()
    {
        //$name = $request->input('name');
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $staffs = DB::select('Select staff.*, users.profile_image, users.phone_number, users.email FROM staff
        INNER JOIN users ON users.id = staff.staff_id  WHERE staff.school_id=?', [$id]);
        $pdf = PDF::loadView('school.features.pdf.staff', ['staffs' => $staffs, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Staff.pdf');
    }


    public function  progressExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $school_progress = [];
        $progress = DB::select('SELECT * FROM progress WHERE school_id = ?', [$id]);
        foreach ($progress as $progress) {
            $progress->sub_progress = DB::select('SELECT * FROM sub_progress WHERE progress_id = ?', [$progress->id]);
            array_push($school_progress, $progress);
        }

        $pdf = PDF::loadView('school.features.pdf.progress', ['school_progress' => $school_progress, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Progress.pdf');

        //return view('school.features.pdf.progress', ['school_progress' => $school_progress, 'school' => $school, 'name' => $name]);
    }


    public function  questionExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $questions = DB::select('SELECT questions.*, question_choices.body FROM questions LEFT JOIN question_choices ON questions.id = question_choices.question_id AND questions.answer = question_choices.code WHERE questions.school_id = ?', [$id]);

        $pdf = PDF::loadView('school.features.pdf.question', ['questions' => $questions, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Questions.pdf');
    }



    public function  theoreticalSchedExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $schedules = DB::select('SELECT theoritical_schedules.*, schedules.start_date, schedules.end_date, schedules.status FROM theoritical_schedules LEFT JOIN schedules ON theoritical_schedules.schedule_id = schedules.id WHERE schedules.school_id = ?', [$id]);
        $pdf = PDF::loadView('school.features.pdf.theoretical_schedule', ['schedules' => $schedules, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Theoretical Schedules.pdf');
    }


    public function availedCoursesExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $students = DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', '=', 'orders.id')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->join('students', 'orders.student_id', '=', 'students.student_id')
            ->join('users', 'orders.student_id', '=', 'users.id')
            ->where('orders.school_id', $id)
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

        $pdf = PDF::loadView('school.features.pdf.availed_courses', ['students' => $students, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Students.pdf');
    }


    public function filterAvailedCoursesExportPDF($status, $start_date, $end_date)
    {

        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);

        $start_date_with_time = $start_date . ' 00:00:00';
        $end_date_with_time = $end_date . ' 23:59:59';

        ///revision
        $openHours = $this->getHour();



        if ($status == 0) {
            $students = DB::table('order_lists')
                ->join('orders', 'order_lists.order_id', '=', 'orders.id')
                ->join('courses', 'order_lists.course_id', '=', 'courses.id')
                ->join('students', 'orders.student_id', '=', 'students.student_id')
                ->join('users', 'orders.student_id', '=', 'users.id')
                ->where('orders.school_id', $id)
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



        $pdf = PDF::loadView('school.features.pdf.filtered_availed_courses', ['students' => $students, 'school' => $school, 'name' => $name,  'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status, 'openHours' => $openHours]);

        return $pdf->download('List of Availed Courses.pdf');
        // return view('school.features.pdf.filtered_availed_courses', ['students' => $students, 'school' => $school, 'name' => $name,  'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);

        // return view('school.features.filter.filter_availedCourses', ['students' => $students, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status]);
    }



    public function ordersPaymentExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $orders = DB::select('SELECT students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image, orders.*, sum(cash_payment.amount) as total_paid FROM orders 
        LEFT JOIN students ON orders.student_id = students.student_id 
        LEFT JOIN users ON students.student_id = users.id 
        LEFT JOIN cash_payment ON orders.id = cash_payment.order_id 
        WHERE orders.school_id=? GROUP BY orders.school_id, orders.id, orders.student_id, 
        orders.total_amount, orders.payment_type, orders.status, orders.promo_id, orders.date_created, 
        orders.date_updated, students.student_id, students.firstname, students.middlename, students.lastname, users.email, users.profile_image ORDER BY orders.date_created desc', [$id]);
        $pdf = PDF::loadView('school.features.pdf.orders_payment', ['orders' => $orders, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);

        return $pdf->download('List of Orders and Payment.pdf');
        //return view('school.features.pdf.orders_payment', ['orders' => $orders, 'school' => $school, 'name' => $name]);
    }



    public function  filterOrdersPaymentExportPDF($status, $payment, $start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

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

        $pdf = PDF::loadView('school.features.pdf.filter_orders_payment', ['orders' => $orders, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status, 'payment' => $payment, 'name' => $name, 'school' => $school, 'openHours' => $openHours]);

        return $pdf->download('List of Orders and Payment.pdf');
    }


    public function filterCoursesExportPDF($status, $start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        if ($status == 0) {
            $courses = DB::select('SELECT * FROM courses WHERE school_id = ? AND date_created BETWEEN ? AND ?', [$id, $start, $end]);
        } else {
            $courses = DB::select('SELECT * FROM courses WHERE status = ?  AND school_id = ? AND date_created BETWEEN ? AND ?', [$status, $id, $start, $end]);
        }

        $pdf = PDF::loadView('school.features.pdf.filter_courses', ['courses' => $courses, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status, 'openHours' => $openHours]);
        return $pdf->download('List of Courses.pdf');
    }



    public function filterPromoExportPDF($start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $promos = DB::select('SELECT * FROM promo WHERE school_id = ? AND
        start_date >= ?
        AND end_date <= ?
        ', [$id, $start, $end]);

        $pdf = PDF::loadView('school.features.pdf.filter_promo', ['promos' => $promos, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'openHours' => $openHours]);
        return $pdf->download('List of Promo.pdf');
    }


    public function filterVehiclesExportPDF($type, $transmission, $fuel)
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        $vehicles = DB::select('SELECT * FROM vehicles WHERE school_id = ? AND type = ? AND transmission = ? AND fuel = ?', [$id, $type, $transmission, $fuel]);
        $pdf = PDF::loadView('school.features.pdf.filter_vehicles', ['vehicles' => $vehicles, 'school' => $school, 'name' => $name, 'type' => $type, 'transmission' => $transmission, 'fuel' => $fuel, 'openHours' => $openHours]);
        return $pdf->download('List of Vehicles.pdf');
    }


    public function filterQuestionsExportPDF($status, $start_date, $end_date)
    {
        $id = Auth::user()->schoolid;
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        $name = $this->getName();
        $school = $this->getSchool($id);
        ///revision
        $openHours = $this->getHour();

        if ($status == 0) {
            $questions = DB::select('SELECT questions.*, question_choices.body FROM questions LEFT JOIN question_choices ON questions.id = question_choices.question_id AND questions.answer = question_choices.code WHERE questions.school_id = ? AND questions.date_created BETWEEN ? AND ?', [$id, $start, $end]);
        } else {
            $questions = DB::select('SELECT questions.*, question_choices.body FROM questions LEFT JOIN question_choices ON questions.id = question_choices.question_id AND questions.answer = question_choices.code WHERE questions.school_id = ? AND questions.status = ? AND questions.date_created BETWEEN ? AND ?', [$id, $status, $start, $end]);
        }

        $pdf = PDF::loadView('school.features.pdf.filter_questions', ['questions' => $questions, 'school' => $school, 'name' => $name, 'start_date' => $start_date, 'end_date' => $end_date, 'status' => $status, 'openHours' => $openHours]);
        return $pdf->download('List of Questions.pdf');
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
    WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ?
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
    WHERE orders.school_id = ? AND orders.date_created BETWEEN ? AND ?
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

    public function totalSalesExportPDF()
    {
        $id = Auth::user()->schoolid;
        $name = $this->getName();
        $school = $this->getSchool($id);
        $currentYear = Carbon::now()->year;
        ///revision
        $openHours = $this->getHour();

        $salesData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COALESCE(SUM(orders.total_amount), 0) AS total_cash_payments
            FROM orders WHERE school_id = ? AND MONTH(date_updated) = ? AND YEAR(date_updated) = ? AND status= ?', [$id, $i, $currentYear, 5])[0]->total_cash_payments;
            $salesData[] = $total;
        }

        $pdf = PDF::loadView('school.features.pdf.total_sales', ['salesData' => $salesData, 'school' => $school, 'name' => $name, 'openHours' => $openHours]);
        return $pdf->download('Total Sales.pdf');
    }


    ///revision 
    public function getHour()
    {

        $id = Auth::user()->schoolid;
        $openHours = DB::select('SELECT * FROM school_openhours WHERE school_id = ?', [$id]);

        return $openHours[0];
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
