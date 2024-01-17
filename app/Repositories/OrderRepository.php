<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{

    public function getSchoolOrders($school_id)
    {
        return DB::table('orders')
            ->join('students', "orders.student_id", '=', 'students.student_id')
            ->join('users', "orders.student_id", '=', 'users.id')
            ->where('school_id', $school_id)
            ->select(['orders.*', 'students.firstname', 'students.middlename', 'students.lastname', 'users.email', 'users.profile_image', DB::raw('(SELECT sum(amount) from cash_payment where cash_payment.order_id = orders.id) as total_paid')])
            ->get();
    }
    public function getSinglerOrderWithId($school_id, $order_id)
    {
        return DB::table('orders')
            ->join('students', "orders.student_id", '=', 'students.student_id')
            ->join('users', "orders.student_id", '=', 'users.id')
            ->where('school_id', $school_id)
            ->where('orders.id', $order_id)
            ->select(['orders.*', 'students.firstname', 'students.middlename', 'students.lastname', 'users.email', 'users.profile_image', DB::raw('(SELECT sum(amount) from cash_payment where cash_payment.order_id = orders.id) as total_paid')])
            ->first();
    }
    public function getSchoolSingleOrder($id, $school_id)
    {
        return DB::table('orders')
            ->join('students', "orders.student_id", '=', 'students.student_id')
            ->join('users', "orders.student_id", '=', 'users.id')
            ->where('school_id', $school_id)
            ->where('orders.id', $id)
            ->select(['orders.*', 'students.firstname', 'students.middlename', 'students.lastname', 'users.email', 'users.profile_image'])
            ->first();
    }

    public function create($data)
    {
        DB::table('orders')->insert($data);
    }
    public function update($id, $data)
    {
        DB::table('orders')->where('id', $id)->update($data);
    }

    public function getStudentOrders($student_id)
    {
        return DB::table('orders')
            ->join('schools', 'orders.school_id', 'schools.user_id')
            ->where('student_id', $student_id)
            ->select(['orders.*', 'schools.name'])
            ->orderBy('orders.date_created', 'desc')
            ->get();
    }

    public function getStudentSingleOrder($order_id, $school_id)
    {
        return DB::table('orders')
            ->join('schools', 'orders.school_id', 'schools.user_id')
            ->where('orders.school_id', $school_id)
            ->where('orders.id', $order_id)
            ->select(['orders.*', 'schools.name'])

            ->first();
    }
}
