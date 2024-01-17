<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleStudentsRepository implements ScheduleStudentsRepositoryInterface
{
    public function create($data)
    {
        return DB::table('schedule_students')->insertGetId($data);
    }

    public function getScheduleStudents($schedule_id)
    {
        return DB::table('schedule_students')
            ->join('students', 'schedule_students.student_id', "=", 'students.student_id')
            ->join('users', 'schedule_students.student_id', "=", 'users.id')
            ->where('schedule_students.schedule_id', $schedule_id)
            ->select(['students.*', 'users.email', 'users.profile_image', 'schedule_students.order_list_id'])
            ->get();

    }
    public function getConflictedStudent($schedule_ids)
    {
        return DB::table('schedule_students')
            ->whereIn('schedule_id', $schedule_ids)
            ->select(['student_id'])
            ->groupBy('student_id')
            ->get();

    }
    public function removeStudent($schedule_id, $student_id)
    {
        return DB::table('schedule_students')
            ->where('schedule_id', $schedule_id)
            ->where('student_id', $student_id)
            ->delete();
    }

    public function getTheStudentAvailedCourse($schedule_id, $student_id)
    {


    }


}
