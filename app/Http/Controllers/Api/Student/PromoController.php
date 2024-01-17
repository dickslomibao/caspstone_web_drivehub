<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class PromoController extends Controller
{
    private $promoRepository;
    private $promoItemRepository;
    private $coursesRepository;
    private $courseVariantRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepositoryInterface,
        PromoRepositoryInterface $promoRepositoryInterface,
        PromoItemRepositoryInterface $promoItemRepositoryInterface,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
    ) {
        $this->promoRepository = $promoRepositoryInterface;
        $this->coursesRepository = $courseRepositoryInterface;
        $this->promoItemRepository = $promoItemRepositoryInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
    }
    public function getSchoolPromo($school_id)
    {
        $promos = [];
        $code = 200;
        $message = "";
        try {
            foreach ($this->promoRepository->getSchoolPromoForMobile($school_id) as $promo) {
                $data = [];
                foreach ($this->promoItemRepository->getPromoItems($promo->id) as $item) {
                    $temp_items = array();
                    $variant = $this->courseVariantRepository->getVariantUsingId($item->variant_id);
                    $temp_items['course'] = $this->coursesRepository->retrieveFromId($variant->course_id, $school_id);
                    $temp_items['course']->selected_variant = $item->variant_id;
                    $temp_items['course']->variants = [$variant];
                    $temp_items['course']->rating = 0;
                    $temp_items['course']->review_count = 0;
                    array_push($data, $temp_items);
                }
                $promo->data = $data;
                array_push($promos, $promo);
            }
            $message = "Successfully";
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
                'promos' => $promos,
            ]
        );
    }
}
