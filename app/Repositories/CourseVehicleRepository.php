<?php
namespace App\Repositories;

use App\Repositories\Interfaces\CourseVehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CourseVehicleRepository implements CourseVehicleRepositoryInterface
{
    public function create($data)
    {
        return DB::table('course_vehicle')->insert($data);
    }

    public function getCourseVehicle($course_id)
    {

        return DB::table('course_vehicle')
            ->join('vehicles', 'course_vehicle.vehicle_id', '=', 'vehicles.id')
            ->where('course_vehicle.course_id', $course_id)
            ->select(['vehicles.*'])->get();

    }
    public function deletCourseVehicle($course_id)
    {

        return DB::table('course_vehicle')->where('course_id', $course_id)->delete();

    }
}
?>