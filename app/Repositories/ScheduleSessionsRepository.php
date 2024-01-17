<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ScheduleSessionsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleSessionsRepository implements ScheduleSessionsRepositoryInterface
{
    public function create($data)
    {
        return DB::table('sessions')->insertGetId($data);
    }

    public function getOrderListSession($order_list_id)
    {
        return DB::table('sessions')->where('order_list_id', $order_list_id)->get();
    }

    public function updateSchedule($session_id, $data)
    {
        return DB::table('sessions')
            ->where('id', $session_id)
            ->update($data);
    }
    public function removeSessionSchedule($schedule_id, $order_list_id)
    {
        return DB::table('sessions')
            ->where('schedule_id', $schedule_id)
            ->where('order_list_id', $order_list_id)
            ->update([
                'schedule_id' => 0,
            ]);
    }
    
    public function getSessionInfo($session_id)
    {
        return DB::table('sessions')->where('id', $session_id)->first();
    }
    public function getSessionWithSession_number($session_id, $session_number)
    {
        return DB::table('sessions')->where('order_list_id', $session_id)->where('session_number', $session_number)->first();
    }
    public function deleteSession($session_id)
    {
        return DB::table('sessions')->where('id', $session_id)->delete();
    }
    //api
    public function getSchedulesInfo($schedule_id)
    {
        return DB::table('sessions')->where('schedule_id', $schedule_id)->first();
    }
}
