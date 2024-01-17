<?php



namespace App\Repositories\Interfaces;

interface ScheduleInstructorRepositoryInterface
{
    public function create($data);
    public function getConflictedInstructor($schedule_ids);
    //vice-versa
    public function getSchedulesInstructor($schedule_id);
    public function getPracticalInstructor($schedule_id);
    public function updateSchedulesInstructor($schedule_id,$instructor_id);

    public function removeTheoriticalInstructor($schedule_id,$instructor_id);

    
}
