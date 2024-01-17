<?php

namespace App\Repositories;

use App\Repositories\Interfaces\StaffRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StaffRepository implements StaffRepositoryInterface
{
    private $filter = ['staff.*', 'users.email', 'users.profile_image', 'users.phone_number'];

    public function create($data)
    {
        DB::table('staff')->insert($data);
    }
    public function getSchoolStaff($school_id)
    {
        return DB::table('staff')->join('users', "staff.staff_id", "=", 'users.id')->where('school_id', $school_id)->select($this->filter)->get();

    }
    public function getSingleSchoolStaff($staff_id, $school_id)
    {
        return DB::table('staff')->join('users', "staff.staff_id", "=", 'users.id')
            ->where('staff.staff_id', $staff_id)
            ->where('staff.school_id', $school_id)
            ->select($this->filter)->first();
    }

    public function getSingleSchoolStaffWithId($staff_id)
    {
        return DB::table('staff')->join('users', "staff.staff_id", "=", 'users.id')
            ->where('staff.staff_id', $staff_id)
       
            ->select($this->filter)->first();
    }
    public function updateWithId($staff_id, $data)
    {
        return DB::table('staff')
            ->where('staff_id', $staff_id)
            ->update($data);
    }
}

?>