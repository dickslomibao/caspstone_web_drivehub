<?php

namespace App\Repositories;

use App\Repositories\Interfaces\InstructorRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InstructorRepository implements InstructorRepositoryInterface
{
    private $filter = ['instructors.*', 'users.username', 'users.email', 'users.profile_image', 'users.phone_number'];
    public function create($data)
    {
        return DB::table('instructors')->insertGetId($data);
    }
    public function getSchoolInstructor($school_id)
    {
        return DB::table('instructors')->join('users', "instructors.user_id", "=", 'users.id')->where('school_id', $school_id)->select($this->filter)->get();
    }
    public function getSchoolActiveInstructor($school_id)
    {
        return DB::table('instructors')
            ->join('users', "instructors.user_id", "=", 'users.id')
            ->where('school_id', $school_id)
            ->where('instructors.status', 1)
            ->select($this->filter)->get();
    }
    public function getInstructorDataUsingId($id, $school_id)
    {
        return DB::table('instructors')->join('users', "instructors.user_id", "=", 'users.id')->where('school_id', $school_id)->where('instructors.id', $id)->select($this->filter)->first();
    }
    public function getInstructorDataUsingUserId($user_id)
    {
        return DB::table('instructors')->join('users', "instructors.user_id", "=", 'users.id')->where('instructors.user_id', $user_id)->select($this->filter)->first();
    }
    public function getInstructorScheduleUsingId($id, $school_id)
    {
        return DB::table('practical_schedule')->where('instructor_id', $id)->where('status', 1)->where('school_id', $school_id)->get();
    }
    public function update($user_id, $data)
    {
        return DB::table('instructors')->where('user_id', $user_id)->update($data);
    }
    public function checkInstructorConflictSchedule($instructor_id, $session_id, $start_date, $end_date)
    {
        return DB::select('SELECT * FROM practical_schedule WHERE ( 
            start_date >= ? AND start_date <= ?
            OR end_date >= ? AND end_date <= ?
            OR start_date <= ? AND end_date >= ? 
            ) and instructor_id = ? and id != ?;
        ', [$start_date, $start_date, $end_date, $end_date, $start_date, $end_date, $instructor_id, $session_id]);
    }
}
