<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPassword extends Controller
{
    public function reset(Request $request)
    {
        $user = DB::table('users')->where('email', $request->email)->first();
        if ($user == null) {
            return redirect()->back()->with('error', 'The email is not yet registered.');
        } else {
            $id = Str::random(255);
            DB::table('reset_link')->insert([
                'id' => $id,
                'email' => $request->email
            ]);
            Mail::to($request->email)->send(
                new \App\Mail\ResetPassword(
                    $id,
                ),
            );
            return redirect()->back()->with('success', 'Password reset email sent successfully.');
        }
    }
}
