<?php
namespace App\Repositories\Interfaces;

interface SchoolRepositoryInterface
{
    public function  getDrivingSchool();
    public function getInfo($id);
    public function getDrivingSchoolWithId($school_id);
    public function fillterDrivingSchool($name);

}

?>