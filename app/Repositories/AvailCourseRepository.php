<?php
namespace App\Repositories;

use App\Repositories\Interfaces\AvailCourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AvailCourseRepository implements AvailCourseRepositoryInterface
{


    public function createOrder($data)
    {
        DB::table('availed_services')->insert($data);
    }
    public function schoolOrderList()
    {

        return DB::table('availed_services')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->where('availed_services.school_id', "=", auth()->user()->id)
            ->select(
                'availed_services.id',
                'availed_services.status',
                'availed_services.price',
                'availed_services.payment_type',
                'availed_services.session',
                'availed_services.date_created',
                'availed_services.date_updated',
                'availed_services.duration',
                'school_students.firstname',
                'school_students.middlename',
                'school_students.lastname',
                'courses.name',

            )
            ->get();
    }

    public function getSingleOrderUsingId($id)
    {
        return DB::table('availed_services')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->where('availed_services.school_id', "=", auth()->user()->id)
            ->where('availed_services.id', $id)
            ->select(
                'availed_services.*',
                'school_students.firstname',
                'school_students.middlename',
                'school_students.lastname',
                'courses.name',
            )
            ->first();
    }

    public function totalPaidOfCourse($id)
    {
        return DB::select('SELECT sum(amount) as amount FROM `cash_payment` where order_id = ?', [$id])[0];
    }

    public function createCashPaymentForOrder($data)
    {
        return DB::table('cash_payment')->insert($data);
    }

    public function udpdateOrderStatus($id, $status)
    {
        return DB::table('availed_services')->where('id', $id)->update([
            'status' => $status
        ]);
    }
    public function updateSessionOfCourse($id, $count)
    {
        return DB::table('availed_services')->where('id', $id)->update([
            'session' => $count
        ]);
    }
    public function createSessionSchedule($data)
    {
        DB::table('sessions')->insert($data);
    }
    public function updateSessionSchedule($id, $data)
    {
        DB::table('sessions')->where('id', $id)->where('school_id', auth()->user()->id)->update($data);
    }
    public function totalAssignedSessionHours($id, $course_id)
    {
        return DB::table('sessions')->where('course_id', $course_id)->where('id', '!=', $id)->sum('total_hours');
    }
    public function getCourseSessions($id, $school_id)
    {
        return DB::table('sessions')
            ->leftJoin('instructors', 'sessions.instructor_id', '=', 'instructors.id')
            ->where('sessions.course_id', $id)
            ->where('sessions.school_id', $school_id)
            ->select(['sessions.*', DB::raw("CONCAT(instructors.firstname,' ', instructors.middlename,' ', instructors.lastname) as  instructor_name")])
            ->get();
    }
    public function getCourseSingleSession($course_id, $id)
    {
        return DB::table('sessions')->where('id', $id)->where('course_id', $course_id)->where('school_id', auth()->user()->id)->first();
    }

    //myApiCall
    public function getStudentCourses($id)
    {
        return DB::table('availed_services')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->where('availed_services.student_id', "=", $id)
            ->select(
                'availed_services.*',
                'courses.name',
                'courses.thumbnail',
            )
            ->get();
    }
    public function getStudentSinglerOder($id)
    {
        return DB::table('availed_services')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->where('availed_services.id', "=", $id)
            ->select(
                'availed_services.*',
                'courses.name',
                'courses.thumbnail',
            )
            ->first();
    }
}
?>