<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseRepositoryInterface
{
    public function create($data)
    {
        return DB::table('courses')->insertGetId($data);
    }

    public function retrieveFromId($id, $school_id)
    {
        return DB::table('courses')->where('id', $id)->where('school_id', $school_id)->first();
    }
    public function edit()
    {

    }
    public function delete()
    {

    }
    public function update($id, $data)
    {

    }
    public function retrieveAll($school_id)
    {
        return DB::table('courses')->where('school_id', $school_id)->get();
    }

    public function getDrivingSchoolCourses($school_id)
    {
        return DB::table('courses')
            ->where('school_id', $school_id)
            ->get();
    }
    public function getDrivingSchoolCoursesAvaibaleInPublic($school_id)
    {
        return DB::table('courses')
            ->where('school_id', $school_id)
            ->where('status', 1)
            ->where('visibility', 1)
            ->get();
    }
    public function getCourseWithId($course_id)
    {
        return DB::table('courses')->where('id', $course_id)->first();
    }
    public function getActiveCourses($school_id)
    {
        return DB::table('courses')->where('school_id', $school_id)->where('status', 1)->get();
    }

    public function filterCourse($name = "", $type = [1, 2], $price_start = 1, $price_end = 50000)
    {
        $data = DB::table('courses')
            ->select('*')
            ->selectSub(function ($query) {
                $query->selectRaw('MAX(courses_variant.price)')
                    ->from('courses_variant')
                    ->whereColumn('courses_variant.course_id', 'courses.id')
                    ->groupBy('courses_variant.course_id');
            }, 'max_price')
            ->selectSub(function ($query) {
                $query->selectRaw('MIN(courses_variant.price)')
                    ->from('courses_variant')
                    ->whereColumn('courses_variant.course_id', 'courses.id')
                    ->groupBy('courses_variant.course_id');

            }, 'min_price');
        if ($name != "") {
            $data->where("courses.name", "LIKE", "%$name%");
        }
        if (count($type) > 0) {
            $data->whereIn('courses.type', $type);
        }
        $data->having('min_price', '>=', $price_start);
        $data->having('max_price', '<=', $price_end);

        return $data->get();
    }
    public function getStudentCompletedHours($order_list_id)
    {
        $total = 0;
        $sessions = new ScheduleSessionsRepository();
        $schedules = new SchedulesRepository();
        foreach ($sessions->getOrderListSession($order_list_id) as $value) {
            if ($value->schedule_id == 0) {
                continue;
            }
            $schedule = $schedules->getScheduleInfoWithId($value->schedule_id);
            if ($schedule->status == 3) {
                $total += $schedule->complete_hours;
            }
        }
        return $total;
    }
}
