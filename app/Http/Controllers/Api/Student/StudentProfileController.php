<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Mail\ChangePasswordSuccess;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Mail;

class StudentProfileController extends Controller
{
    public $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepositoryInterface)
    {
        $this->studentRepository = $studentRepositoryInterface;
    }
    public function getInfo()
    {

        $message = "Success";
        $data = [];
        $code = 200;
        try {
            $data = $this->studentRepository->getStudentWIithId(auth()->user()->id);
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
    function convertToLocalFormat($phoneNumber)
    {
        // Remove leading plus sign and any spaces
        $phoneNumber = str_replace(['+', ' '], '', $phoneNumber);

        // Check if the phone number starts with '63'
        if (substr($phoneNumber, 0, 2) === '63') {
            // Replace '63' with '0'
            $phoneNumber = '0' . substr($phoneNumber, 2);
        }

        return $phoneNumber;
    }
    public function sendOtp(Request $request)
    {

        $message = "Success";
        $data = [];
        $code = 200;
        try {

            if (DB::table('users')->where('phone_number', $this->convertToLocalFormat($request->number))->exists()) {
                $code = 403;
                $message = 'Phone number already used.';
            } else {
                $ch = curl_init();
                $parameters = array(
                    'apikey' => env('SEMAPHORE_KEY'),
                    'number' => $request->number,
                    'message' => 'OTP',
                    'code' => $request->code,
                    'sendername' => 'DriveHub'
                );
                curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/otp');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);
            }
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
    public function updateInfo(Request $request)
    {

        $message = "Success";
        $data = [];
        $code = 200;
        try {
            $data = $this->studentRepository->update(auth()->user()->id, [
                'firstname' => $request->firstname,
                'middlename' => $request->middlename == "" ? null : $request->middlename,
                'lastname' => $request->lastname,
                'sex' => $request->sex,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ]);
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
    public function updateNumber(Request $request)
    {

        $message = "Success";
        $code = 200;
        try {
            $request->user()->update([
                'phone_number' => $this->convertToLocalFormat($request->number),
            ]);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
            ]
        );

    }
    public function updatePassword(Request $request)
    {
        $message = "Success";

        $code = 200;
        try {
            if (Hash::check($request->input('old_password'), auth()->user()->password)) {
                $request->user()->update([
                    'password' => Hash::make($request->password),
                ]);
                Mail::to($request->user()->email)->send(
                    new ChangePasswordSuccess(
                        [
                            'name' => auth()->user()->info->firstname . " " . auth()->user()->info->lastname,
                        ]
                    )
                );
            } else {
                $code = 403;
                $message = "Old password is incorrect.";
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
            ]
        );

    }
}
