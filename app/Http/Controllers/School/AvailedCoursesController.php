<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\CourseVariantRepository;
use App\Repositories\Interfaces\CashPaymentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\MockExamRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PracticalScheduleRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\ScheduleInstructorRepository;
use Illuminate\Http\Request;

class AvailedCoursesController extends Controller
{
    public $orderListRepository;
    public $sheduleSessionsRepository;
    public $instructorRepository;
    public $vehicleRepository;
    public $scheduleRepository;
    public $scheduleInstructorRepository;
    public $scheduleVehicleRepository;
    public $progressRepository;
    public $theoriticalScheduleRepository;
    public $courseRepository;
    public $orderRepository;

    public $mockExamRepository;

    public $questionRepository;
    public $cashPaymentRepository;
    public function __construct(
        CashPaymentRepositoryInterface $cashPaymentRepositoryInterface,
        OrderListRepositoryInterface $orderListRepositoryInterface,
        ScheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
        VehicleRepositoryInterface $vehicleRepositoryInterface,
        SchedulesRepositoryInterface $scheduleRepositoryRepository,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleVehicleRepositoryInterface $scaheduleVehicleRepositoryInterface,
        ProgressRepositoryInterface $progressRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoriticalScheduleRepositoryInterface,
        CourseRepositoryInterface $courseRepositoryInterface,
        OrderRepositoryInterface $orderRepositoryInterface,
        QuestionRepositoryInterface $questionRepositoryInterface,
        MockExamRepositoryInterface $mockExamRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->sheduleSessionsRepository = $scheduleSessionsRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->vehicleRepository = $vehicleRepositoryInterface;
        $this->scheduleRepository = $scheduleRepositoryRepository;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->scheduleVehicleRepository = $scaheduleVehicleRepositoryInterface;
        $this->progressRepository = $progressRepositoryInterface;
        $this->theoriticalScheduleRepository = $theoriticalScheduleRepositoryInterface;
        $this->courseRepository = $courseRepositoryInterface;
        $this->orderRepository = $orderRepositoryInterface;
        $this->cashPaymentRepository = $cashPaymentRepositoryInterface;
        $this->mockExamRepository = $mockExamRepositoryInterface;

        $this->questionRepository = $questionRepositoryInterface;
    }
    public function index()
    {
        $availed_courses = $this->orderListRepository->getSchoolAvailedCourses(auth()->user()->schoolid);
        return view("school.features.availed_courses.index", [
            'availed_courses' =>
            $availed_courses
        ]);
    }
    public function practicalProgressView($id)
    {
        $data = $this->mockExamRepository->getMockExam($id);
        $mock_list = [];
        foreach ($data as $key => $value) {
            $value->score = $this->mockExamRepository->getMockScore($value->id);
            array_push($mock_list, $value);
        }
        return view(
            'school.features.availed_courses.theoritical_view_mock',
            [
                'mock_list' => $mock_list,
            ]
        );

        // if ($availed == null) {
        //     abort(404);
        // }
        // return view('school.features.availed_courses.availed_course', [
        //     'availed' => $availed,
        //     'sessions' => $this->sheduleSessionsRepository->getOrderListSession($id),
        //     'schedules' => $this->scheduleRepository,
        //     'scheduleInstructorRepository' => $this->scheduleInstructorRepository,
        //     'scheduleVehicleRepository' => $this->scheduleVehicleRepository,
        //     'theoritical' => $this->theoriticalScheduleRepository,
        //     'completed_hours' => $this->courseRepository->getStudentCompletedHours($id),
        //     'total_assign_hours' => $this->orderListRepository->singleOrderListTotallHoursAssign(
        //         $id,
        //         0,
        //     ),
        // ]);
    }
    public function viewSession(Request $request)
    {
        $availed = $this->orderListRepository->getSingleOrderList($request->id, auth()->user()->schoolid);
        if ($availed == null) {
            abort(404);
        }
        return view('school.features.availed_courses.components.view_sessions', [
            'availed' => $availed,
            'sessions' => $this->sheduleSessionsRepository->getOrderListSession($request->id),
            'schedules' => $this->scheduleRepository,
            'scheduleInstructorRepository' => $this->scheduleInstructorRepository,
            'scheduleVehicleRepository' => $this->scheduleVehicleRepository,
            'theoritical' => $this->theoriticalScheduleRepository,
        ]);
    }
    public function availedCourseView($id)
    {

        $availed = $this->orderListRepository->getSingleOrderList($id, auth()->user()->schoolid);
        if ($availed == null) {
            abort(404);
        }
        $data = $this->mockExamRepository->getMockExam($id);
        $mock_list = [];
        foreach ($data as $key => $value) {
            $value->score = $this->mockExamRepository->getMockScore($value->id);
            array_push($mock_list, $value);
        }
        return view('school.features.availed_courses.availed_course', [
            'availed' => $availed,
            'sessions' => $this->sheduleSessionsRepository->getOrderListSession($id),
            'schedules' => $this->scheduleRepository,
            'scheduleInstructorRepository' => $this->scheduleInstructorRepository,
            'scheduleVehicleRepository' => $this->scheduleVehicleRepository,
            'progress' => $this->progressRepository->getOrderListProgress($id),
            'theoritical' => $this->theoriticalScheduleRepository,
            'completed_hours' => $this->courseRepository->getStudentCompletedHours($id),
            'mock_list' => $mock_list,
            'total_assign_hours' => $this->orderListRepository->singleOrderListTotallHoursAssign(
                $id,
                0,
            ),
        ]);
    }

