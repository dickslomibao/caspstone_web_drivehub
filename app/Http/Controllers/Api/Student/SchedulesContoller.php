<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\PracticalScheduleRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use App\Repositories\Interfaces\TheoreticalSchdulesRepositoryInterface;
use App\Repositories\TheoreticalSchdulesRepository;
use Illuminate\Http\Request;
use Exception;

class SchedulesContoller extends Controller
{
    private $schedulesRepository;
    private $scheduleSessionRepository;
    private $scheduleInstructorRepository;
    private $scheduleVehicleRepository;
    private $theoreticalSchdulesRepository;
    private $scheduleStudentRepository;
    private $instructorReportRepository;
    private $scheduleLogsRepository;
    private $reviewRepository;
    public function __construct(
        SchedulesRepositoryInterface $shedulesRepositoryInterface,
        ScheduleSessionsRepositoryInterface $scheduleSessionsRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleVehicleRepositoryInterface $scheduleVehicleRepositoryInterface,
        TheoreticalSchdulesRepositoryInterface $theoreticalSchdulesRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentsRepositoryInterface,
        ScheduleLogsRepositoryInterface $scheduleLogsRepositoryInterface,
        InstructorReportRepositoryInterface $instructorReportRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
    ) {
        $this->schedulesRepository = $shedulesRepositoryInterface;
        $this->scheduleSessionRepository = $scheduleSessionsRepositoryInterface;
        $this->scheduleInstructorRepository = $scheduleInstructorRepositoryInterface;
        $this->scheduleVehicleRepository = $scheduleVehicleRepositoryInterface;
        $this->theoreticalSchdulesRepository = $theoreticalSchdulesRepositoryInterface;
        $this->scheduleStudentRepository = $scheduleStudentsRepositoryInterface;
        $this->scheduleLogsRepository = $scheduleLogsRepositoryInterface;
        $this->instructorReportRepository = $instructorReportRepositoryInterface;
        $this->reviewRepository = $reviewRepositoryInterface;
    }

    public function getStudentSchedules()
    {
        $code = 200;
        $message = "success";
        $schedules = [];
        try {
            foreach ($this->schedulesRepository->getStudentSchedulesGroupByDay(auth()->user()->id) as $value) {
                $schedules_id = explode(",", $value->schedule_ids);
                $temp_schedule = [];
                foreach ($schedules_id as $id) {
                    $schedule = $this->schedulesRepository->getScheduleFullInfoWithId($id);
                    $schedule->session = $this->scheduleSessionRepository->getSchedulesInfo($schedule->id);
                    if ($schedule->type == 1) {
                        $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
                    } else {
                        $schedule->theoritical = $this->theoreticalSchdulesRepository->getTheoriticalWithScheduleId($schedule->id);
                    }
                    $schedule->instructor = $this->scheduleInstructorRepository->getSchedulesInstructor($schedule->id);

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
    public function reviewInstructor(Request $request)
    {
        $code = 200;
        $message = "Success";

        try {
            $this->reviewRepository->createInsructorReview([
                'student_id' => auth()->user()->id,
                'instructor_id' => $request->instructor_id,
                'school_id' => $request->school_id,
                'schedule_id' => $request->schedule_id,
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
    public function getStudentSingleSchedule($id)
    {
        $code = 200;
        $message = "success";
        $schedule = [];
        try {
            $schedule = $this->schedulesRepository->getScheduleInfoWithId($id);
            if ($schedule->type == 1) {
                $schedule = $this->schedulesRepository->getScheduleFullInfoWithId($id);
                $schedule->vehicle = $this->scheduleVehicleRepository->getScheduleVehicle($schedule->id);
                $schedule->session = $this->scheduleSessionRepository->getSchedulesInfo($schedule->id);
            } else {
                $schedule->students = $this->scheduleStudentRepository->getScheduleStudents($schedule->id);
                $schedule->theoritical = $this->theoreticalSchdulesRepository->getTheoriticalWithScheduleId($schedule->id);
            }
            $schedule->instructor = $this->scheduleInstructorRepository->getSchedulesInstructor($schedule->id);
            for ($i = 0; $i < count($schedule->instructor); $i++) {
                $schedule->instructor[$i]->reported = $this->instructorReportRepository->checkIfStudentReportedInstructorAlready(
                    $schedule->id,
                    auth()->user()->id,
                    $schedule->instructor[$i]->user_id,
                );
                $schedule->instructor[$i]->rate = $this->reviewRepository->checkIfStudentRateInstructorAlready(
                    $schedule->id,
                    auth()->user()->id,
                    $schedule->instructor[$i]->user_id,
                );
            }
            $schedule->logs = $this->scheduleLogsRepository->getScheduleLogs($schedule->id);

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
}
