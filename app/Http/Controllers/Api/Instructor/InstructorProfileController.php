<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use Illuminate\Http\Request;
use Exception;

class InstructorProfileController extends Controller
{
    public $instructorRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepositoryInterface)
    {
        $this->instructorRepository = $instructorRepositoryInterface;
    }
    public function getInfo()
    {
        $message = "Success";
        $data = [];
        $code = 200;
        try {
            $data = $this->instructorRepository->getInstructorDataUsingUserId(auth()->user()->id);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'data' => $data,
                'message' => $message,
            ]
        );

    }
    public function updateInstructor(Request $request)
    {
        $message = "Success";
        $data = [];
        $code = 200;
        try {
            $data = $this->instructorRepository->update(auth()->user()->id, [
                'firstname' => $request->firstname,
                'middlename' => $request->middlename == "" ? null : $request->middlename,
                'lastname' => $request->lastname,
                'sex' => $request->sex,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ], );
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'data' => $data,
                'message' => $message,
            ]
        );

    }
}
