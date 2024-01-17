<?php

namespace App\Repositories\Interfaces;

interface ProgressRepositoryInterface
{

    public function create($data);
    public function updateProgress($data, $id, $school_id);
    public function createSubProgress($data);
    public function retrieveAll($school_id);
    public function retrieveFromId($id, $school_id);
    public function retrieveSubProgress($id);
    public function retrieveSubProgressFromId($id);
    public function getOrderListProgress($order_list_id);
    public function updateStudentProgress($id, $data);
    public function checkAllOrderListProgress($order_list_id, $user_id);
    //Main progress of course
    public function addCourseProgress($data);

    //student need to progress from course main progress
    public function addStudentProgress($data);
    public function getCourseProgress($id);
}
