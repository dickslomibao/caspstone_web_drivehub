<?php

namespace App\Repositories;

use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InstructorReportRepository implements InstructorReportRepositoryInterface
{

    public function getSchoolReportedInstructor($school_id)
    {
        return DB::table('report_instructor')->where('school_id', $school_id)->get();
    }
    public function getReportedWithId($id, $school_id)
    {
        return DB::table('report_instructor')
            ->where('id', $id)
            ->where('school_id', $school_id)->first();
    }
    public function create($data)
    {
        return DB::table('report_instructor')->insertGetId($data);
    }
    public function checkIfStudentReportedInstructorAlready($schedule_id, $student_id, $instructor_id)
    {
        return DB::table('report_instructor')
            ->where('student_id', $student_id)
            ->where('schedule_id', $schedule_id)
            ->where('instructor_id', $instructor_id)
            ->count();
    }
}
?>