<?php


namespace App\Repositories\Interfaces;

interface StaffRepositoryInterface
{
    public function create($data);
    public function getSchoolStaff($school_id);
    public function getSingleSchoolStaff($staff_id, $school_id);

    public function updateWithId($staff_id,$data);
    public function getSingleSchoolStaffWithId($staff_id);
}

?>