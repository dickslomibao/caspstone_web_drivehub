<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderCheckoutUrlRepositoryInterface;
use Illuminate\Support\Facades\DB;


class OrderCheckoutUrlRepository implements OrderCheckoutUrlRepositoryInterface
{
    public function create($data)
    {
        return DB::table("orders_checkout_url")->insertGetId($data);
    }
    public function getOrderCheckOutUsingOrderId($id)
    {
        return DB::table("orders_checkout_url")->where('order_id', $id)->first();
    }
    public function updateStatusWithOrderId($id, $data)
    {
        return DB::table("orders_checkout_url")->where('order_id', $id)->update($data);
    }

}
?>