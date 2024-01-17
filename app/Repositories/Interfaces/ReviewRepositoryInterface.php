<?php

namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface
{

    public function createCourseReview($data);
    public function createInsructorReview($data);
    public function orderListIdAlreadyRview($order_list_id);
    public function checkIfStudentRateInstructorAlready($schedule_id, $student_id, $instructor_id);
    public function orderIdAlreadyRview($order_id);
    public function getCourseReview($courseId);
    public function getSchoolReview($school_id);
    public function getCourseRating($courseId);
    public function totalCourseReview($courseId);
    public function totalSchoolReview($school_id);
    public function getSchoolRating($school_id);
    public function createSchoolReview($data);
    public function topFive($school_id);
    public function getInstructorReview($instructor_id);
}

?>