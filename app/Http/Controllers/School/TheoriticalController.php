<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use App\Repositories\ScheduleLogsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\PracticalScheduleRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class TheoriticalController extends Controller
{
    public $orderListRepository;
    public $scheduleSessionRepository;

    public $vehicleRepository;
    public $scheduleRepository;
    public $scheduleInstructorRepository;
    public $scheduleVehicleRepository;
    public $instructorRepository;
    public $theoriticalRepository;
    public $scheduleStudentRespository;
    public $scheduleLogsRepository;
    public function __construct(
        InstructorRepositoryInterface $instructorRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoriticalRepository,
        OrderListRepositoryInterface $orderListRepositoryInterface,
        ScheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        VehicleRepositoryInterface $vehicleRepositoryInterface,
        SchedulesRepositoryInterface $scheduleRepositoryRepository,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleVehicleRepositoryInterface $scaheduleVehicleRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentRespository,
        ScheduleLogsRepositoryInterface $scheduleLogsRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->theoriticalRepository = $theoriticalRepository;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->scheduleSessionRepository = $scheduleSessionsRepositoryInterface;
        $this->vehicleRepository = $vehicleRepositoryInterface;
        $this->scheduleRepository = $scheduleRepositoryRepository;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->scheduleVehicleRepository = $scaheduleVehicleRepositoryInterface;
        $this->scheduleStudentRespository = $scheduleStudentRespository;
        $this->scheduleLogsRepository = $scheduleLogsRepositoryInterface;
    }
    public function index()
    {
        return view('school.features.theoritical_schedules.index');
    }
    public function showView($id)
    {
        $theoritical = $this->theoriticalRepository->retrieveSchoolWithIdheoreticalSchdules(
            $id,
            auth()->user()->schoolid,
        );


        return view('school.features.theoritical_schedules.view', [
            'theoritical' => $theoritical,
            'not_available' => $this->getNotAvailableInstructor($theoritical->start_date, $theoritical->end_date),
            'list_instructors' => $this->instructorRepository->getSchoolActiveInstructor(auth()->user()->schoolid),
            'instructors' => $this->scheduleInstructorRepository->getSchedulesInstructor($theoritical->schedule_id),
            'available' => $this->theoriticalRepository->getTheoriticalAvailableStudents(auth()->user()->schoolid, $theoritical->for_session_number),
            'students' => $this->scheduleStudentRespository->getScheduleStudents($theoritical->schedule_id),
            'logs' => $this->scheduleLogsRepository->getScheduleLogs($theoritical->schedule_id),
        ]);
    }

    public function getNotAvailableInstructor($start_date, $end_date)
    {
        $id = array();

        $schedule_ids = $this->scheduleRepository->getConflictSchedules(
            $start_date,
            $end_date,
            auth()->user()->schoolid,
            0,
        );
        foreach ($schedule_ids as $ids) {
            array_push($id, $ids->id);
        }

        $ins = $this->scheduleInstructorRepository->getConflictedInstructor($id);
        $instructor_id = array();

        foreach ($ins as $value) {
            array_push($instructor_id, $value->instructor_id);
        }
        return $instructor_id;
    }

    public function create()
    {
        return view('school.features.theoritical_schedules.create', [
            'instructors' => $this->instructorRepository->getSchoolActiveInstructor(auth()->user()->schoolid),
        ]);
    }
    public function updateView($id)
    {
        $theoritical = $this->theoriticalRepository->retrieveSchoolWithIdheoreticalSchdules(
            $id,
            auth()->user()->schoolid,
        );

        return view('school.features.theoritical_schedules.update', [
            'theoritical' => $theoritical,
            'instructors' => $this->scheduleInstructorRepository->getSchedulesInstructor($theoritical->schedule_id),
            'students' => $this->scheduleStudentRespository->getScheduleStudents($theoritical->schedule_id),
        ]);
    }
    public function addStudentList($id, Request $request)
    {
        foreach ($request->students as $session_id) {
            $this->scheduleSessionRepository->updateSchedule(
                $session_id,
                [
                    'schedule_id' => $id,
                ]
            );
            $session_info = $this->scheduleSessionRepository->getSessionInfo($session_id);
            $orders_info = $this->orderListRepository->getSingleOrderList($session_info->order_list_id, auth()->user()->schoolid);
            $this->scheduleStudentRespository->create([
                'schedule_id' => $id,
                'order_list_id' => $orders_info->id,
                'student_id' => $orders_info->student_id,
            ]);
        }
        return redirect()->back();
    }
    public function retrieveSchoolTheoriticalSchedules()
    {
        return json_encode($this->theoriticalRepository->retrieveSchoolTheoreticalSchdules(auth()->user()->id));
    }
    public function removeTheoriticalInstructor($id, $schedule_id, $instructor_id)
    {
        $this->scheduleInstructorRepository->removeTheoriticalInstructor($schedule_id, $instructor_id);
        return redirect()->back()->with('theoritical', 'Removed Successfully');
    }

    public function removeTheoriticalStudent($id, $order_list_id, $student_id)
    {

        $theoritical = $this->theoriticalRepository->retrieveSchoolWithIdheoreticalSchdules(
            $id,
            auth()->user()->schoolid,
        );
        if ($theoritical == null) {
            abort(404);
        }
        if($theoritical->status == 3){
            abort(404);
        }
 
        $this->scheduleStudentRespository->removeStudent(
            $theoritical->schedule_id,
            $student_id,
        );
        $this->scheduleSessionRepository->removeSessionSchedule(
            $theoritical->schedule_id,
            $order_list_id,
        );
        // $this->scheduleInstructorRepository->removeTheoriticalInstructor($schedule_id, $instructor_id);
        return redirect()->back()->with('theoritical', 'Removed Successfully');
    }
    public function store(Request $request)
    {




        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $schedule_id = $this->scheduleRepository->create(
            [
                'school_id' => auth()->user()->schoolid,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_hours' => number_format($this->calculateHoursDifference($start_date, $end_date), 2),
                'type' => 2,
            ]
        );
        $t_id = $this->theoriticalRepository->create([
            'school_id' => auth()->user()->id,
            'schedule_id' => $schedule_id,
            'title' => $request->title,
            'for_session_number' => $request->session_number,
            'slot' => $request->slot,
        ]);
        foreach ($request->instructors as $id) {
            $this->scheduleInstructorRepository->create([
                'schedule_id' => $schedule_id,
                'instructor_id' => $id,
            ]);
        }
        return redirect()->route('theoritical.view', [
            'id' => $t_id,
        ])->with('theoritical', 'Added successfully');

    }

    public function addInstructor(Request $request, $theoritical_id)
    {

        $theoritical = $this->theoriticalRepository->retrieveSchoolWithIdheoreticalSchdules(
            $theoritical_id,
            auth()->user()->schoolid,
        );

        foreach ($request->instructors as $id) {
            $this->scheduleInstructorRepository->create([
                'schedule_id' => $theoritical->schedule_id,
                'instructor_id' => $id,
            ]);
        }

        return redirect()->route('theoritical.view', [
            'id' => $theoritical_id,
        ])->with('theoritical', 'Added successfully');

    }
    public function updateAction($id, Request $request)
    {

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        $theoritical = $this->theoriticalRepository->retrieveSchoolWithIdheoreticalSchdules(
            $id,
            auth()->user()->schoolid,
        );
        if ($theoritical == null) {
            abort(404);
        }
        $t = $this->theoriticalRepository->update(
            $id,
            [
                'title' => $request->title,
                'for_session_number' => $request->session_number,
                'slot' => $request->slot,

            ]
        );
        $s = $this->scheduleRepository->updateScheduleWIthId(
            $theoritical->schedule_id,
            [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_hours' => number_format($this->calculateHoursDifference($start_date, $end_date), 2),
            ]
        );
        return redirect()->route('theoritical.view', [
            'id' => $id,
        ])->with('theoritical', 'Updated successfully');
    }

    function calculateHoursDifference($startDate, $endDate)
    {
        // Convert the input strings to Carbon instances
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Define the exclusion time range (12:01 PM to 1:00 PM)
        $exclusionStartTime = $start->copy()->setTime(12, 0, 0);
        $exclusionEndTime = $start->copy()->setTime(13, 0, 0);

        // Calculate the initial time difference in seconds
        $timeDifference = $end->diffInSeconds($start);
        // Check if the time range overlaps with the exclusion range
        if ($start < $exclusionEndTime && $end > $exclusionStartTime) {
            // Calculate the overlap duration in seconds
            $overlapStartTime = max($start, $exclusionStartTime);
            $overlapEndTime = min($end, $exclusionEndTime);
            $overlapDuration = $overlapEndTime->diffInSeconds($overlapStartTime);
            // Subtract the overlap duration from the total time difference
            $timeDifference -= $overlapDuration;
        }
        // Convert the time difference to hours
        $hoursDifference = $timeDifference / 3600; // 3600 seconds in an hour
        return $hoursDifference;
    }
}
