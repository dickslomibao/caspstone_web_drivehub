<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $code = 505;
        $msg = "Login Credentials Invalid";
        $token = null;
        $user = null;
        try {
            $request->validate([
                'username_email' => 'required|max:255',
                'password' => 'required|max:255',
            ]);
            $user = User::where('username', $request->input('username_email'))->orWhere('email', $request->input('username_email'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)) {

                $userType = $user->type;
                if ($userType == 2) {
                    $userId = $user->id;
                    $code = 200;
                } else if ($userType == 3) {
                    $code = 200;
                }

                $msg = "Login successfully";
                $token = $user->createToken($request->device_name)->plainTextToken;
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
        }
        return response()->json(['code' => $code, 'message' => $msg, 'token' => $token, 'user' => $user]);
    }
}