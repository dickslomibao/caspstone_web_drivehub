<?php

namespace App\Repositories\Interfaces;


interface OrderListRepositoryInterface
{


    public function getSingleOrderList($id, $school_id);
    public function getSingleOrderListWithId($id);
    public function getSchoolAvailedCourses($school_id);
    public function update($id, $school_id, $data);
    public function singleOrderListTotallHoursAssign($order_list_id,$except_id);
    public function getStudentForSchoolCourses($student_id, $school_id);
    public function getOrderList($order_id);
    public function allOrderListofOrderIsCompleted($order_id);

    public function create($data);
    public function getStudentCourses($student_id);
    public function getStudentSingleCourse($student_id, $order_list_id);
}
