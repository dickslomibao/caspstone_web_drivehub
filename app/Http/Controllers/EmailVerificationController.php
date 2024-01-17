<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Repositories\Interfaces\EmailVerifyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Mail;

class EmailVerificationController extends Controller
{
    private $emailVerify;
    public function __construct(EmailVerifyRepositoryInterface $emailVerifyRepositoryInterface)
    {
        $this->emailVerify = $emailVerifyRepositoryInterface;
    }
    public function sendCodeMobile(Request $request)
    {
        $currentDateTime = Carbon::now();
        $dateTimeIn15Minutes = $currentDateTime->addMinutes(15)->format('Y-m-d H:i:s');
        $msg = "";
        $code = 200;
        $otp = rand(1000, 9999);
        $id = Str::random(150);
        try {

            $this->emailVerify->create([
                'id' => $id,
                'code' => $otp,
                'email' => $request->email,
                'date_expired' => $dateTimeIn15Minutes,
            ]);
            Mail::to($request->email)->send(
                new EmailVerification(
                    [
                        'otp' => $otp,
                        'id' => $id,
                    ]
                )
            );
        } catch (\Exception $ex) {
            $code = 505;
            $msg = $ex->getMessage();
        }
        return response()->json([
            'id' => $id,
            'code' => $code,
            'message' => $msg,
            'date_expired' => $dateTimeIn15Minutes,
        ]);
    }


}
