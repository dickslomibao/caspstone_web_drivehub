<?php


namespace App\Repositories\Interfaces;

interface ScheduleStudentsRepositoryInterface
{
    public function create($data);

    //api-call
    public function getConflictedStudent($schedule_ids);
    public function getScheduleStudents($schedule_id);
    public function removeStudent($schedule_id, $student_id);
    public function getTheStudentAvailedCourse($schedule_id, $student_id);
}

?>