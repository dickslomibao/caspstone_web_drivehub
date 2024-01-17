<?php

namespace App\Http\Controllers\School;

use App\Classes\Account;
use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\ReviewRepository;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SchoolFileHelper;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InstructorImport;
use App\Models\User;

class InstructorController extends Controller
{



    private $instructorRepository;
    public $reviewRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepository, ReviewRepositoryInterface $reviewRepositoryInterface,)
    {
        $this->middleware('auth');
        $this->middleware('role:1');
        $this->instructorRepository = $instructorRepository;
        $this->reviewRepository = $reviewRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view(SchoolFileHelper::$instructor . 'index');
    }

    public function import(Request $request)
    {

        Excel::import(new InstructorImport, $request->file('file'), 'xlsx');

        return redirect()->back();
    }

    public function promote($instructor_id)
    {
        $instructor = $this->instructorRepository->getInstructorDataUsingId($instructor_id, auth()->user()->schoolid);
        if ($instructor == null) {
            abort(404);
        }
        if (DB::table('staff')->where('staff_id', $instructor->user_id)->exists()) {
            DB::table('staff')->where('staff_id', $instructor->user_id)->update([
                'school_id' => $instructor->school_id,
                'firstname' =>  $instructor->firstname,
                'middlename' =>  $instructor->middlename,
                'lastname' =>  $instructor->lastname,
                'sex' =>  $instructor->sex,
                'birthdate' =>  $instructor->birthdate,
                'address' =>  $instructor->address,
                'status' => 1,
            ]);
        } else {
            DB::table('staff')->insert([
                [
                    'staff_id' =>  $instructor->user_id,
                    'school_id' => $instructor->school_id,
                    'firstname' =>  $instructor->firstname,
                    'middlename' =>  $instructor->middlename,
                    'lastname' =>  $instructor->lastname,
                    'sex' =>  $instructor->sex,
                    'birthdate' =>  $instructor->birthdate,
                    'address' =>  $instructor->address,
                    'status' => 1,
                    'role' => '',
                ]
            ]);
        }

        DB::table('instructors')->where('user_id', $instructor->user_id)->update(['status' => 3]);

        $u =  User::findOrFail($instructor->user_id);
        $u->type = 4;
        $u->save();

        return redirect()->back();
    }
    public function create()
    {
        return view('school.features.instructor_management.create');
    }
    public function retrieveSchoolInstructors()
    {
        return json_encode($this->instructorRepository->getSchoolInstructor(auth()->user()->schoolid));
    }


    public function updateInstructor($id)
    {

        $details = DB::select('Select instructors.*, users.profile_image, users.phone_number FROM instructors
        INNER JOIN users ON users.id = instructors.user_id  WHERE user_id=?', [$id]);
        return view('school.features.instructor_management.update', ['details' => $details[0]]);
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

    public function update(Request $request)
    {
        $id = $request->input('user_id');
        $code = 200;
        $message = "Update Successfully";

        try {

            $firstname = $request->input('firstname');
            $middlename = $request->input('middlename');
            $lastname = $request->input('lastname');
            $sex = $request->input('sex');
            $birthdate = $request->input('birthdate');
            $phone_number = $this->convertToLocalFormat($request->input('phone_number'));
            $address = $request->input('address');


            if ($request->hasFile('image')) {
                $path = $request->file('image')->storePublicly('public/profile');
                $path = str_replace('public', 'storage', $path);

                $pic = DB::update(
                    'UPDATE users SET profile_image = ? WHERE id = ?',
                    [$path, $id]
                );
            }

            if ($request->hasFile('valid_id')) {
                $path2 = $request->file('valid_id')->storePublicly('public/validID');
                $path2 = str_replace('public', 'storage', $path2);

                $pic2 = DB::update(
                    'UPDATE instructors SET valid_id = ? WHERE user_id = ?',
                    [$path2, $id]
                );
            }

            if ($request->hasFile('license')) {
                $path3 = $request->file('license')->storePublicly('public/license');
                $path3 = str_replace('public', 'storage', $path3);

                $pic3 = DB::update(
                    'UPDATE instructors SET license = ? WHERE user_id = ?',
                    [$path3, $id]
                );
            }

            DB::update(
                'UPDATE users SET phone_number = ? WHERE id = ?',
                [$phone_number, $id]
            );
            $instructorupdate = DB::update(
                'UPDATE instructors SET firstname = ?, middlename = ?, lastname = ?, sex = ?, birthdate = ?, address = ? WHERE user_id = ?',
                [$firstname, $middlename, $lastname, $sex, $birthdate, $address, $id]
            );

            $this->updateInstructorLog($firstname  . ' ' . $middlename  . ' ' . $lastname);
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        // Return only necessary instructor data
        return response()->json([
            'code' => $code,
            'message' => $message,

        ]);
    }

    public function moreDetailsInstructor($id)
    {

        $details = DB::select('Select instructors.*, users.profile_image, users.email, users.phone_number FROM instructors
        LEFT JOIN users ON users.id = instructors.user_id  WHERE user_id=?', [$id]);

        $Theodatarowcount = "";
        $Theoschedule = DB::select('SELECT DISTINCT schedules.*, theoritical_schedules.title, theoritical_schedules.slot, theoritical_schedules.for_session_number 
        FROM schedules 
        LEFT JOIN theoritical_schedules ON theoritical_schedules.schedule_id = schedules.id 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        WHERE schedules.type = ? AND schedule_instructors.instructor_id = ? ORDER BY schedules.start_date', [2, $id]);

        if (count($Theoschedule) <= 0) {
            $Theodatarowcount = "None";
        }

        $Theoincomingcount = "";
        $TheoschedIcoming = DB::select('SELECT DISTINCT schedules.*, theoritical_schedules.title, theoritical_schedules.slot, theoritical_schedules.for_session_number 
        FROM schedules 
        LEFT JOIN theoritical_schedules ON theoritical_schedules.schedule_id = schedules.id 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        WHERE schedules.type = ? AND schedules.status = ? AND schedule_instructors.instructor_id = ? ORDER BY schedules.start_date', [2, 1, $id]);
        if (count($TheoschedIcoming) <= 0) {
            $Theoincomingcount = "None";
        }

        $Theocompcount = "";
        $TheoschedComp = DB::select('SELECT DISTINCT schedules.*, theoritical_schedules.title, theoritical_schedules.slot, theoritical_schedules.for_session_number 
        FROM schedules 
        LEFT JOIN theoritical_schedules ON theoritical_schedules.schedule_id = schedules.id 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        WHERE schedules.type = ?  AND schedules.status = ? AND schedule_instructors.instructor_id = ? ORDER BY schedules.start_date', [2, 3, $id]);
        if (count($TheoschedComp) <= 0) {
            $Theocompcount = "None";
        }

        $pracCount = "";
        $practical = DB::select('SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
		LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =? and schedule_instructors.instructor_id =?', [1, $id]);
        if (count($practical) <= 0) {
            $pracCount = "None";
        }

        $pracIncomingCount = "";
        $practIncoming = DB::select('SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
		LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =? AND schedules.status = ? AND schedule_instructors.instructor_id =?', [1, 1, $id]);
        if (count($practIncoming) <= 0) {
            $pracIncomingCount = "None";
        }

        $pracCompCount = "";
        $practCompleted = DB::select('SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
		LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =? AND schedules.status = ? AND schedule_instructors.instructor_id =?', [1, 3, $id]);
        if (count($practCompleted) <= 0) {
            $pracCompCount = "None";
        }


        return view('school.features.instructor_management.moreDetails', ['details' => $details[0], 'schedule' => $Theoschedule, 'instructor_id' => $id, 'Theodatarowcount' => $Theodatarowcount, 'Theoincomingcount' => $Theoincomingcount, 'TheoschedIcoming' => $TheoschedIcoming, 'Theocompcount' => $Theocompcount, 'TheoschedComp' => $TheoschedComp, 'practical' => $practical, 'pracCount' => $pracCount, 'pracIncomingCount' => $pracIncomingCount, 'practIncoming' => $practIncoming, 'pracCompCount' => $pracCompCount, 'practCompleted' => $practCompleted]);
    }


    public function store(Request $request)
    {

        $path = $request->file('image')->storePublicly('public/profile');
        $path = Str::replace('public', 'storage', $path);


        $path2 = $request->file('valid_id')->storePublicly('public/validID');
        $path2 = Str::replace('public', 'storage', $path2);

        $path3 = $request->file('license')->storePublicly('public/license');
        $path3 = Str::replace('public', 'storage', $path3);


        $userId = Str::random(36);
        DB::table('users')->insertGetId(
            [
                'id' => $userId,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $this->convertToLocalFormat($request->input('phone_number')),
                'profile_image' => $path,
                'type' => 2,
            ]
        );
        $instructor = $this->instructorRepository->create(
            [
                'user_id' => $userId,
                'school_id' => auth()->user()->id,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'sex' => $request->sex,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
                'valid_id' => $path2,
                'license' => $path3,
            ]
        );

        $this->createInstructorLog($request->firstname  . ' ' . $request->middlename  . ' ' . $request->lastname);
        return redirect()->route('index.instructor')->with('message', 'Added Successfully');
        // $message = "Added Successfully";
        // $instructor = null;
        // try {

        //     $path = $request->file('image')->storePublicly('public/profile');
        //     $path = Str::replace('public', 'storage', $path);
        //     $userId = Str::random(36);
        //     DB::table('users')->insertGetId(
        //         [
        //             'id' => $userId,
        //             'username' => $request->username,
        //             'email' => $request->email,
        //             'password' => Hash::make($request->password),
        //             'phone_number' => $this->convertToLocalFormat($request->input('phone_number')),
        //             'profile_image' => $path,
        //             'type' => 2,
        //         ]
        //     );
        //     $instructor = $this->instructorRepository->create(
        //         [
        //             'user_id' => $userId,
        //             'school_id' => auth()->user()->id,
        //             'firstname' => $request->firstname,
        //             'middlename' => $request->middlename,
        //             'lastname' => $request->lastname,
        //             'sex' => $request->sex,
        //             'birthdate' => $request->birthdate,

        //             'address' => $request->address,
        //         ]
        //     );
        // } catch (Exception $th) {
        //     $code = 500;
        //     $message = $th->getMessage();
        // }
        // return response()->json([
        //     'code' => $code,
        //     'message' => $message,
        //     'instructor' => $this->instructorRepository->getInstructorDataUsingId($instructor, auth()->user()->schoolid)
        // ]);
    }

    public function deleteInstructor(Request $request)
    {
        $id = $request->input('instructor_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('Select instructors.*, users.profile_image, users.phone_number FROM instructors
        INNER JOIN users ON users.id = instructors.user_id  WHERE user_id=?', [$id]);

        $firstname = $details[0]->firstname;
        $middlename = $details[0]->middlename;
        $lastname =  $details[0]->lastname;



        try {
            if (DB::table('schedule_instructors')->where('instructor_id', $id)->exists()) {
                throw new Exception('Cannot delete already have operation', 505);
            }
            $delete = DB::delete('DELETE from users where id=?', [$id]);
            $del = DB::delete('DELETE from instructors where id=?', [$id]);


            $this->deleteInstructorLog($firstname  . ' ' . $middlename  . ' ' . $lastname);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function getInstructorScheduleUsingId(Request $request)
    {

        return response()->json(
            $this->instructorRepository->getInstructorScheduleUsingId($request->id, auth()->user()->schoolid),
        );
    }

    public function checkInstructorConflictSchedule(Request $request)
    {
        return response()->json(count($this->instructorRepository->checkInstructorConflictSchedule($request->id, $request->session_id, $request->start_date, $request->end_date)));
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


    public function createInstructorLog($name)
    {
        $this->logOperationToDatabase("Create Instructor Account: $name", 1, 'Instructor Management');
    }

    public function updateInstructorLog($name)
    {
        $this->logOperationToDatabase("Update Instructor Account: $name", 2, 'Instructor Management');
    }

    public function deleteInstructorLog($name)
    {
        $this->logOperationToDatabase("Delete Instructor Account: $name", 3, 'Instructor Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
