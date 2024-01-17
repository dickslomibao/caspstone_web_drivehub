<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use App\Repositories\Interfaces\PromoRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use Exception;

class CoursesController extends Controller
{
    private $orderRepository;
    private $courseRepository;
    private $courseVariantRepository;
    private $orderListRepository;
    private $orderCashPaymentRepository;
    private $scheduleSessionsRepository;
    private $schedulesRepository;
    private $scheduleInstructorRepository;
    private $ScheduleVehicleRepository;
    private $progressRepository;
    private $theoriticalScheduleRepository;
    private $schoolRepository;
    public $reviewRepository;
    private $promoRepository;
    private $promoItemRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepositoryInterface,
        CourseRepositoryInterface $courseRepositoryInterface,
        CourseVariantRepositoryInterface $courseVariantRepositoryInterface,
        OrderListRepositoryInterface $orderListRepositoryInterface,
        CashPaymentRepositoryInterface $cashPaymentRepositoryInterface,
        SchedulesRepositoryInterface $schedulesRepositoryInterface,
        scheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleVehicleRepositoryInterface $ScheduleVehicleRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoreticalSchdulesRepositoryInterface,
        SchoolRepositoryInterface $schoolRepositoryInterface,
        ProgressRepositoryInterface $progressRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        PromoRepositoryInterface $promoRepositoryInterface,
        PromoItemRepositoryInterface $promoItemRepositoryInterface,

    ) {
        $this->orderRepository = $orderRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->courseRepository = $courseRepositoryInterface;
        $this->courseVariantRepository = $courseVariantRepositoryInterface;
        $this->orderCashPaymentRepository = $cashPaymentRepositoryInterface;
        $this->scheduleSessionsRepository = $scheduleSessionsRepositoryInterface;
        $this->schedulesRepository = $schedulesRepositoryInterface;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->ScheduleVehicleRepository = $ScheduleVehicleRepositoryInterface;
        $this->theoriticalScheduleRepository = $theoreticalSchdulesRepositoryInterface;
        $this->progressRepository = $progressRepositoryInterface;
        $this->schoolRepository = $schoolRepositoryInterface;
        $this->reviewRepository = $reviewRepositoryInterface;
        $this->promoRepository = $promoRepositoryInterface;
        $this->promoItemRepository = $promoItemRepositoryInterface;
    }


    public function getDrivingSchoolSingleCourse($course_id)
    {
        $code = 200;
        $message = "Success";
        $course = [];
        try {
            $course = $this->courseRepository->getCourseWithId($course_id);
            $course->variants = $this->courseVariantRepository->getCourseAvailableVariant($course_id);
            $course->schools = $this->schoolRepository->getDrivingSchoolWithId($course->school_id);
            $course->rating = $this->reviewRepository->getCourseRating($course->id);
            $course->review_count = $this->reviewRepository->totalCourseReview($course->id);

            $course->schools->distance = 0;
            $course->schools->rating = $this->reviewRepository->getSchoolRating($course->schools->user_id);
            $course->schools->review_count = $this->reviewRepository->totalSchoolReview($course->schools->user_id);

        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'course' => $course,
                'message' => $message,
            ]
        );
    }
    public function studentReviewCourse(Request $request)
    {
        $code = 200;
        $message = "Success";
        $course = [];
        try {
            $this->reviewRepository->createCourseReview([
                'student_id' => auth()->user()->id,
                'course_id' => $request->course_id,
                'school_id' => $request->school_id,
                'order_list_id' => $request->order_list_id,
                'content' => $request->content,
                'anonymous' => $request->hide,
                'rating' => $request->rating,
            ]);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'course' => $course,
                'message' => $message,
            ]
        );
    }

    public function getDrivingSchoolCourses(Request $request)
    {
        $code = 200;
        $message = "Success";
        $school_courses = [];
        try {
            $courses = $this->courseRepository->getDrivingSchoolCoursesAvaibaleInPublic($request->school_id);
            foreach ($courses as $course) {
                $course->variants = $this->courseVariantRepository->getCourseAvailableVariant($course->id);
                if (count($course->variants) == 0) {
                    continue;
                }
                $course->rating = $this->reviewRepository->getCourseRating($course->id);
                $course->review_count = $this->reviewRepository->totalCourseReview($course->id);
                array_push($school_courses, $course);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'courses' => $school_courses,
                'message' => $message,
            ]
        );
    }
    public function filterCourses(Request $request)
    {
        $code = 200;
        $message = "Success";
        $school_courses = [];
        $promos = [];
        try {
            $temp_course = $this->courseRepository->filterCourse(
                $request->name,
                $request->type,
                $request->price_start,
                $request->price_end,
            );
            foreach ($temp_course as $course) {
                $course->rating = $this->reviewRepository->getCourseRating($course->id);
                $course->review_count = $this->reviewRepository->totalCourseReview($course->id);
                $course->school = $this->schoolRepository->getDrivingSchoolWithId($course->school_id);
                $course->distance = $this->haversineDistance($course->school->latitude, $course->school->longitude, $request->lat, $request->long);
                $course->school->promos = $this->getPromo($course->school_id);
                if ($course->rating >= $request->r_start && $course->rating <= $request->r_end) {
                    array_push($school_courses, $course);
                }
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'courses' => $school_courses,
                'promo' => $promos,
                'message' => $message,
            ]
        );
    }

    public function getPromo($school_id)
    {
        $promos = [];

        foreach ($this->promoRepository->getSchoolPromoForMobile($school_id) as $promo) {
            $data = [];
            foreach ($this->promoItemRepository->getPromoItems($promo->id) as $item) {
                $temp_items = array();
                $variant = $this->courseVariantRepository->getVariantUsingId($item->variant_id);
                $temp_items['course'] = $this->courseRepository->retrieveFromId($variant->course_id, $school_id);
                $temp_items['course']->selected_variant = $item->variant_id;
                $temp_items['course']->variants = [$variant];
                $temp_items['course']->rating = 0;
                $temp_items['course']->review_count = 0;
                array_push($data, $temp_items);
            }
            $promo->data = $data;
            array_push($promos, $promo);
        }
        
        return $promos;
    }
    public function getCoursesController()
    {

        $code = 200;
        $message = "Success";
        $courses = [];
        try {
            $courses = $this->orderListRepository->getStudentCourses(auth()->user()->id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'courses' => $courses,
                'message' => $message,
            ]
        );
    }
    public function getCoursesReview($courseId)
    {

        $code = 200;
        $message = "Success";
        $review = [];
        try {
            $review = $this->reviewRepository->getCourseReview($courseId);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'review' => $review,
                'message' => $message,
            ]
        );
    }
    public function getSingleCourse($id)
    {
        $code = 200;
        $message = "Success";
        $mycourse = [];
        $completed_hrs = 0;
        try {
            $course = $this->orderListRepository->getStudentSingleCourse(auth()->user()->id, $id);
            $mycourse['info'] = $course;
            $sessions = [];
            foreach ($this->scheduleSessionsRepository->getOrderListSession($id) as $session) {
                $session->schedules = $this->schedulesRepository->getScheduleInfoWithId($session->schedule_id);
                $session->instructors = $this->scheduleInstructorRepository->getSchedulesInstructor($session->schedule_id);
                $session->vehicles = $this->ScheduleVehicleRepository->getScheduleVehicle($session->schedule_id);
                if ($session->schedule_id != 0) {
                    $completed_hrs += $session->schedules->complete_hours;
                }
                array_push($sessions, $session);
            }
            $mycourse['sessions'] = $sessions;
            $mycourse['progress'] = $this->progressRepository->getOrderListProgress($id);
            $mycourse['completed_hrs'] = $completed_hrs;
            $mycourse['review'] = $this->reviewRepository->orderListIdAlreadyRview($id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'mycourse' => $mycourse,
                'message' => $message,
            ]
        );
    }
    public static function haversineDistance($school_lat, $school_long, $student_lat, $student_long)
    {
        $earthRadius = 6371;

        $school_lat = deg2rad($school_lat);
        $school_long = deg2rad($school_long);
        $student_lat = deg2rad($student_lat);
        $student_long = deg2rad($student_long);

        $dLat = $student_lat - $school_lat;
        $dLon = $student_long - $school_long;

        $a = sin($dLat / 2) * sin($dLat / 2) + cos($school_lat) * cos($student_lat) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return (double) number_format($distance, 2);
    }
}
