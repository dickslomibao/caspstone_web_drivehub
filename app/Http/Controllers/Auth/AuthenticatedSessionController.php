<?php

namespace App\Http\Controllers\Auth;

use App\Classes\Account;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $code = 505;
        $msg = "Login Credentials Invalid";
        try {
            $request->validate([
                'username_email' => 'required|max:255',
                'password' => 'required|max:255',
            ]);
            $user = User::where('username', $request->input('username_email'))->orWhere('email', $request->input('email'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)) {
                $userType = $user->type;
                if ($userType == 3 || $userType == 2) {
                    $code = 404;
                    $msg = "You only have access on android application";
                } else {
                    if ($userType == 1) {
                        $userId = $user->id;
                        $code = 200;
                    } else if ($userType == 4) {
                        $code = 200;
                    } else if ($userType == 5) {
                        $code = 205;
                    }
                    $msg = "Login successfully";
                    Auth::login($user);
                }
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
        }
        return response()->json(['code' => $code, 'message' => $msg]);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
