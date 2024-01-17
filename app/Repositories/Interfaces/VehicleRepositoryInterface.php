<?php

namespace App\Repositories\Interfaces;

interface VehicleRepositoryInterface
{
    public function create($data);
    public function edit();
    public function delete();
    public function update($id, $data);
    public function uniquePlateNumber($no, $operation, $id);
    public function retrieveAll($school_id);
    public function retrieveAllAvailable($school_id);
    public function retrieveFromId($id);
}

?>