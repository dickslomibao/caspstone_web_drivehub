<?php



namespace App\Repositories\Interfaces;

interface ScheduleVehicleRepositoryInterface
{
    public function create($data);
    public function getConflictedVehicle($schedule_ids);
    //vice-versa
    public function getScheduleVehicle($schedule_id);

    public function updateSchedulesVehicle($schedule_id,$vehicle_id);

}
