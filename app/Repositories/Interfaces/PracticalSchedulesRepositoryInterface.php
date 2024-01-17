<?php 

namespace App\Repositories\Interfaces;

interface PracticalSchedulesRepositoryInterface{


    public function getInstructorSchedules($instructor_id);

    public function  getInstructoSchedulesGroupByDay($instructor_id);
    public function  getPracticalSchedulesWithListOfId($id);
    public function  getPracticalSchedulesWithId($id);

}

?>