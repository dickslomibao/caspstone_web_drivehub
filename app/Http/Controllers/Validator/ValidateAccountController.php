<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ValidateAccountController extends Controller
{
    public function validateUsernameOrEmail(Request $request)
    {
        $input=$request->input('data');
        if($request->input('type') == "phone_number"){
            $input = $this->convertToLocalFormat($request->input('data'));
        }
        return response()->json(!User::where($request->input('type'), $input)->exists());
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
    public function checkUsernameAndEmailMobile(Request $request)
    {

        $msg = "";
        $code = 200;
        $email = false;
        $username = false;
        try {
            $email = User::where('email', $request->input('email'))->exists();
            $username = User::where('username', $request->input('username'))->exists();
        } catch (\Exception $ex) {
            $code = 505;
            $msg = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'email' => $email,
            'username' => $username,
            'message' => $msg,
        ]);
    }


}