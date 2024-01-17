<?php

namespace App\Repositories\Interfaces;

interface OrderCheckoutUrlRepositoryInterface
{
    public function create($data);
    public function getOrderCheckOutUsingOrderId($id);
    public function updateStatusWithOrderId($id,$data);

}

?>