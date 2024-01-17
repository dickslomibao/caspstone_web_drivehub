<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ScheduleLogsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleLogsRepository implements ScheduleLogsRepositoryInterface
{

    public function create($data)
    {
        return DB::table("schedule_logs")->insert($data);
    }

    public function getScheduleLogs($schedule_id)
    {
        return DB::table("schedule_logs")->where('schedule_id', $schedule_id)->get();
    }
}
