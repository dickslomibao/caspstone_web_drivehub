<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepositoryInterface)
    {
        $this->studentRepository = $studentRepositoryInterface;
    }
    public function alreadyRegisteredInDrivingSchool(Request $request)
    {
        $code = 200;
        $msg = "Success";
        $user = null;
        try {
            $user = $this->studentRepository->alreadyRegisteredInDrivingSchool($request->school_id, auth()->user()->id);
        } catch (Exception $ex) {
            $code = 500;
            $msg = $ex->getMessage();
        }
        return response()->json(['code' => $code, 'message' => $msg, 'exist' => $user]);
    }

}