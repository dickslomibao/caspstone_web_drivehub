<?php

namespace App\Http\Controllers\Api\Student;

use App\Events\OrderSchoolEvent;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\OrderCheckoutUrlRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Curl;

class OrderController extends Controller
{
    private $orderRepository;
    private $courseRepository;
    private $orderListRepository;
    private $courseVariantRepository;
    private $orderCashPaymentRepository;
    private $promoRespository;
    private $checkOuturlRepository;
    private $studentRepository;
    private $reviewRepository;
    public function __construct(
        OrderRepositoryInterface $orderRepositoryInterface,
        CourseRepositoryInterface $courseRepositoryInterface,
        OrderListRepositoryInterface $orderListRepositoryInterface,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
        CashPaymentRepositoryInterface $cashPaymentRepositoryInterface,
        PromoRepositoryInterface $promoRespositoryInterface,
        OrderCheckoutUrlRepositoryInterface $orderCheckoutUrlRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
    ) {
        $this->orderRepository = $orderRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->courseRepository = $courseRepositoryInterface;
        $this->orderCashPaymentRepository = $cashPaymentRepositoryInterface;
        $this->promoRespository = $promoRespositoryInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
        $this->checkOuturlRepository = $orderCheckoutUrlRepositoryInterface;
        $this->reviewRepository = $reviewRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
    }

    public function createOrder(Request $request)
    {
        $code = 200;
        $message = "";
        $lineItems = [];
        $url = "";
        $p_type = "card";
        if ($request->payment_type == 2) {
            $p_type = 'gcash';
        }
        try {
            $order_id = Str::random(5) . "-" . Str::random(5) . "-" . Str::random(5);
            $total_price = 0;
            for ($i = 0; $i < count($request->courses); $i++) {
                $course_id = $request->courses[$i];
                $variant_id = $request->variants[$i];
                $temp_course = $this->courseRepository->retrieveFromId($course_id, $request->school_id);
                $temp_variant = $this->courseVariantRepository->getVariantUsingId($variant_id);
                if ($temp_course == null) {
                    continue;
                }
                $total_price += $temp_variant->price;
                $this->orderListRepository->create([
                    'order_id' => $order_id,
                    'course_id' => $course_id,
                    'variant_id' => $variant_id,
                    'price' => $temp_variant->price,
                    'duration' => $temp_variant->duration,
                    'type' => $temp_course->type,
                ]);
                $tempLine = [
                    'currency' => 'PHP',
                    'amount' => $temp_variant->price * 100,
                    'description' => '-',
                    'name' => $temp_course->name . " - " . $temp_variant->duration . " hrs",
                    'quantity' => 1,
                ];
                array_push($lineItems, $tempLine);
            }
            $data = [
                'id' => $order_id,
                'school_id' => $request->school_id,
                'student_id' => auth()->user()->id,
                'total_amount' => $total_price,
                'payment_type' => $request->payment_type
            ];
            if ($request->exists('promo_id')) {
                $lineItems = [];
                $data['promo_id'] = $request->promo_id;
                $promo = $this->promoRespository->getSinglePromoUsingId($request->promo_id, $request->school_id);
                $total_price = $promo->price;
                $data['total_amount'] = $total_price;
                $tempLine = [
                    'currency' => 'PHP',
                    'amount' => $total_price * 100,
                    'description' => $promo->description,
                    'name' => $promo->name,
                    'quantity' => 1,
                ];
                array_push($lineItems, $tempLine);
            }
            $this->orderRepository->create($data);
            $message = "successfully";
            if ($request->payment_type == 2 || $request->payment_type == 3) {
                $r = $this->makePaymentUrl($order_id, $lineItems, $p_type);
                $this->checkOuturlRepository->create(
                    [
                        'order_id' => $order_id,
                        'pay_id' => $r->data->id,
                        'url' => $r->data->attributes->checkout_url,
                    ]
                );
                $url = $r->data->attributes->checkout_url;
            }
            $this->studentRepository->createStudent(
                [
                    'student_id' => auth()->user()->id,
                    'school_id' => $request->school_id,
                ]
            );
            event(
                new OrderSchoolEvent(
                    $request->school_id,
                    1,
                    $this->orderRepository->getSchoolSingleOrder($order_id, $request->school_id),
                )
            );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
                'url' => $url,
            ]
        );
    }

    public function getStudentOrder()
    {
        $code = 200;
        $message = "";
        $orders = array();
        try {
            $temp_orders = $this->orderRepository->getStudentOrders(auth()->user()->id);
            foreach ($temp_orders as $order) {
                $temp_order = [];
                $temp_order['order'] = $order;
                $temp_order['cash_paid'] = $this->orderCashPaymentRepository->getOrderTotalPayment($order->id);
                $temp_order['items'] = $this->orderListRepository->getOrderList($order->id);
                $temp_order['review'] = $this->reviewRepository->orderIdAlreadyRview($order->id);
                $temp_order['checkout'] = $this->checkOuturlRepository->getOrderCheckOutUsingOrderId($order->id);
                array_push($orders, $temp_order);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
                'orders' => $orders,
            ]
        );
    }

    public function makePaymentUrl($order_id, $lineItems, $p_type)
    {
        $paymongo_data = [
            'data' => [
                'attributes' => [
                    "billing" => [
                        "name" => auth()->user()->info->firstname . " " . auth()->user()->info->lastname,
                        "email" => auth()->user()->email,
                    ],
                    "line_items" => $lineItems,
                    "send_email_receipt" => true,
                    "show_description" => false,
                    "show_line_items" => true,
                    'payment_method_types' => [
                        $p_type,
                    ],
                    'success_url' => 'https://drivehubsolution.com/success/' . $order_id,
                    'cancel_url' => 'https://drivehubsolution.com/cancel',
                    'description' => 'Payment for your order.'
                ],
            ]
        ];
        $response = Curl::to('https://api.paymongo.com/v1/checkout_sessions')
            ->withHeader('Content-Type: application/json')
            ->withHeader('accept: application/json')
            ->withHeader('Authorization: Basic ' . env('AUTH_PAY'))
            ->withData($paymongo_data)
            ->asJson()
            ->post();
        return $response;
    }
}
