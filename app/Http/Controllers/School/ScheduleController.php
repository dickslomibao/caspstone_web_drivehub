<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseVehicleRepositoryInterface;
use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\ScheduleVehicleRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public $orderListRepository;
    public $sheduleSessionsRepository;
    public $instructorRepository;
    public $vehicleRepository;
    public $scheduleRepository;
    public $scheduleInstructorRepository;
    public $scheduleVehicleRepository;
    public $scheduleStudentsRepository;
    public $orderRepository;
    public $theoriticalRepository;
    public $studentRepository;
    public $courseVehicleRepository;
    public $scheduleLogsRepository;
    public function __construct(
        OrderListRepositoryInterface $orderListRepositoryInterface,
        ScheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
        VehicleRepositoryInterface $vehicleRepositoryInterface,
        SchedulesRepositoryInterface $schedulesRepositoryInterface,
        ScheduleVehicleRepositoryInterface $scheduleVehicleRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentsRepositoryInterface,
        OrderRepositoryInterface $orderRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoreticalSchdulesRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
        CourseVehicleRepositoryInterface $courseVehicleRepositoryInterface,
        ScheduleLogsRepositoryInterface $scheduleLogsRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->sheduleSessionsRepository = $scheduleSessionsRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->vehicleRepository = $vehicleRepositoryInterface;
        $this->scheduleRepository = $schedulesRepositoryInterface;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->scheduleVehicleRepository = $scheduleVehicleRepositoryInterface;
        $this->orderRepository = $orderRepositoryInterface;
        $this->scheduleStudentsRepository = $scheduleStudentsRepositoryInterface;
        $this->theoriticalRepository = $theoreticalSchdulesRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
        $this->courseVehicleRepository = $courseVehicleRepositoryInterface;
        $this->scheduleLogsRepository = $scheduleLogsRepositoryInterface;
    }

    public function calendar()
    {
        $data = [];
        $schedules = $this->scheduleRepository->getSchoolAllSchedule(auth()->user()->schoolid);
        foreach ($schedules as $key => $s) {
            $temp = [];
            $theoritical = $this->theoriticalRepository->getTheoriticalWithScheduleId($s->id);

            if ($theoritical != null) {
                $temp['title'] = $theoritical->title;
            } else {
                $temp['title'] = "Practical schedule";
            }
            $temp['id'] = $s->id;
            $temp['start'] = $s->start_date;
            $temp['end'] = $s->end_date;
            switch ($s->status) {
                case 1:
                    $temp['color'] = '#9d9d9d';
                    break;
                case 2:
                    $temp['color'] = 'blue';
                    break;
                case 3:
                    $temp['color'] = 'forestgreen';
                    break;
                default:

                    break;
            }
            array_push($data, $temp);
        }
        return view('school.features.calendar.index', [
            'schedules' => $data,
        ],);
    }

    public function viewShedule(Request $request)
    {

        $schedule = $this->scheduleRepository->getScheduleInfoWithId($request->id);
        if ($schedule->type == 1) {
            $schedule = $this->scheduleRepository->getScheduleFullInfoWithId($request->id);
            $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
            $schedule->session = $this->sheduleSessionsRepository->getSchedulesInfo($schedule->id);
            $schedule->mileage = DB::table('mileage')->where('schedule_id', $schedule->id)->get();
        } else {
            $schedule->theoritical = $this->theoriticalRepository->getTheoriticalWithScheduleId($schedule->id);
        }
        $schedule->instructors = $this->scheduleInstructorRepository->getSchedulesInstructor($schedule->id);;
        $schedule->students = $this->scheduleStudentsRepository->getScheduleStudents($schedule->id);
        $schedule->logs = $this->scheduleLogsRepository->getScheduleLogs($schedule->id);

        return view('school.features.components.view_schedule', [
            'schedule' => $schedule
        ]);
    }
    public function viewPractical($oderlist_id, $session_id)
    {
        $order = $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid);

        $session = $this->sheduleSessionsRepository->getSessionInfo($session_id);
        if ($order == null || $session == null) {
            abort(404);
        }
        if ($session->schedule_id != 0) {
            abort(404);
        }
        if ($session->order_list_id != $order->id) {
            abort(404);
        }
        if ($session->session_number >= 2) {
            $t = $this->sheduleSessionsRepository->getSessionWithSession_number($oderlist_id, $session->session_number - 1);
            if ($t->schedule_id == 0) {
                abort(404);
            }
        }

        return view(
            'school.features.availed_courses.create_schedule',
            [
                'course' => $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid),
                'session' => $session,
                'total_assign_hours' => $this->orderListRepository->singleOrderListTotallHoursAssign(
                    $oderlist_id,
                    0,
                ),
                'instructors' => $this->instructorRepository->getSchoolInstructor(auth()->user()->schoolid),
                'vehicles' => $this->courseVehicleRepository->getCourseVehicle($order->course_id),
                'd_time' => DB::table('school_openhours')
                    ->where('school_id', Auth::user()->schoolid)->first(),
            ]
        );
    }
    public function updatePractical($oderlist_id, $session_id)
    {
        $order = $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid);
        $session = $this->sheduleSessionsRepository->getSessionInfo($session_id);
        if ($order == null || $session == null) {
            abort(404);
        }
        if ($session->schedule_id == 0) {
            abort(404);
        }
        if ($session->order_list_id != $order->id) {
            abort(404);
        }
        $schedule = $this->scheduleRepository->getScheduleInfoWithId(
            $session->schedule_id,
        );
        if ($schedule == null) {
            abort(404);
        }
        if ($schedule->status != 1) {
            abort(404);
        }
        $i = $this->scheduleInstructorRepository->getPracticalInstructor($schedule->id)->instructor_id;
        $v = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id)->id;

        return view(
            'school.features.availed_courses.update_schedule',
            [
                'course' => $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid),
                'session' => $session,
                'total_assign_hours' => $this->orderListRepository->singleOrderListTotallHoursAssign(
                    $oderlist_id,
                    $schedule->id,
                ),
                'instructors' => $this->instructorRepository->getSchoolInstructor(auth()->user()->schoolid),
                'vehicles' => $this->vehicleRepository->retrieveAll(auth()->user()->schoolid),
                'schedule' => $schedule,
                'i' => $i,
                'v' => $v,
                'd_time' => DB::table('school_openhours')
                    ->where('school_id', Auth::user()->schoolid)->first(),
            ]
        );
    }
    public function storePractical(Request $request, $oderlist_id, $session_id)
    {

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $order = $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid);

        $schedule_id = $this->scheduleRepository->create(
            [
                'school_id' => auth()->user()->schoolid,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_hours' => $this->calculateHoursDifference($start_date, $end_date),
            ]
        );
        $this->sheduleSessionsRepository->updateSchedule(
            $session_id,
            [
                'schedule_id' => $schedule_id,
            ]
        );
        $this->scheduleInstructorRepository->create([
            'schedule_id' => $schedule_id,
            'instructor_id' => $request->instructor,
        ]);

        $this->scheduleVehicleRepository->create([
            'schedule_id' => $schedule_id,
            'vehicle_id' => $request->vehicle,
        ]);

        $this->scheduleStudentsRepository->create([
            'schedule_id' => $schedule_id,
            'order_list_id' => $order->id,
            'student_id' => $order->student_id,
        ]);
        $student = $this->studentRepository->getStudentWIithId($order->student_id);
        $ch = curl_init();
        $parameters = array(
            'apikey' => env('SEMAPHORE_KEY'),
            'number' => $student->phone_number,
            'message' => 'Hi ' . $student->firstname . ',Your practical schedule will be on ' . $start_date . " - " . $end_date,
            'sendername' => 'DriveHub'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return redirect()->route('view.availedcourse', [
            'id' => $order->id,
        ])->with('message', 'Created successfully');
    }

    public function updateActionPractical(Request $request, $oderlist_id, $session_id)
    {

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $order = $this->orderListRepository->getSingleOrderList($oderlist_id, auth()->user()->schoolid);
        $session = $this->sheduleSessionsRepository->getSessionInfo($session_id);
        $schedule_id = $this->scheduleRepository->updateScheduleWIthId(
            $session->schedule_id,
            [

                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_hours' => number_format($this->calculateHoursDifference($start_date, $end_date), 2),
            ]
        );
        $i = $this->scheduleInstructorRepository->getPracticalInstructor($session->schedule_id)->instructor_id;
        $v = $this->scheduleVehicleRepository->getScheduleVehicle($session->schedule_id)->id;

        if ($i != $request->instructor) {
            $this->scheduleInstructorRepository->updateSchedulesInstructor($session->schedule_id, $request->instructor);
        }
        if ($v != $request->vehicle) {
            $this->scheduleVehicleRepository->updateSchedulesVehicle($session->schedule_id, $request->vehicle);
        }

        $student = $this->studentRepository->getStudentWIithId($order->student_id);

        $ch = curl_init();
        $parameters = array(
            'apikey' => env('SEMAPHORE_KEY'),
            'number' => $student->phone_number,
            'message' => 'Hi ' . $student->firstname . ',Your practical has been rescheduled on ' . $start_date . " - " . $end_date,
            'sendername' => 'DriveHub'
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return redirect()->route('view.availedcourse', [
            'id' => $order->id,
        ])->with('message', 'Updated successfully');
    }

    public function getInstructorAndVehicleNotAvailableWithSelectedTime(Request $request)
    {
        $id = array();

        $schedule_ids = $this->scheduleRepository->getConflictSchedules(
            $request->start_date,
            $request->end_date,
            auth()->user()->schoolid,
            $request->id,
        );

        foreach ($schedule_ids as $ids) {
            array_push($id, $ids->id);
        }
        return response()->json(
            array(
                'instructors' => $this->scheduleInstructorRepository->getConflictedInstructor($id),
                'vehicles' => $this->scheduleVehicleRepository->getConflictedVehicle($id),
                'students' => $this->scheduleStudentsRepository->getConflictedStudent($id)
            )
        );
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


    public function viewScheduleVehicle(Request $request)
    {

        $schedule = $this->scheduleRepository->getScheduleInfoWithId($request->id);
        if ($schedule->type == 1) {
            $schedule = $this->scheduleRepository->getScheduleFullInfoWithId($request->id);
            $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
            $schedule->session = $this->sheduleSessionsRepository->getSchedulesInfo($schedule->id);
            $schedule->mileage = DB::table('mileage')->where('schedule_id', $schedule->id)->get();
        } else {
            $schedule->theoritical = $this->theoriticalRepository->getTheoriticalWithScheduleId($schedule->id);
        }
        $schedule->instructors = $this->scheduleInstructorRepository->getSchedulesInstructor($schedule->id);;
        $schedule->students = $this->scheduleStudentsRepository->getScheduleStudents($schedule->id);
        $schedule->logs = $this->scheduleLogsRepository->getScheduleLogs($schedule->id);

        return view('school.features.components.view_schedule_vehicle', [
            'schedule' => $schedule
        ]);
    }
}
