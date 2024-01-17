<?php

namespace App\Repositories;

use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SchedulesRepository implements SchedulesRepositoryInterface
{
    public function create($data)
    {
        return DB::table('schedules')->insertGetId($data);
    }


    public function getScheduleInfoWithId($id)
    {
        return DB::table('schedules')->where('id', $id)->first();
    }

    public function updateScheduleWIthId($id, $data)
    {
        return DB::table('schedules')->where('id', $id)->update($data);
    }
    //api

    public function getScheduleFullInfoWithId($id)
    {
        return DB::table('schedules')
            ->join('schools', 'schedules.school_id', "=", "schools.user_id")
            ->join("sessions", "schedules.id", "=", "sessions.schedule_id")
            ->join("order_lists", "sessions.order_list_id", "=", "order_lists.id")
            ->join("courses", "order_lists.course_id", "=", "courses.id")
            ->where('schedules.id', $id)
            ->select(['schedules.*', 'schools.name', 'courses.name as course_name', 'order_lists.duration as course_duration'])
            ->first();
    }
    public function getSchoolAllSchedule($school_id)
    {
        return DB::table('schedules')->where('school_id', $school_id)->get();
    }
    public function getScheduleFullInfoWithIdForTheoritical($id)
    {
        return DB::table('schedules')
            ->join('schools', 'schedules.school_id', "=", "schools.user_id")
            ->where('schedules.id', $id)
            ->select(['schedules.*', 'schools.name'])
            ->first();
    }
    public function getStudentSchedulesGroupByDay($student_id)
    {
        return DB::select('SELECT date(schedules.start_date) as day, GROUP_CONCAT(schedules.id) as schedule_ids FROM `schedules` join schedule_students on schedules.id =  schedule_students.schedule_id where schedule_students.student_id = ? GROUP BY day order by day ASC', [$student_id]);
    }
    public function getInstructorSchedulesGroupByDay($instructor_id)
    {
        return DB::select('SELECT date(schedules.start_date) as day, GROUP_CONCAT(schedules.id) as schedule_ids FROM `schedules` join schedule_instructors on schedules.id =  schedule_instructors.schedule_id where schedule_instructors.instructor_id = ? GROUP BY day order by day ASC', [$instructor_id]);
    }

    public function getConflictSchedules($start_date, $end_date, $school_id, $id)
    {
        return DB::table('schedules')
            ->select('id')
            ->where(function ($query) use ($start_date, $end_date) {
                $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '<', $end_date)
                        ->where('end_date', '>', $start_date);
                })->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '=', $start_date)
                        ->orWhere('end_date', '=', $end_date);
                });
            })
            ->where('school_id', $school_id)
            ->whereIn('status', [1, 2])
            ->where('id', "!=", $id)
            ->get();


        //     return DB::select('SELECT schedules.id FROM schedules WHERE 
        //         (schedules.start_date >= ? AND schedules.start_date <= ?)
        //         OR (schedules.end_date >= ? AND schedules.end_date <= ?)
        //         OR (schedules.start_date >= ? AND schedules.end_date <= ?)
        //  AND schedules.school_id = ? AND schedules.id != ?
        //     ', [$start_date, $start_date, $end_date, $end_date, $start_date, $end_date, $school_id, $id]);
    }
}
