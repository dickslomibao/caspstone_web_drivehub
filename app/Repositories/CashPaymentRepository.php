<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;



class CashPaymentRepository implements CashPaymentRepositoryInterface
{
    public function getPaymentLogsOrder($order_id)
    {
        return DB::table('cash_payment')->where('order_id', $order_id)->get();
    }
    public function create($data)
    {
        return DB::table('cash_payment')->insert($data);
    }
    public function getOrderTotalPayment($order_id)
    {
        return DB::table('cash_payment')->where('order_id', $order_id)->sum('amount');
    }

}
?>