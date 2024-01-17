<?php
namespace App\Repositories;

use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SchoolRepository implements SchoolRepositoryInterface
{

    public function getInfo($id)
    {
        return DB::table('schools')->where('user_id', $id)->first();
    }

    public function fillterDrivingSchool($name)
    {
        $data = DB::table('schools');
        $data->join('users', 'schools.user_id', "=", "users.id");
        if ($name != "") {

            $data->where("schools.name", "LIKE", "%$name%");
        }
        $data->select(['schools.*', 'users.profile_image']);
        return $data->get();
    }

    public function  getDrivingSchool(){
      return  DB::table('schools')
      ->join('users', "schools.user_id", "=", 'users.id', )
      ->select('schools.*', 'users.profile_image')->get();
    }
    public function getDrivingSchoolWithId($school_id)
    {
        return
            DB::table('schools')
            ->join('users', "schools.user_id", "=", 'users.id', )
             ->select('schools.*', 'users.profile_image')
            ->where('schools.user_id', $school_id)->first();
    }

}
?>