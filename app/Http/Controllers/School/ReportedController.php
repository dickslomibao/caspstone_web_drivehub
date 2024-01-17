<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;

class ReportedController extends Controller
{
    public $instructorReportRepository;
    public $studentRepository;
    public $instructorRepository;
    public function __construct(InstructorReportRepositoryInterface $instructorReportRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
    ) {
        $this->instructorReportRepository = $instructorReportRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
    }
    public function view($id)
    {
        $value = $this->instructorReportRepository->getReportedWithId($id, auth()->user()->schoolid);
        $value->instructor = $this->instructorRepository->getInstructorDataUsingUserId($value->instructor_id);
        $value->student = $this->studentRepository->getStudentWIithId($value->student_id);

        return view('school.features.reported_management.view', [
            'report'=> $value,
        ]);
    }
    public function index()
    {
        return view('school.features.reported_management.index');
    }
    public function getReportedData()
    {
        $data = array();
        foreach ($this->instructorReportRepository->getSchoolReportedInstructor(auth()->user()->schoolid) as $value) {
            $value->instructor = $this->instructorRepository->getInstructorDataUsingUserId($value->instructor_id);
            $value->student = $this->studentRepository->getStudentWIithId($value->student_id);
            array_push($data, $value);
        }
        return response()->json($data);
    }
}
