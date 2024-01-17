<?php
namespace App\Repositories;

use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VehicleRepository implements VehicleRepositoryInterface
{
    public function create($data)
    {
        return DB::table('vehicles')->insertGetId($data);
    }
    public function edit()
    {

    }

    public function delete()
    {

    }
    public function update($id, $data)
    {
        DB::table('vehicles')->where('id', $id)->update($data);
    }
    public function uniquePlateNumber($no, $operation, $exceptId)
    {
        if ($operation == "add") {
            return !DB::table('vehicles')->where('plate_number', $no)->exists();
        }
        return !DB::table('vehicles')->where('plate_number', $no)->where('id', "!=", $exceptId)->exists();

    }
    public function retrieveAllAvailable($school_id)
    {
        return DB::table('vehicles')->where('school_id', $school_id,
        )->where('status', 1)->get();
    }
    public function retrieveAll($school_id)
    {
        return DB::table('vehicles')->where('school_id', $school_id)->get();
    }
    public function retrieveFromId($id)
    {
        return DB::table('vehicles')->where('id', $id)->first();
    }
}
?>