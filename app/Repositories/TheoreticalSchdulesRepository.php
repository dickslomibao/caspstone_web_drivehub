<?php

namespace App\Repositories;

use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TheoreticalSchdulesRepository implements TheoreticalSchdulesRepositoryInterface
{

    public function create($data)
    {

        return DB::table('theoritical_schedules')->insertGetId($data);
    }
    public function update($id, $data)
    {
        return DB::table('theoritical_schedules')->where('id', $id)->update($data);
    }

    public function createSchedulesInstructor($data)
    {
        DB::table('theoritical_schedules_instructors')->insert($data);
    }
    public function retrieveSchoolTheoreticalSchdules($school_id)
    {
        return DB::table('theoritical_schedules')
            ->join('schedules', 'theoritical_schedules.schedule_id', '=', 'schedules.id')
            ->where('schedules.school_id', $school_id)
            ->select([
                'theoritical_schedules.*',
                'schedules.start_date',
                'schedules.end_date',
                'schedules.status',
            ])
            ->get();
    }

    public function retrieveSchoolWithIdheoreticalSchdules($id, $school_id)
    {

        return DB::table('theoritical_schedules')
            ->join('schedules', 'theoritical_schedules.schedule_id', '=', 'schedules.id')
            ->where('theoritical_schedules.id', $id)
            ->where('theoritical_schedules.school_id', $school_id)
            ->select([
                'theoritical_schedules.*',
                'schedules.id as schedule_id',
                'schedules.status',
                'schedules.start_date',
                'schedules.end_date',
                'schedules.total_hours',
                'schedules.complete_hours',
            ])
            ->first();
    }


    public function getTheoriticalAvailableStudents($school_id, $session_number)
    {
        return DB::table('sessions')
            ->join('order_lists', 'sessions.order_list_id', '=', 'order_lists.id')
            ->join('orders', 'order_lists.order_id', '=', "orders.id")
            ->join('students', 'orders.student_id', '=', 'students.student_id')
            ->join('users', 'orders.student_id', '=', 'users.id')
            ->where('orders.school_id', $school_id)
            ->where('order_lists.type', 2)
            ->where('sessions.session_number', $session_number)
            ->where('sessions.schedule_id', 0)
            ->select(['students.*', 'users.email', 'users.profile_image', 'sessions.id as session_id'])
            ->get();
    }

    public function getTheoriticalWithScheduleId($schedule_id)
    {
        return DB::table('theoritical_schedules')
            ->where('theoritical_schedules.schedule_id', $schedule_id)
            ->first();
    }
}
