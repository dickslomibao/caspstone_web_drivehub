<?php

namespace App\Repositories\Interfaces;

interface CourseVehicleRepositoryInterface
{
    public function create($data);
    public function getCourseVehicle($course_id);
    public function deletCourseVehicle($course_id);
}

?>