    public function checkAllProgress(Request $request, $id)
    {
        $availed = $this->orderListRepository->getSingleOrderList($id, auth()->user()->schoolid);

        if ($availed == null) {
            abort(404);
        }


        $this->progressRepository->checkAllOrderListProgress(
            $id,
            auth()->user()->id,
        );

        return redirect()->route('view.availedcourse', [
            'id' => $id
        ])->with('message', 'Checked all successfully');
    }
    public function setAsCompleted(Request $request, $id)
    {
        $availed = $this->orderListRepository->getSingleOrderList($id, auth()->user()->schoolid);



        if ($availed == null) {
            abort(404);
        }
        if ($availed->status != 2) {
            abort(404);
        }
        $order = $this->orderRepository->getStudentSingleOrder($availed->order_id, auth()->user()->school_id);

        if ($order->payment_type == 1) {
            $totalPaid = $this->cashPaymentRepository->getOrderTotalPayment($availed->order_id);

            if ($totalPaid < $order->total_amount) {
                return redirect()->route('view.availedcourse', [
                    'id' => $id
                ])->with('message-error', 'Cannot completed, the student still have balance');
            }
        }


        $this->orderListRepository->update(
            $id,
            auth()->user()->schoolid,
            [
                'order_lists.status' => 3,
                'order_lists.remarks' => $request->remarks,
            ]
        );
        if ($this->orderListRepository->allOrderListofOrderIsCompleted($availed->order_id)) {
            $this->orderRepository->update($availed->order_id, [
                'status' => 5,
            ]);
        }
        return redirect()->route('view.availedcourse', [
            'id' => $id
        ])->with('message', 'Completed successfully');
    }
    public function createSesssion(Request $request, $id)
    {
        $availed = $this->orderListRepository->getSingleOrderList($id, auth()->user()->schoolid);
        $count = $request->count;
        if ($availed->session == 0) {
            $this->orderListRepository->update(
                $id,
                auth()->user()->schoolid,
                [
                    'order_lists.status' => 2,
                    'order_lists.session' => $request->count,
                ]
            );
            for ($i = 1; $i <= $count; $i++) {
                $this->sheduleSessionsRepository->create([
                    'schedule_id' => 0,
                    'order_list_id' => $id,
                    'session_number' => $i,
                ]);
            }
            if ($availed->type == 1) {
                $progress = $this->progressRepository->getCourseProgress($availed->course_id);
                foreach ($progress as $value) {
                    $sub_progress = $this->progressRepository->retrieveSubProgress($value->progress_id);
                    foreach ($sub_progress as $sub) {
                        $this->progressRepository->addStudentProgress([
                            'order_list_id' => $availed->id,
                            'sub_progress_id' => $sub->id,
                            'progress_id' => $value->progress_id,
                        ]);
                    }
                }
            }
        }
        return redirect()->back();
    }

    public function addSession($order_list_id)
    {
        $availed = $this->orderListRepository->getSingleOrderList($order_list_id, auth()->user()->schoolid);

        $this->orderListRepository->update($availed->id, auth()->user()->schoolid, [
            'order_lists.session' => $availed->session + 1,
        ]);
        $this->sheduleSessionsRepository->create([
            'schedule_id' => 0,
            'order_list_id' => $availed->id,
            'session_number' => $availed->session + 1,
        ]);
        return redirect()->back();
    }

    public function removeSession($order_list_id, $session_id)
    {
        $availed = $this->orderListRepository->getSingleOrderList($order_list_id, auth()->user()->schoolid);
        $session = $this->sheduleSessionsRepository->getSessionInfo($session_id);
        if ($availed == null || $session == null) {
            abort(405);
        }
        if ($availed->id != $session->order_list_id) {
            abort(404);
        }
        if ($availed->id != $session->order_list_id) {
            abort(404);
        }
        if ($availed->session != $session->session_number) {
            abort(404);
        }
        $this->sheduleSessionsRepository->deleteSession($session_id);
        $this->orderListRepository->update($availed->id, auth()->user()->schoolid, [
            'order_lists.session' => $availed->session - 1,
        ]);
        return redirect()->back();
    }
}
