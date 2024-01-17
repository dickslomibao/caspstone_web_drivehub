<?php 



namespace App\Repositories\Interfaces;

interface ScheduleSessionsRepositoryInterface
{
    public function create($data);
    public function updateSchedule($session_id, $data);
    public function getSessionInfo($session_id);

    public function deleteSession($session_id);
    //vice-versa
    public function getOrderListSession($order_list_id);
    public function getSessionWithSession_number($session_id,$session_number);
    //api
    public function getSchedulesInfo($schedule_id);
    public function removeSessionSchedule($schedule_id, $order_list_id);
}
