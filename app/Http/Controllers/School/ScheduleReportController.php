<?php

namespace App\Http\Controllers\School;

use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleReportController extends Controller
{

    public $instructorReportRepository;
    public $studentRepository;
    public $instructorRepository;
    public $scheduleInstructorRepositoryInterface;
    public $scheduleStudentsRepositoryInterface;
    public function __construct(
        InstructorReportRepositoryInterface $instructorReportRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentsRepositoryInterface,
    ) {
        $this->instructorReportRepository = $instructorReportRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->scheduleInstructorRepositoryInterface = $scheduleInstructorRepositoryInterface;
        $this->scheduleStudentsRepositoryInterface = $scheduleStudentsRepositoryInterface;
    }
    public function view($id)
    {

        $value = DB::table('schedule_report')->where('id', $id)->first();

        $value->instructor = $this->scheduleInstructorRepositoryInterface->getSchedulesInstructor($value->schedule_id)[0];
        $value->student = $this->scheduleStudentsRepositoryInterface->getScheduleStudents($value->schedule_id)[0];
        $value->images = DB::table('schedule_report_image')->where('schedule_report_id', $id)->get();

        return view('school.features.schedule_report.view', [
            'report' => $value,
        ]);
    }
    public function index()
    {

        return view('school.features.schedule_report.index');
    }

    public function getReportedData()
    {
        $ids = DB::table('schedules')->where('school_id', auth()->user()->school_id)->pluck('id')->toArray();
        $data = array();
        foreach (DB::table('schedule_report')->whereIn('schedule_id', $ids)->get() as $value) {
            $value->instructor = $this->scheduleInstructorRepositoryInterface->getSchedulesInstructor($value->schedule_id)[0];
            // $value->student = $this->studentRepository->getSchedulesInstructor($ids-);
            array_push($data, $value);
        }
        return response()->json($data);
    }
}
