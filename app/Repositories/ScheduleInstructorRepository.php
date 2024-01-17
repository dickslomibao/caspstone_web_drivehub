<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleInstructorRepository implements ScheduleInstructorRepositoryInterface
{
    public function create($data)
    {
        return DB::table('schedule_instructors')->insertGetId($data);
    }
    public function getConflictedInstructor($schedule_ids)
    {
        return DB::table('schedule_instructors')
            ->whereIn('schedule_id', $schedule_ids)
            ->select(['instructor_id'])
            ->groupBy('instructor_id')
            ->get();

    }
    //vice-versa
    public function getSchedulesInstructor($schedule_id)
    {
        return DB::table('schedule_instructors')
            ->join('instructors', 'schedule_instructors.instructor_id', "=", 'instructors.user_id')
            ->join('users', 'schedule_instructors.instructor_id', "=", 'users.id')
            ->where('schedule_instructors.schedule_id', $schedule_id)
            ->select(['instructors.*', 'users.email', 'users.profile_image'])
            ->get();
    }
    public function getPracticalInstructor($schedule_id)
    {
        return DB::table('schedule_instructors')->where('schedule_id', $schedule_id)->first();
    }

    public function updateSchedulesInstructor($schedule_id, $instructor_id)
    {
        DB::table('schedule_instructors')->where('schedule_id', $schedule_id)->update([
            'instructor_id' => $instructor_id,
        ]);
    }

    public function removeTheoriticalInstructor($schedule_id, $instructor_id){
        return DB::table('schedule_instructors')->where('schedule_id', $schedule_id)->where('instructor_id', $instructor_id)->delete();

    }

}
