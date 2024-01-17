<?php


namespace App\Repositories\Interfaces;

interface StudentRepositoryInterface
{
    public function create($data);
    public function update($student_id,$data);
    public function createStudent($data);
    public function retrieveFromId($id);
    public function retrieveSchoolStudentFromId($student_id, $school_id);

    public function retrieveSchoolStudent();
    public function getStudentWIithId($id);
   
    public function alreadyRegisteredInDrivingSchool($school_id, $student_id);

}


?>