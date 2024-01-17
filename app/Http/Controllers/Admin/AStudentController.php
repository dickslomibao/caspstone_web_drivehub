<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AStudentController extends Controller
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



    public function retreiveStudents()
    {

        $students = DB::select('SELECT students.*, users.profile_image, users.email, 
        COUNT(DISTINCT orders.id) AS availed_service_count, ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(DISTINCT orders.id)) * 100, 2) AS completion_rate 
        FROM students LEFT JOIN users ON users.id = students.student_id
        LEFT JOIN orders ON students.student_id = orders.student_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id LEFT JOIN courses ON order_lists.course_id = courses.id 
        GROUP BY students.student_id, students.firstname, students.middlename, students.lastname, students.date_created,students.date_updated, users.profile_image, users.email');
        return view('admin.features.student_management.index',  ['students' => $students]);
    }




    public function studentDetails($id)
    {
        $details = $this->getStudentDetails($id);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $courses = DB::select(
            'SELECT schools.*, users.profile_image, users.email, COUNT(DISTINCT orders.id) AS availed_service_count, 
        ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(DISTINCT orders.id)) * 100, 2) AS completion_rate, 
        order_lists.course_id, courses.name AS course_name FROM schools 
        LEFT JOIN users ON users.id = schools.user_id 
        LEFT JOIN orders ON schools.user_id = orders.school_id 
        LEFT JOIN students ON students.student_id = orders.student_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id 
        LEFT JOIN courses ON order_lists.course_id = courses.id 
        WHERE order_lists.course_id IS NOT NULL AND orders.student_id = ? 
        GROUP BY schools.id, users.profile_image, users.email, 
        order_lists.course_id, courses.name, order_lists.status,schools.user_id, schools.name ,schools.address, schools.latitude, schools.longitude,schools.date_created, 
   schools.date_updated, schools.accreditation_status',
            [$id]
        );

        return view('admin.features.student_management.moreStudentDetails', ['details' => $details, 'courses' => $courses]);
    }



    public function getStudentDetails($id)
    {

        $details = DB::select('SELECT students.*, users.profile_image, users.email, 
        COUNT(DISTINCT orders.id) AS availed_service_count, ROUND((COUNT(CASE WHEN order_lists.status = 5 THEN 1 ELSE NULL END) / COUNT(DISTINCT orders.id)) * 100, 2) AS completion_rate 
        FROM students LEFT JOIN users ON users.id = students.student_id
        LEFT JOIN orders ON students.student_id = orders.student_id 
        LEFT JOIN order_lists ON orders.id = order_lists.order_id LEFT JOIN courses ON order_lists.course_id = courses.id 
        WHERE students.student_id =?
        GROUP BY students.student_id, students.firstname, students.middlename, students.lastname, students.date_created,students.date_updated, users.profile_image, users.email', [$id]);

        return $details[0];
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
