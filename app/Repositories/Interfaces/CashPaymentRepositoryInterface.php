<?php


namespace App\Repositories\Interfaces;

interface CashPaymentRepositoryInterface
{
    public function create($data);
    
    //vice-versa
    public function getOrderTotalPayment($order_id);

    public function getPaymentLogsOrder($order_id);
}

?>