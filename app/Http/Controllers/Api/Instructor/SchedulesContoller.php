<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Events\SendLocationEvent;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PracticalScheduleRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchedulesContoller extends Controller
{
    private $schedulesRepository;
    private $scheduleSessionsRepository;
    private $scheduleInstructorRepository;
    private $scheduleVehicleRepository;
    private $scheduleStudentRepository;
    private $scheduleLogsRepository;
    private $theoreticalSchdulesRepository;
    private $courseRepositoryInterface;
    private $progressRepository;
    private $studentRepository;
    public function __construct(
        SchedulesRepositoryInterface $shedulesRepositoryInterface,
        ScheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleVehicleRepositoryInterface $scheduleVehicleRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentsRepositoryInterface,
        ScheduleLogsRepositoryInterface $scheduleLogsRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoreticalSchdulesRepositoryInterface,
        CourseRepositoryInterface $courseRepositoryInterface,
        ProgressRepositoryInterface $progressRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
    ) {
        $this->schedulesRepository = $shedulesRepositoryInterface;
        $this->scheduleSessionsRepository = $scheduleSessionsRepositoryInterface;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->scheduleVehicleRepository = $scheduleVehicleRepositoryInterface;
        $this->scheduleStudentRepository = $scheduleStudentsRepositoryInterface;
        $this->scheduleLogsRepository = $scheduleLogsRepositoryInterface;
        $this->theoreticalSchdulesRepository = $theoreticalSchdulesRepositoryInterface;

        $this->progressRepository = $progressRepositoryInterface;
        $this->courseRepositoryInterface = $courseRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
    }

    public function getInstructorSchedules()
    {
        $code = 200;
        $message = "success";
        $schedules = [];
        try {
            foreach ($this->schedulesRepository->getInstructorSchedulesGroupByDay(auth()->user()->id) as $value) {
                $schedules_id = explode(",", $value->schedule_ids);
                $temp_schedule = [];
                foreach ($schedules_id as $id) {
                    $schedule = $this->schedulesRepository->getScheduleInfoWithId($id);
                    if ($schedule->type == 1) {
                        $schedule = $this->schedulesRepository->getScheduleFullInfoWithId($id);
                        $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
                        $schedule->session = $this->scheduleSessionsRepository->getSchedulesInfo($schedule->id);
                    } else {
                        $schedule->theoritical = $this->theoreticalSchdulesRepository->getTheoriticalWithScheduleId($schedule->id);
                    }
                    $schedule->students = $this->scheduleStudentRepository->getScheduleStudents($schedule->id);
                    array_push($temp_schedule, $schedule);
                }
                $value->schedules_list = $temp_schedule;
                array_push($schedules, $value);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'schedules' => $schedules,
                'message' => $message,
            ]
        );
    }

    public function viewStudentProgress(Request $request)
    {
        $code = 200;
        $message = "success";
        $student = [];
        try {
            $student = $this->studentRepository->getStudentWIithId($request->student_id);
            $student->progress = $this->progressRepository->getOrderListProgress($request->order_list_id);
            $student->completed_hrs = $this->courseRepositoryInterface->getStudentCompletedHours($request->order_list_id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'student' => $student,
                'message' => $message,
            ]
        );
    }
    public function getInstructorSingleSchedule($id)
    {
        $code = 200;
        $message = "success";
        $schedule = [];
        try {
            $schedule = $this->getSingleSched($id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'schedule' => $schedule,
                'message' => $message,
            ]
        );
    }

    public function startSchedule($schedule_id, Request $request)
    {
        $code = 200;
        $message = "success";
        $schedule = [];
        try {
            $schedule = $this->schedulesRepository->getScheduleInfoWithId($schedule_id);
            $startDateTime = Carbon::parse($schedule->start_date);
            $currentDateTime = Carbon::now();

            if ($currentDateTime >= $startDateTime) {

                if ($schedule->status == 1) {

                    if ($request->exists('start_mileage') && $request->start_mileage != "") {

                        $vv  = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);

                        if (DB::table('mileage')->where('vehicle_id', $vv->id)->exists()) {
                            $temp = DB::table('mileage')->where('vehicle_id', $vv->id)->orderByDesc('date_created')->first();
                            if ($request->start_mileage < $temp->mileage) {
                                throw new Exception('Invalid mileage. The last is ' . $temp->mileage);
                            }
                        }
                        DB::table('mileage')->insert(
                            [
                                'schedule_id' => $schedule_id,
                                'vehicle_id' => $vv->id,
                                'code' => 1,
                                'mileage' => $request->start_mileage,
                            ]
                        );
                    }

                    $this->schedulesRepository->updateScheduleWIthId($schedule_id, [
                        'status' => 2,
                    ]);
                    $this->scheduleLogsRepository->create(
                        [
                            'schedule_id' => $schedule_id,
                            'type' => 1,
                            'process_by' => auth()->user()->id,
                        ]
                    );
                }
                if ($schedule->type == 1) {
                    if ($schedule->type == 1) {
                        $schedule = $this->schedulesRepository->getScheduleFullInfoWithId($schedule_id);
                        $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
                        $schedule->session = $this->scheduleSessionsRepository->getSchedulesInfo($schedule->id);
                    } else {
                        $schedule->theoritical = $this->theoreticalSchdulesRepository->getTheoriticalWithScheduleId($schedule->id);
                    }
                    $schedule->students = $this->scheduleStudentRepository->getScheduleStudents($schedule->id);
                    for ($i = 0; $i < count($schedule->students); $i++) {
                        $schedule->students[$i]->progress = $this->progressRepository->getOrderListProgress($schedule->students[$i]->order_list_id);
                        $schedule->students[$i]->completed_hrs = $this->courseRepositoryInterface->getStudentCompletedHours($schedule->students[$i]->order_list_id);
                    }
                    $schedule->logs = $this->scheduleLogsRepository->getScheduleLogs($schedule->id);
                    $schedule->now = Carbon::now()->format('Y-m-d H:i:s');
                } else {
                    $schedule = $this->getSingleSched($schedule_id);
                }
            } else {
                throw new Exception('Cannot start it yet wait for ' . $startDateTime);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'schedule' => $schedule,
                'message' => $message,
            ]
        );
    }
    public function endSession(Request $request)
    {
        $message = "";
        $code = 200;
        try {
            $schedule = $this->schedulesRepository->getScheduleInfoWithId($request->schedule_id);
            if ($schedule->status == 2) {


                if ($request->exists('end_mileage') && $request->end_mileage != "") {
                    $vv  = $this->scheduleVehicleRepository->getScheduleVehicle($request->schedule_id);

                    if (DB::table('mileage')->where('vehicle_id', $vv->id)->exists()) {
                        $temp = DB::table('mileage')->where('vehicle_id', $vv->id)->orderByDesc('date_created')->first();
                        if ($request->end_mileage < $temp->mileage) {
                            throw new Exception('Invalid mileage. The last is ' . $temp->mileage);
                        }
                    }
                    DB::table('mileage')->insert(
                        [
                            'schedule_id' => $request->schedule_id,
                            'vehicle_id' => $vv->id,
                            'code' => 2,
                            'mileage' => $request->end_mileage,
                        ]
                    );
                }

                $this->schedulesRepository->updateScheduleWIthId($request->schedule_id, [
                    'status' => 3,
                    'complete_hours' => number_format($request->hrs + ($request->min / 60), 2),
                ]);
                $this->scheduleLogsRepository->create(
                    [
                        'schedule_id' => $request->schedule_id,
                        'type' => 2,
                        'process_by' => auth()->user()->id,
                    ]
                );
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function sendLocation(Request $request)
    {
        $code = 200;
        try {
            event(
                new SendLocationEvent(
                    $request->school_id,
                    [
                        'schedule_id' => $request->schedule_id,
                        'lat' => $request->latitude,
                        'long' => $request->longtitude
                    ],
                )
            );
        } catch (Exception $ex) {
            $code = 505;
        }
        return response()->json([
            'code' => $code,
            'id' => $request->schedule_id,
        ]);
    }
    public function scheduleReport(Request $request)
    {
        $code = 200;
        $message = "Successfully updated";
        try {
            $id =    DB::table('schedule_report')->insertGetId([
                'schedule_id' => $request->input('schedule_id'),
                'content' => $request->input('content'),
            ]);

            if ($request->exists('images')) {

                $images = $request->file('images');

                foreach ($images as $image) {
                    $path = $image->storePublicly('public/report');
                    $path = Str::replace('public', 'storage', $path);
                    DB::table('schedule_report_image')->insertGetId([
                        'schedule_report_id' => $id,
                        'path' => $path,
                    ]);
                }
            }
        } catch (Exception $ex) {
            $code = 505;
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function updateStudentProgress(Request $request)
    {
        $code = 200;
        $message = "Successfully updated";
        try {
            $this->progressRepository->updateStudentProgress($request->progress_id, [
                'status' => 2,
                'process_by' => auth()->user()->id,
            ]);
        } catch (Exception $ex) {
            $code = 505;
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    private function getSingleSched($id)
    {
        $schedule = $this->schedulesRepository->getScheduleInfoWithId($id);
        if ($schedule->type == 1) {
            $schedule = $this->schedulesRepository->getScheduleFullInfoWithId($id);
            $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
            $schedule->session = $this->scheduleSessionsRepository->getSchedulesInfo($schedule->id);
        } else {
            $schedule->theoritical = $this->theoreticalSchdulesRepository->getTheoriticalWithScheduleId($schedule->id);
        }
        $schedule->students = $this->scheduleStudentRepository->getScheduleStudents($schedule->id);
        if ($schedule->type == 1) {
            for ($i = 0; $i < count($schedule->students); $i++) {
                $schedule->students[$i]->progress = $this->progressRepository->getOrderListProgress($schedule->students[$i]->order_list_id);
                $schedule->students[$i]->completed_hrs = $this->courseRepositoryInterface->getStudentCompletedHours($schedule->students[$i]->order_list_id);
            }
        }
        $schedule->report = DB::table('schedule_report')->where('schedule_id', $id)->exists();
        $schedule->logs = $this->scheduleLogsRepository->getScheduleLogs($schedule->id);
        $schedule->now = Carbon::now()->format('Y-m-d H:i:s');
        return $schedule;
    }
}
