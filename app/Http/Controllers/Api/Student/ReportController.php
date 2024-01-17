<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\SchedulesRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    private $instructorReportRepository;
    private $scheduleInstructorRepository;
    public function __construct(InstructorReportRepositoryInterface $instructorReportRepositoryInterface, SchedulesRepositoryInterface $schedulesRepositoryInterface, )
    {
        $this->instructorReportRepository = $instructorReportRepositoryInterface;
        $this->scheduleInstructorRepository = $schedulesRepositoryInterface;
    }
    public function create(Request $request)
    {
        $code = 200;
        $message = "success";
        try {
            $schedule = $this->scheduleInstructorRepository->getScheduleInfoWithId($request->schedule_id);
            $this->instructorReportRepository->create([
                "student_id" => auth()->user()->id,
                "schedule_id" => $request->schedule_id,
                "instructor_id" => $request->instructor_id,
                "school_id" => $schedule->school_id,
                "comments" => $request->comments,
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
}
