<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderListRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderListRepository implements OrderListRepositoryInterface
{

    public function update($id, $school_id, $data)
    {
        DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', "=", "orders.id")
            ->where('order_lists.id', $id)->where('orders.school_id', $school_id)->update(
                $data
            );
    }
    public function getSingleOrderListWithId($id)
    {
        return DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', "=", "orders.id")
            ->where("order_lists.id", $id)
            ->select(['order_lists.*', 'orders.student_id'])
            ->first();
    }
    public function getSingleOrderList($id, $school_id)
    {
        return DB::table('order_lists')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->join('orders', 'order_lists.order_id', "=", "orders.id")
            ->join('students', 'orders.student_id', "=", 'students.student_id')
            ->join('users', 'orders.student_id', "=", 'users.id')
            ->where('order_lists.id', '=', $id)
            ->where('orders.school_id', '=', $school_id)
            ->select(['order_lists.*', 'orders.student_id', 'courses.name', 'courses.thumbnail', 'courses.type', 'students.firstname', 'students.lastname', 'students.middlename', 'users.email', 'users.profile_image'])
            ->first();
    }

    public function singleOrderListTotallHoursAssign($order_list_id, $except_id)
    {
        $total = 0;
        $r = DB::table('sessions')
            ->join('schedules', 'sessions.schedule_id', 'schedules.id')
            ->where('sessions.order_list_id', $order_list_id)
            ->where('schedules.id', "!=", $except_id)
            ->whereIn('schedules.status', [1, 2, 3])
            ->get();
        foreach ($r as $value) {
            if ($value->status == 1 || $value->status == 2) {
                $total += $value->total_hours;
            } else {
                $total += $value->complete_hours;
            }
        }

        return $total;
    }

    public function singleOrderListCompletedHours($order_list_id, $except_id)
    {

        return DB::table('sessions')
            ->join('schedules', 'sessions.schedule_id', 'schedules.id')
            ->where('sessions.order_list_id', $order_list_id)
            ->where('schedules.status', 3)
            ->sum('schedules.complete_hours');



    }
    //vice-versa
    public function getOrderList($order_id)
    {
        return DB::table('order_lists')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->where('order_lists.order_id', $order_id)
            ->select(['order_lists.*', 'courses.name', 'courses.thumbnail', 'courses.description'])->get();
    }

    //api call
    public function create($data)
    {
        DB::table('order_lists')->insert($data);
    }
    public function getSchoolAvailedCourses($school_id)
    {
        return DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', '=', 'orders.id')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->join('students', 'orders.student_id', '=', 'students.student_id')
            ->join('users', 'orders.student_id', '=', 'users.id')
            ->where('orders.school_id', $school_id)
            ->whereIn('orders.status', [4, 5])
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
    public function getStudentCourses($student_id)
    {
        return DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', '=', 'orders.id')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->where('orders.student_id', $student_id)
            ->whereIn('orders.status', [4, 5])
            ->select([
                'order_lists.id as mycourse.id',
                'order_lists.status as mycourse.status',
                'order_lists.duration as mycourse.duration',
                'order_lists.session as mycourse.session',
                'order_lists.status as mycourse.status',
                'courses.name as course_info.name',
                'courses.description as course_info.description',
                'courses.thumbnail as course_info.thumbnail',
            ])
            ->orderBy('order_lists.date_created', 'desc')
            ->get();
    }
    public function getStudentForSchoolCourses($student_id, $school_id)
    {
        return DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', '=', 'orders.id')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->where('orders.student_id', $student_id)
            ->where('orders.school_id', $school_id)
            ->select([
                'order_lists.id as mycourse.id',
                'order_lists.status as mycourse.status',
                'order_lists.duration as mycourse.duration',
                'order_lists.session as mycourse.session',
                'order_lists.status as mycourse.status',
                'order_lists.remarks as mycourse.remarks',
                'courses.name as course_info.name',
                'courses.description as course_info.description',
                'courses.thumbnail as course_info.thumbnail',
            ])
            ->orderBy('order_lists.date_created', 'desc')
            ->get();
    }

    public function getStudentSingleCourse($student_id, $order_list_id)
    {
        return DB::table('order_lists')
            ->join('orders', 'order_lists.order_id', '=', 'orders.id')
            ->join('schools', 'orders.school_id', '=', 'schools.user_id')
            ->join('courses', 'order_lists.course_id', '=', 'courses.id')
            ->where('orders.student_id', $student_id)
            ->where('order_lists.id', $order_list_id)
            ->select([
                'order_lists.id as mycourse_id',
                'order_lists.status as mycourse_status',
                'order_lists.duration as mycourse_duration',
                'order_lists.session as mycourse_session',
                'order_lists.status as mycourse_status',
                'order_lists.type as mycourse_type',
                'schools.name as d_name',
                'schools.user_id as d_user_id',
                'courses.id as main_course_id',
                'courses.name as course_info_name',
                'courses.description as course_info_description',
                'courses.thumbnail as course_info_thumbnail',
            ])->first();
    }

    public function allOrderListofOrderIsCompleted($order_id)
    {
    
        $count = DB::table('order_lists')
            ->where('order_lists.order_id', $order_id)->count();

        $completed = DB::table('order_lists')
            ->where('order_lists.order_id', $order_id)
            ->whereIn('order_lists.status', [3, 4])->count();
        return $completed == $count;
    }
}
