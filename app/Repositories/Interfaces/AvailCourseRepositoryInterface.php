<?php

namespace App\Repositories\Interfaces;

interface AvailCourseRepositoryInterface
{

    public function createOrder($data);
    public function schoolOrderList();
    public function getSingleOrderUsingId($id);
    public function totalPaidOfCourse($id);
    public function createCashPaymentForOrder($data);
    public function udpdateOrderStatus($id, $status);
    public function updateSessionOfCourse($id, $count);
    public function createSessionSchedule($data);
    public function getCourseSessions($id,$school_id);
    public function getCourseSingleSession($course_id, $id);
    public function updateSessionSchedule($id, $data);
    public function totalAssignedSessionHours($id, $course_id);
    public function getStudentCourses($id);
    public function getStudentSinglerOder($id);
}

?>