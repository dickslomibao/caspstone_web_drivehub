<?php


namespace App\Repositories\Interfaces;

interface InstructorRepositoryInterface
{
    public function create($data);
    public function getSchoolInstructor($school_id);
    public function getInstructorDataUsingId($id,$school_id);
    public function getInstructorScheduleUsingId($id,$school_id);
    public function getInstructorDataUsingUserId($user_id);
    public function getSchoolActiveInstructor($school_id);
    public function update($user_id,$data);
    public function checkInstructorConflictSchedule($instructor_id, $session_id,$start_date, $end_date);
    
}

?>