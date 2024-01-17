<?php

namespace App\Http\Controllers\MakeOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Str;

class MakeOrderController extends Controller
{
    private $promoRepository;
    private $promoItemRepository;
    private $coursesRepository;

    private $orderRepository;

    private $orderListRepository;
    private $courseVariantRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepositoryInterface,
        PromoRepositoryInterface $promoRepositoryInterface,
        PromoItemRepositoryInterface $promoItemRepositoryInterface,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
        OrderRepositoryInterface $orderRepositoryInterface,
        OrderListRepositoryInterface $orderListRepositoryInterface,
    ) {
        $this->promoRepository = $promoRepositoryInterface;
        $this->coursesRepository = $courseRepositoryInterface;
        $this->promoItemRepository = $promoItemRepositoryInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->orderRepository = $orderRepositoryInterface;
    }

    public function create(Request $request, $student_id)
    {

        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);
        $order_id = Str::random(5) . "-" . Str::random(5) . "-" . Str::random(5);
        $total_price = 0;

        if ($request->promo_toggle == null) {
            foreach ($courses as $course) {
                if ($request->exists($course->id)) {
                    $v = $this->courseVariantRepository->getVariantUsingId($request->input($course->id));
                    $c = $this->coursesRepository->getCourseWithId($v->course_id);
                    $total_price += $v->price;
                    $this->orderListRepository->create([
                        'order_id' => $order_id,
                        'course_id' => $v->course_id,
                        'price' => $v->price,
                        'duration' => $v->duration,
                        'type' => $c->type,
                        'variant_id' => $v->id,
                    ]);
                }
            }
            $this->orderRepository->create([
                'id' => $order_id,
                'school_id' => auth()->user()->schoolid,
                'student_id' => $student_id,
                'total_amount' => $total_price,
                'payment_type' => $request->payment
            ]);

        } else {

            $promo = $this->promoRepository->getSinglePromoUsingId($request->promo, auth()->user()->school_id);
            if ($promo == null) {
                abort(404);
            }
            $total_price = $promo->price;
            $items = $this->promoItemRepository->getPromoItems($request->promo);

            foreach ($items as $item) {
                $v = $this->courseVariantRepository->getVariantUsingId($item->variant_id);
                $c = $this->coursesRepository->getCourseWithId($v->course_id);
                $this->orderListRepository->create([
                    'order_id' => $order_id,
                    'course_id' => $v->course_id,
                    'price' => $v->price,
                    'duration' => $v->duration,
                    'type' => $c->type,
                    'variant_id' => $v->id,
                ]);
            }
            $this->orderRepository->create([
                'id' => $order_id,
                'school_id' => auth()->user()->schoolid,
                'student_id' => $student_id,
                'total_amount' => $total_price,
                'payment_type' => $request->payment,
                'promo_id' => $promo->id,
            ]);
        }



        return redirect()->route('index.order');
    }
    public function index($student_id)
    {
       
        $promos = [];

        foreach ($this->promoRepository->getSchoolPromoForMobile(auth()->user()->school_id) as $promo) {
            $data = [];
            foreach ($this->promoItemRepository->getPromoItems($promo->id) as $item) {
                $temp_items = array();
                $variant = $this->courseVariantRepository->getVariantUsingId($item->variant_id);
                $temp_items['course'] = $this->coursesRepository->retrieveFromId($variant->course_id, auth()->user()->school_id);
                $temp_items['course']->selected_variant = $item->variant_id;
                $temp_items['course']->variants = [$variant];
                array_push($data, $temp_items);
            }
            $promo->data = $data;
            array_push($promos, $promo);
        }

        $school_courses = [];
        $courses = $this->coursesRepository->getActiveCourses(auth()->user()->schoolid);

        foreach ($courses as $course) {
            $course->variants = $this->courseVariantRepository->getCourseVariant($course->id);
            array_push($school_courses, $course);
        }

        return view('school.features.make_order.create', [
            'school_courses' => $school_courses,
            'student_id' => $student_id,
            'promos' => $promos,
        ]);
    }
}
