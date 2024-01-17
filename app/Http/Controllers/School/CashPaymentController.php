<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CashPaymentController extends Controller
{
    private $cashPaymentRepository;
    public $orderRepository;
    public function __construct(
        CashPaymentRepositoryInterface $cashPaymentRepositoryInterface,
        OrderRepositoryInterface $orderRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->cashPaymentRepository = $cashPaymentRepositoryInterface;
        $this->orderRepository = $orderRepositoryInterface;
    }

    public function create(Request $request, $order_id)
    {
        $order = $this->orderRepository->getStudentSingleOrder($order_id, auth()->user()->id);

        if ($order == null) {
            abort(404);
        }
        if ($order->status == 2) {
            $this->orderRepository->update($order_id, [
                'status' => 3,
            ]);
        }
        $this->cashPaymentRepository->create([
            'id' => Str::random(8),
            'order_id' => $order_id,
            'school_id' => auth()->user()->schoolid,
            'amount' => $request->amount,
            'process_by' => auth()->user()->id,
        ]);
      
        return redirect()->back()->with('order_message', 'Payment process successfully');
    }
}
