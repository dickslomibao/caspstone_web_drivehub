<?php
namespace App\Repositories;

use App\Repositories\Interfaces\PracticalSchedulesRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PracticalSchedulesRepository implements PracticalSchedulesRepositoryInterface
{

    public function getInstructorSchedules($instructor_id)
    {

        return DB::table('practical_schedule')
            ->join('availed_services', 'practical_schedule.course_id', '=', 'availed_services.id')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('vehicles', 'practical_schedule.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'school_students.student_id', '=', 'users.id')
            ->where('practical_schedule.instructor_id', $instructor_id)
            ->select(
                "practical_schedule.*",
                "school_students.student_id",
                "users.profile_image",
                'school_students.firstname',
                'school_students.middlename',
                'school_students.lastname',
                'vehicles.name as vehicle_name'
            )->get();
    }


    public function getPracticalSchedulesWithListOfId($id)
    {
        return DB::table('practical_schedule')
            ->join('availed_services', 'practical_schedule.course_id', '=', 'availed_services.id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('vehicles', 'practical_schedule.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'availed_services.student_id', '=', 'users.id')
            ->whereIn('practical_schedule.id', $id)
            ->orderBy('practical_schedule.start_date')
            ->select(
                "practical_schedule.*",
                "school_students.student_id",
                "users.profile_image",
                "courses.name as course_name",
                "availed_services.duration",
                "users.username",
                "users.email",
                'school_students.firstname',
                'school_students.sex',
                'school_students.mobile_number',
                'school_students.birthdate',
                'school_students.sex',
                'school_students.middlename',
                'school_students.lastname',
                'vehicles.name as vehicle_name',
                'vehicles.model',
                'vehicles.manufacturer',
            )
            ->get();
    }

    public function getInstructoSchedulesGroupByDay($instructor_id)
    {
        return DB::select('SELECT date(start_date) as day, GROUP_CONCAT(id) as schedule_ids FROM `practical_schedule` where practical_schedule.instructor_id = ? GROUP BY day order by day ASC', [$instructor_id]);
    }

    public function getPracticalSchedulesWithId($id){
        return DB::table('practical_schedule')
            ->join('availed_services', 'practical_schedule.course_id', '=', 'availed_services.id')
            ->join('courses', 'availed_services.course_id', '=', 'courses.id')
            ->join('school_students', 'availed_services.student_id', '=', 'school_students.student_id')
            ->join('vehicles', 'practical_schedule.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'availed_services.student_id', '=', 'users.id')
            ->where('practical_schedule.id', $id)
            ->orderBy('practical_schedule.start_date')
            ->select(
                "practical_schedule.*",
                "school_students.student_id",
                "users.profile_image",
                "courses.name as course_name",
                "availed_services.duration",
                "users.username",
                "users.email",
                'school_students.firstname',
                'school_students.sex',
                'school_students.mobile_number',
                'school_students.birthdate',
                'school_students.sex',
                'school_students.middlename',
                'school_students.lastname',
                'vehicles.name as vehicle_name',
                'vehicles.model',
                'vehicles.manufacturer',
            )
            ->first();
    }

}
?>