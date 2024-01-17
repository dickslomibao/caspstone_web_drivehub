<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Interfaces\StaffRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;

class StaffController extends Controller
{
    private $staffRepository;
    private $instructorRepository;
    public function __construct(StaffRepositoryInterface $staffRepositoryInterface, InstructorRepositoryInterface $instructorRepositoryInterface)
    {
        $this->middleware('auth');
        $this->middleware('role:5');;
        $this->staffRepository = $staffRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
    }
    public function index()
    {
        return view('school.features.staff_management.index', ['staffs' => $this->staffRepository->getSchoolStaff(auth()->user()->schoolid)]);
    }
    public function create()
    {
        return view('school.features.staff_management.create');
    }

    public function promote($staff_id)
    {
        $staff = $this->staffRepository->getSingleSchoolStaff($staff_id, auth()->user()->schoolid);
        if ($staff == null) {
            abort(404);
        }
        if (DB::table('instructors')->where('user_id', $staff_id)->exists()) {
            DB::table('instructors')->where('user_id', $staff_id)->update(
                [
                    'user_id' =>  $staff->staff_id,
                    'school_id' => $staff->school_id,
                    'firstname' =>  $staff->firstname,
                    'middlename' =>  $staff->middlename,
                    'lastname' =>  $staff->lastname,
                    'sex' =>  $staff->sex,
                    'birthdate' =>  $staff->birthdate,
                    'address' =>  $staff->address,
                    'status' => 1,
                ]
            );
        } else {
            $this->instructorRepository->create(
                [
                    'user_id' =>  $staff->staff_id,
                    'school_id' => $staff->school_id,
                    'firstname' =>  $staff->firstname,
                    'middlename' =>  $staff->middlename,
                    'lastname' =>  $staff->lastname,
                    'sex' =>  $staff->sex,
                    'birthdate' =>  $staff->birthdate,
                    'address' =>  $staff->address,
                ]
            );
        }

        $this->staffRepository->updateWithId($staff_id, [
            'status' => 5,
        ]);
        $u =  User::findOrFail($staff->staff_id);
        $u->type = 2;
        $u->save();

        return redirect()->back();
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
    public function update($staff_id)
    {
        $staff = $this->staffRepository->getSingleSchoolStaff($staff_id, auth()->user()->schoolid);
        if ($staff == null) {
            abort(404);
        }
        return view('school.features.staff_management.update', [
            'staff' => $staff
        ]);
    }
    public function saveUpdate(Request $request, $staff_id)
    {
        $staff = $this->staffRepository->getSingleSchoolStaff($staff_id, auth()->user()->schoolid);

        $r = $this->staffRepository->updateWithId($staff_id, [
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'sex' => $request->sex,
            'birthdate' => $request->birthdate,

            'address' => $request->address,
            'role' => implode(",", $request->role)
        ]);

        $this->updateStaffLog($request->firstname  . ' ' .  $request->middlename  . ' ' . $request->lastname);

        if ($request->hasFile("images")) {
            $path = $request->file('images')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);
            DB::table('users')->where('id', $staff_id)->update(
                [
                    'profile_image' => $path,
                ]
            );
        }

        if ($request->hasFile('valid_id')) {
            $path2 = $request->file('valid_id')->storePublicly('public/validID');
            $path2 = str_replace('public', 'storage', $path2);

            $pic2 = DB::update(
                'UPDATE staff SET valid_id = ? WHERE staff_id = ?',
                [$path2, $staff_id]
            );
        }

        DB::table('users')->where('id', $staff_id)->update(
            [
                'phone_number' => $this->convertToLocalFormat($request->input('phone_number')),
            ]
        );
        if ($r == 1) {
            return redirect()->route('index.staff')->with('staff_message', 'Updated Successfully');
        } else {
            return redirect()->route('index.staff');
        }
    }

    public function store(Request $request)
    {
        $code = 200;
        $message = "Added Successfully";
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $path = $request->file('images')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);
            $userId = Str::random(36);
            DB::table('users')->insertGetId(
                [
                    'id' => $userId,
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'profile_image' => $path,
                    'phone_number' => $this->convertToLocalFormat($request->input('phone_number')),
                    'type' => 4,
                ]
            );
            $path2 = $request->file('valid_id')->storePublicly('public/validID');
            $path2 = Str::replace('public', 'storage', $path2);

            $this->staffRepository->create(
                [
                    'staff_id' => $userId,
                    'school_id' => auth()->user()->schoolid,
                    'firstname' => $request->firstname,
                    'middlename' => $request->middlename,
                    'lastname' => $request->lastname,
                    'sex' => $request->sex,
                    'birthdate' => $request->birthdate,
                    'address' => $request->address,
                    'role' => implode(",", $request->role),
                    'valid_id' => $path2
                ]
            );

            $this->createStaffLog($request->firstname  . ' ' . $request->middlename  . ' ' . $request->lastname);
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function deleteStaff(Request $request)
    {
        $id = $request->input('staff_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('Select * FROM staff WHERE staff_id=?', [$id]);

        $firstname = $details[0]->firstname;
        $middlename = $details[0]->middlename;
        $lastname =  $details[0]->lastname;

        try {
            $delete = DB::delete('DELETE from users where id=?', [$id]);
            $del = DB::delete('DELETE from staff where staff_id=?', [$id]);
            $this->deleteStaffLog($firstname  . ' ' . $middlename  . ' ' . $lastname);
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return response
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }

    ///newest as in
    public function getName()
    {
        $userType = auth()->user()->type;
        $staff_id = Auth::user()->id;
        $name = '';
        if ($userType == 1) {
            $name = 'Driving School Admin';
        } else {
            $staff = DB::select('Select * FROM  staff WHERE staff_id=?', [$staff_id]);
            $name = $staff[0]->firstname . ' ' . $staff[0]->middlename . ' ' . $staff[0]->lastname;
        }

        return $name;
    }


    public function createStaffLog($name)
    {
        $this->logOperationToDatabase("Create Staff Account: $name", 1, 'Staff Management');
    }

    public function updateStaffLog($name)
    {
        $this->logOperationToDatabase("Update Staff Account: $name", 2, 'Staff Management');
    }

    public function deleteStaffLog($name)
    {
        $this->logOperationToDatabase("Delete Staff Account: $name", 3, 'Staff Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
    }
}