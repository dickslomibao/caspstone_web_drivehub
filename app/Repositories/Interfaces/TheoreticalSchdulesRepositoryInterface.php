<?php

namespace App\Repositories\Interfaces;

interface TheoreticalSchdulesRepositoryInterface
{
    public function create($data);
    public function createSchedulesInstructor($data);
    public function retrieveSchoolTheoreticalSchdules($school_id);
    public function retrieveSchoolWithIdheoreticalSchdules($id, $school_id);
    public function getTheoriticalAvailableStudents($school_id,$session_number);

    public function getTheoriticalWithScheduleId($schedule_id);
    public function update($id,$data);
}

?>