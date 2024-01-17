<?php

namespace App\Repositories\Interfaces;

interface InstructorReportRepositoryInterface
{
    public function create($data);
    public function getSchoolReportedInstructor($school_id);
    public function getReportedWithId($id,$school_id);
    public function checkIfStudentReportedInstructorAlready($schedule_id, $student_id, $instructor_id);

}

?>