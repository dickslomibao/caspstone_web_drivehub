<?php

namespace App\Http\Controllers\School;

use App\Events\OrderChangesEvent;
use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\OrderCheckoutUrlRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderReasonRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\StaffRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\EmailVerification;
use Mail;
use Curl;

class OrderController extends Controller
{

    private $orderRepository;
    private $courseRepository;
    private $orderListRepository;
    private $cashPaymentRepository;
    public $orderCheckOutUrl;
    public $orderReasonRepository;
    public $staffRepository;
    public $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepositoryInterface, StaffRepositoryInterface $staffRepositoryInterface, OrderReasonRepositoryInterface $orderReasonRepositoryInterface, OrderCheckoutUrlRepositoryInterface $orderCheckoutUrlRepositoryInterface, OrderRepositoryInterface $orderRepositoryInterface, CourseRepositoryInterface $courseRepositoryInterface, OrderListRepositoryInterface $orderListRepositoryInterface, CashPaymentRepositoryInterface $cashPaymentRepositoryInterface)
    {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->orderRepository = $orderRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->courseRepository = $courseRepositoryInterface;
        $this->cashPaymentRepository = $cashPaymentRepositoryInterface;
        $this->orderCheckOutUrl = $orderCheckoutUrlRepositoryInterface;
        $this->orderReasonRepository = $orderReasonRepositoryInterface;
        $this->staffRepository = $staffRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
    }
    public function index()
    {
        // Mail::to('sorianokid771@gmail.com')->send(
        //     new EmailVerification(
        //         [
        //             'body'=>'hellow'
        //         ]
        //     )
        // );
        // $ch = curl_init();
        // $parameters = array(
        //     'apikey' => env('SEMAPHORE_KEY'),
        //     'number' => '+639483564361',
        //     'message' => 'First message',
        //     'sendername' => 'SEMAPHORE'
        // );
        // curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
        // curl_setopt($ch, CURLOPT_POST, 1);

        // //Send the parameters set above with the request
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        // // Receive response from server
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $output = curl_exec($ch);
        // curl_close($ch);

        // //Show the server response
        // dd($output);

        return view(
            'school.features.orders_management.index',
        );
    }
    public function acceptOrder($id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($id, auth()->user()->schoolid);
        if ($order == null || $order->status != 1) {
            abort(404);
        }
        if ($order->payment_type == 1) {
            $this->orderRepository->update($id, [
                'status' => 2,
            ]);
        } else {
            $p_url = $this->orderCheckOutUrl->getOrderCheckOutUsingOrderId($id);
            $response = $this->getOrderPayment($p_url->pay_id);
            if (isset($response->data->attributes->payments[0]->attributes->status)) {
                if ($response->data->attributes->payments[0]->attributes->status == "paid") {
                    $this->orderCheckOutUrl->updateStatusWithOrderId($id, [
                        'status' => 2,
                        'payment_id' => $response->data->attributes->payments[0]->id,
                    ]);
                    $this->orderRepository->update($id, [
                        'status' => 3,
                    ]);
                }
            } else {
                $this->orderRepository->update($id, [
                    'status' => 2,
                ]);
            }
        }
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        Mail::to($student->email)->send(
            new OrderMail(
                [
                    'text' => 'Your Order ' . $order->id . ' is accepted Successfully by the driving school',
                    'reason' => null,
                    'subject' => 'Order Accepted'
                ]
            )
        );

        return redirect()->back()->with('order_message', 'Accepted Successfully');
    }
    public function acceptRequiremet($id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($id, auth()->user()->schoolid);
        if ($order == null) {
            abort(404);
        }
        if ($order->status != 3) {
            abort(404);
        }
        $this->orderRepository->update($id, [
            'status' => 4,
        ]);
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        Mail::to($student->email)->send(
            new OrderMail(
                [
                    'text' => 'Your Order ' . $order->id . ' is  Successfully Acceepted the requirements by the driving school',
                    'reason' => null,
                    'subject' => 'Order Accepted requirements'
                ]
            )
        );
        return redirect()->back()->with('order_message', 'Requriements Accepted Successfully');
    }
    public function cancelOrder(Request $request, $id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($id, auth()->user()->schoolid);
        if ($order == null) {
            abort(404);
        }
        if (!in_array($order->status, [1, 2])) {
            abort(404);
        }
        $this->orderReasonRepository->create(
            [
                'order_id' => $id,
                'process_by' => auth()->user()->id,
                'content' => $request->content,
            ]
        );
        $this->orderRepository->update($id, [
            'status' => 6,
        ]);
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        Mail::to($student->email)->send(
            new OrderMail(
                [
                    'text' => 'Your Order ' . $order->id . ' is has benn canceled by the driving school',
                    'reason' => $request->content,
                    'subject' => 'Order Cancelled'
                ]
            )
        );
        return redirect()->back()->with('order_message', 'Cancelled Successfully');
    }
    public function refundOrder(Request $request, $id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($id, auth()->user()->schoolid);
        if ($order == null) {
            abort(404);
        }
        if (!in_array($order->status, [3, 4])) {
            abort(404);
        }
        $this->orderReasonRepository->create(
            [
                'order_id' => $id,
                'process_by' => auth()->user()->id,
                'content' => $request->content,
                'type' => 2,
            ]
        );
        $this->orderRepository->update($id, [
            'status' => 7,
        ]);
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        Mail::to($student->email)->send(
            new OrderMail(
                [
                    'text' => 'Your Order ' . $order->id . ' is has been refunded by the driving school',
                    'reason' => $request->content,
                    'subject' => 'Order Refunded'
                ]
            )
        );
        return redirect()->back()->with('order_message', 'Refunded Successfully');
    }
    public function orderDetailsView($id)
    {
        $order = $this->orderRepository->getSchoolSingleOrder($id, auth()->user()->schoolid);
        $order_list = $this->orderListRepository->getOrderList($order->id);
        return view(
            'school.features.orders_management.order_view',
            [
                'order' => $order,
                'items' => $order_list,
                'total_cash_payment' => $this->cashPaymentRepository->getOrderTotalPayment($order->id),
                'checkout_status' => $this->orderCheckOutUrl->getOrderCheckOutUsingOrderId($order->id),
            ]
        );
    }
    public function orderlogs($id)
    {
        $order = $this->orderRepository->getSchoolSingleOrder($id, auth()->user()->schoolid);
        $order_list = $this->orderListRepository->getOrderList($order->id);
        return view(
            'school.features.orders_management.order_logs',
            [
                'order' => $order,
                'items' => $order_list,
                'reasons' => $this->orderReasonRepository->getOrderReason($id),
                'staffRepository' => $this->staffRepository,
                'payment_logs' => $this->cashPaymentRepository->getPaymentLogsOrder($order->id),
                'total_cash_payment' => $this->cashPaymentRepository->getOrderTotalPayment($order->id),
                'checkout_status' => $this->orderCheckOutUrl->getOrderCheckOutUsingOrderId($order->id),
            ]
        );
    }

    public function makeCashPayment(Request $request, $order_id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($order_id, auth()->user()->schoolid);

        if ($order == null) {
            abort(404);
        }

        $this->cashPaymentRepository->create([
            'id' => Str::random(8),
            'order_id' => $order_id,
            'school_id' => auth()->user()->schoolid,
            'amount' => $request->amount,
            'cash_tendered' => $request->cash,
            'process_by' => auth()->user()->id,
        ],);
        if ($order->status == 2) {
            $this->orderRepository->update($order_id, [
                'status' => 3,
            ]);
        }
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        Mail::to($student->email)->send(
            new OrderMail(
                [
                    'text' => 'You made ' . number_format($request->amount, 2) . 'php cash payment with your Order ' . $order->id,
                    'reason' => null,
                    'subject' => 'Payment made'
                ]
            )
        );
        return redirect()->back()->with('order_message', 'Payment process successfully');
    }
    public function getSchoolOrders()
    {
        return json_encode($this->orderRepository->getSchoolOrders(auth()->user()->schoolid));
    }

    private function orderChanges($order)
    {
        $temp_order = [];
        $temp_order['order'] = $order;
        $temp_order['cash_paid'] = $this->cashPaymentRepository->getOrderTotalPayment($order->id);
        $temp_order['items'] = $this->orderListRepository->getOrderList($order->id);
        event(
            new OrderChangesEvent(
                $order->student_id,
                $temp_order,
            )
        );
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
