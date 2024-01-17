<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function create($data);
    public function edit();
    public function delete();
    public function retrieveAll($school_id);
    public function getStudentCompletedHours($order_list_id);
    public function retrieveFromId($id,$school_id);
    public function getActiveCourses($school_id);
    public function getDrivingSchoolCourses($school_id);
    public function getDrivingSchoolCoursesAvaibaleInPublic($school_id);
    public function getCourseWithId($course_id);
    public function filterCourse($name = "", $type = [], $price_start = 1, $price_end = 100000);
}

?>