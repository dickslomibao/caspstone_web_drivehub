<?php
namespace App\Repositories\Interfaces;


interface OrderReasonRepositoryInterface
{
  
    public function create($data);

    public function getOrderReason($order_id);
}



?>