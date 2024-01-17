<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderCheckoutUrlRepositoryInterface;
use Illuminate\Http\Request;
use Curl;

class PaymongoController extends Controller
{
    public $orderCheckOutUrl;
    public function __construct(OrderCheckoutUrlRepositoryInterface $orderCheckoutUrlRepositoryInterface)
    {
        $this->orderCheckOutUrl = $orderCheckoutUrlRepositoryInterface;
    }
    public function success($order_id)
    {
        $order = $this->orderCheckOutUrl->getOrderCheckOutUsingOrderId($order_id);
        if ($order == null) {
            abort(404);
        }
        if ($order->status != 1) {
            abort(404);
        }
        $response = $this->getOrderPayment($order->pay_id);
        if (isset($response->data->attributes->payments)) {
            if ($response->data->attributes->payments[0]->attributes->status == "paid") {
                $this->orderCheckOutUrl->updateStatusWithOrderId($order_id, [
                    'status' => 2
                ]);
                return view("success");
            }
        }
        return abort(404);
    }
    public function getOrderPayment($pay_id)
    {
        return Curl::to('https://api.paymongo.com/v1/checkout_sessions/' . $pay_id)
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic ' . env('AUTH_PAY'))
            ->asJson()
            ->get();
    }
}
