<?php
namespace App\Repositories;

use App\Repositories\Interfaces\StudentRepositoryInterface;

use Illuminate\Support\Facades\DB;

class StudentRepository implements StudentRepositoryInterface
{
    public function create($data)
    {
        DB::table('students')->insert($data);
    }
    public function createStudent($data)
    {
        DB::table('school_students')->insertOrIgnore($data);
    }
    public function retrieveFromId($id)
    {
        return DB::table('school_students')->where('id', $id)->first();
    }
    public function retrieveSchoolStudentFromId($student_id, $school_id)
    {
        return DB::table('school_students')
            ->where('student_id', $student_id)
            ->where('school_id', $school_id)
            ->first();
    }
    public function update($student_id, $data)
    {
        return DB::table('students')->where('student_id', $student_id)->update($data);
    }
    public function retrieveSchoolStudent()
    {
        return DB::table('school_students')
            ->join('users', 'users.id', "=", "school_students.student_id")
            ->join('students', 'school_students.student_id', "=", 'students.student_id')
            ->where('school_students.school_id', auth()->user()->id)
            ->select(['students.*', 'users.email', 'users.phone_number','users.profile_image'])->get();
    }
    public function alreadyRegisteredInDrivingSchool($school_id, $student_id)
    {
        return DB::table('school_students')->where('student_id', $student_id)->where('school_id', $school_id)->exists();
    }
    public function getStudentWIithId($id)
    {
        return DB::table('students')
            ->join('users', 'students.student_id', "=", 'users.id')
            ->select(['students.*', 'users.email', 'users.username', 'users.phone_number', 'users.profile_image'])
            ->where('students.student_id', $id)
            ->first();
    }
    
}


?>