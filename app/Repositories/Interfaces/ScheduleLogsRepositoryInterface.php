<?php

namespace App\Repositories\Interfaces;


interface ScheduleLogsRepositoryInterface
{

    public function create($data);
    public function getScheduleLogs($schedule_id);
}
