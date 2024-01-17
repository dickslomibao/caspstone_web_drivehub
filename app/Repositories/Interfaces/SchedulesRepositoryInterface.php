<?php



namespace App\Repositories\Interfaces;

interface SchedulesRepositoryInterface
{
  public function create($data);
  public function getScheduleInfoWithId($id);
  //api-call
  public function updateScheduleWIthId($id, $data);
  public function getStudentSchedulesGroupByDay($student_id);
  public function getScheduleFullInfoWithId($id);

  public function getSchoolAllSchedule($school_id);
  public function getInstructorSchedulesGroupByDay($instructor_id);
  public function getConflictSchedules($start_date, $end_date, $school_id, $id);
  public function getScheduleFullInfoWithIdForTheoritical($id);
 
  

}
