<?php
namespace App\Repositories\Interfaces;


interface OrderRepositoryInterface
{
    public function getSchoolOrders($school_id);
    public function getSchoolSingleOrder($id,$school_id);
    public function update($id,$data);
    public function getStudentSingleOrder($order_id,$school_id);

    // api
    public function getStudentOrders($student_id);
    public function create($data);
}



?>