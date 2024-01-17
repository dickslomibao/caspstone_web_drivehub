<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolController extends Controller
{

    public $schoolRepository;
    public $reviewRepository;
    public function __construct(SchoolRepositoryInterface $schoolRepositoryInterface, ReviewRepositoryInterface $reviewRepositoryInterface, )
    {
        $this->schoolRepository = $schoolRepositoryInterface;
        $this->reviewRepository = $reviewRepositoryInterface;
    }

    public function getSchoolAbout($school_id)
    {

        $code = 200;
        $message = "Success";
        $about = [];
        try {
            $about = DB::table('school_about')->where('school_id', $school_id)->first();
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'about' => $about,
                'message' => $message,
            ]
        );

    }
    public function getSchoolPolicy($school_id)
    {

        $code = 200;
        $message = "Success";
        $about = [];
        try {
            $about = DB::table('school_policy')->where('school_id', $school_id)->first();
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'about' => $about,
                'message' => $message,
            ]
        );

    }

    public function studentReviewSchool(Request $request)
    {
        $code = 200;
        $message = "Success";
        try {
            $this->reviewRepository->createSchoolReview([
                'student_id' => auth()->user()->id,
                'order_id' => $request->order_id,
                'school_id' => $request->school_id,
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

                'message' => $message,
            ]
        );
    }

    public function getSchoolReview($school_id)
    {

        $code = 200;
        $message = "Success";
        $review = [];
        try {
            $review = $this->reviewRepository->getSchoolReview($school_id);
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

    public function getDrivingSchool(Request $request){
        $code = 200;
        $message = "Success";
        $schools = array();
        try {
            $temp_schools = $this->schoolRepository->getDrivingSchool();

            foreach ($temp_schools as $key => $value) {
                $value->rating = $this->reviewRepository->getSchoolRating($value->user_id);
                $value->review_count = $this->reviewRepository->totalSchoolReview($value->user_id);
                $value->distance = $this->haversineDistance($value->latitude, $value->longitude, $request->lat, $request->long);
                array_push($schools,$value);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'schools' => $schools,
                'message' => $message,
            ]
        );
    }
    public function filterSchool(Request $request)
    {

        $code = 200;
        $message = "Success";
        $schools = [];
        try {
            $data = $this->schoolRepository->fillterDrivingSchool($request->name);
            foreach ($data as $s) {
                $s->rating = $this->reviewRepository->getSchoolRating($s->user_id);
                $s->review_count = $this->reviewRepository->totalSchoolReview($s->user_id);
                $s->distance = $this->haversineDistance($s->latitude, $s->longitude, $request->lat, $request->long);
                if ($s->distance >= (double) $request->startKm && $s->distance <= (double) $request->endKm) {
                    if($s->rating >= $request->r_start  && $s->rating <= $request->r_end){
                        array_push($schools, $s);
                    }
                }
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'schools' => $schools,
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
