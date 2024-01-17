<?php

namespace App\Http\Controllers;

use App\Repositories\InstructorRepository;
use App\Repositories\Interfaces\AvailCourseRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\VehicleRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class AvailCourseController extends Controller
{

    public $availCourseRepository;
    public $progressRepository;
    public $courseRepository;
    public function __construct(AvailCourseRepositoryInterface $availCourseRepository,
     ProgressRepositoryInterface $progressRepository, 
     CourseRepositoryInterface $courseRepository)
    {
        $this->availCourseRepository = $availCourseRepository;
        $this->progressRepository = $progressRepository;
        $this->courseRepository = $courseRepository;
    }

    public function schoolView()
    {
        return view('school.features.availed_courses.index');
    }
    public function schoolOrderView($id)
    {
        $order = $this->availCourseRepository->getSingleOrderUsingId($id);
        $paidsofar = $this->availCourseRepository->totalPaidOfCourse($order->id);
        $sessions = $this->availCourseRepository->getCourseSessions($order->id, auth()->user()->id);
        return view("school.features.availed_courses.order_view", [
            'order' => $order,
            'balance' => $paidsofar == null ? $order->price : $order->price - $paidsofar->amount,
            'sessions' => $sessions,
            'instructor' => new InstructorRepository(),
        ]);
    }
    public function schoolViewSetSessionSchedule($id, $session_id)
    {
        $order = $this->availCourseRepository->getSingleOrderUsingId($id);
        $session = $this->availCourseRepository->getCourseSingleSession($id, $session_id);
        $instructors = new InstructorRepository();
        $vehicles = new VehicleRepository();
        $assignedHours = $this->availCourseRepository->totalAssignedSessionHours($session_id, $id);
        
        return view("school.features.availed_courses.create_schedule", [
            'order' => $order,
            'instructors' => $instructors->getSchoolInstructor(auth()->user()->schoolid),
            'session' => $session,
            'vehicles' => $vehicles->retrieveAll(auth()->user()->schoolid),
            'remaining_hours' => $assignedHours == 0 ? $order->duration : $order->duration - $assignedHours,
        ]);
    }

    public function updateSessionSchedule(Request $request, $id, $session_id)
    {
        $order = $this->availCourseRepository->getSingleOrderUsingId($id);
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $this->availCourseRepository->updateSessionSchedule($session_id, [
            'vehicle_id' => $request->vehicle,
            'instructor_id' => $request->instructor,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_hours' => number_format($start_date->floatDiffInHours($end_date), 2),
        ]);
        if ($order->status == 2) {
            $this->availCourseRepository->udpdateOrderStatus($id, 3);
            $progress = $this->progressRepository->getCourseProgress($order->course_id);
            foreach ($progress as $value) {
                $sub_progress = $this->progressRepository->retrieveSubProgress($value->progress_id);
                foreach ($sub_progress as $sub) {
                    $this->progressRepository->addStudentProgress([
                        'order_id' => $id,
                        'sub_progress_id' => $sub->id,
                        'progress_id' => $value->progress_id,
                    ]);
                }
            }
        }
        return $this->schoolOrderView($id);
    }
    public function createPayment(Request $request, $id)
    {
        $order = $this->availCourseRepository->getSingleOrderUsingId($id);

        if ($order->status == 1) {
            $this->availCourseRepository->udpdateOrderStatus($id, 2);
        }
        $this->availCourseRepository->createCashPaymentForOrder([
            'id' => Str::random(8),
            'order_id' => $id,
            'school_id' => auth()->user()->id,
            'amount' => $request->amount,
        ]);
        return redirect()->back();
    }


    public function updateSession(Request $request, $id)
    {
        $this->availCourseRepository->updateSessionOfCourse($id, $request->count);
        for ($i = 1; $i <= $request->count; $i++) {
            $this->availCourseRepository->createSessionSchedule([
                'school_id' => auth()->user()->id,
                'course_id' => $id,
                'session_number' => $i,
            ]);
        }

        return redirect()->back();
    }


    public function schoolListAvailedServices()
    {
        return json_encode($this->availCourseRepository->schoolOrderList());
    }
    //mobileApiCall
    public function createOrder(Request $request)
    {
        $code = 200;
        $message = "Ordered Succcessfully";
        $id = null;
        $course = $this->courseRepository->retrieveFromId($request->course_id);
        try {
            $id = Str::random(8);
            $this->availCourseRepository->createOrder([
                'id' => $id,
                'student_id' => auth()->user()->id,
                'course_id' => $request->course_id,
                'payment_type' => $request->payment_type,
                'school_id' => $request->school_id,
                'created_by' => auth()->user()->id,
                'duration' => $course->duration,
                'price' => $course->price,
            ], );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function getStudentCourses()
    {
        $code = 200;
        $message = "Succcessfully";
        $courses = null;
        try {
            $courses = $this->availCourseRepository->getStudentCourses(auth()->user()->id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'courses' => $courses,
        ]);
    }
    public function totalPaidOfCourse(Request $request)
    {
        $code = 200;
        $message = "Successfully";
        $amount = null;
        try {
            $amount = $this->availCourseRepository->totalPaidOfCourse($request->order_id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'amount' => $amount->amount ?? 0,
        ]);
    }
    public function getStudentSinglerOder(Request $request)
    {
        $code = 200;
        $message = "Successfully";
        $course = null;
        try {
            $course = $this->availCourseRepository->getStudentSinglerOder($request->order_id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'course' => $course,
        ]);
    }

    public function getCourseSessions(Request $request)
    {
        $code = 200;
        $message = "Successfully";
        $session = null;
        try {
            $session = $this->availCourseRepository->getCourseSessions($request->order_id, $request->school_id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'sessions' => $session,
        ]);
    }
}