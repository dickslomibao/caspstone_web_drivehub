<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ScheduleVehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleVehicleRepository implements ScheduleVehicleRepositoryInterface
{
    public function create($data)
    {
        return DB::table('schedule_vehicles')->insertGetId($data);
    }

    public function getConflictedVehicle($schedule_ids)
    {
        return DB::table('schedule_vehicles')
        ->whereIn('schedule_id',$schedule_ids)
        ->select(['vehicle_id'])
        ->groupBy('vehicle_id')
        ->get();
            
    }
    //vice-versa
    public function getScheduleVehicle($schedule_id)
    {
        return DB::table('schedule_vehicles')
            ->join('vehicles', 'schedule_vehicles.vehicle_id', "=", 'vehicles.id')
            ->where('schedule_vehicles.schedule_id', $schedule_id)
            ->select(['vehicles.*'])
            ->first();
    }
    public function updateSchedulesVehicle($schedule_id,$vehicle_id){
        DB::table('schedule_vehicles')->where('schedule_id', $schedule_id)->update([
            'vehicle_id' => $vehicle_id,
        ]);
    }
}
