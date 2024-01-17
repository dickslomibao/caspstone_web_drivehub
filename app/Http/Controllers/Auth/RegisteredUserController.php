<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\Interfaces\EmailVerifyRepositoryInterface;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{

    private $emailVerify;
    public function __construct(
        EmailVerifyRepositoryInterface $emailVerifyRepositoryInterface,
    ) {

        $this->emailVerify = $emailVerifyRepositoryInterface;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {


        $privacy = DB::select('SELECT * FROM privacy ORDER BY id');
        $terms = DB::select('SELECT * FROM terms ORDER BY id');
        return view('auth.register', ['terms' => $terms, 'privacy' => $privacy]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function registerStudent(Request $request)
    {
        $code = 200;
        $message = "Created Successfully";
        $user = null;
        $token = null;
        try {

            $verify = $this->emailVerify->getwithLink($request->v_id);
            if ($verify == null) {
                throw new Exception("Invalid verification id" . $request->v_id, 505);
            }
            if ($verify->code != $request->code) {
                throw new Exception("Incorrect verification code", 505);
            }
            $path = $request->file('image')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);
            $user = User::create(
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 3,
                    'profile_image' => $path,
                    'email_verified_at' => now(),
                    'is_verified' => 2,
                ]
            );
            DB::table('students')->insertGetId([
                'student_id' => $user->id,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
            ]);
            event(new Registered($user));
            Auth::login($user);
            $token = $user->createToken($request->device_name)->plainTextToken;
        } catch (Exception $th) {
            $code = $th->getCode();
            $message = $th->getMessage();
        }
        return response()->json(['code' => $code, 'message' => $message, 'token' => $token, 'user' => $user]);
    }
}
