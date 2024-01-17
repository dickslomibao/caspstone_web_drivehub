<?php

namespace App\Repositories;

use App\Repositories\Interfaces\OrderReasonRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderReasonRepository implements OrderReasonRepositoryInterface
{

  public function create($data)
  {
    return DB::table('order_reasons')->insertGetId($data);
  }
  public function getOrderReason($order_id)
  {
    return DB::table('order_reasons')->where('order_id', $order_id)->get();
  }
}
