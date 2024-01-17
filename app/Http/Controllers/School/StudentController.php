<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public $studentRepository;
    public $orderListRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(StudentRepositoryInterface $studentRepository, OrderListRepositoryInterface $orderListRepositoryInterface)
    {
        $this->middleware('auth');
        $this->middleware('role:7');
        $this->studentRepository = $studentRepository;
        $this->orderListRepository = $orderListRepositoryInterface;
    }

    public function index()
    {
        return view('school.features.student_management.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('school.features.student_management.create');
    }
    public function retrieveAll()
    {
        return json_encode($this->studentRepository->retrieveSchoolStudent());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $code = 200;
        $message = "Added Successfully";
        try {
            $path = $request->file('image')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);


            $user = User::create(
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'type' => 3,
                    'profile_image' => $path,
                    'phone_number' => $this->convertToLocalFormat($request->phone_number),
                ]
            );
            $this->studentRepository->create([
                'student_id' => $user->id,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'sex' => $request->sex,
                'birthdate' => $request->birthdate,
                'address' => $request->address,
            ]);
            $this->studentRepository->createStudent([
                'student_id' => $user->id,
                'school_id' => auth()->user()->schoolid,
                'identity' => 2,
            ]);

            $this -> createStudentLog($request->firstname  . ' ' . $request->middlename  . ' ' . $request->lastname);

        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
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
        $s_student = $this->studentRepository->retrieveSchoolStudentFromId(
            $id,
            auth()->user()->school_id
        );
        if ($s_student == null) {
            abort(404);
        }
        $student = $this->studentRepository->getStudentWIithId($id);
        return view('school.features.student_management.view', [
            'student' => $student,
            'courses' => $this->orderListRepository->getStudentForSchoolCourses($id, auth()->user()->school_id),
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
    
    
        public function createStudentLog($name) {
            $this->logOperationToDatabase("Create Student Account: $name", 1, 'Student Management');
        }
    
        public function updateStudentLog($name) {
            $this->logOperationToDatabase("Update Student Account: $name", 2, 'Student Management');
        }
    
        public function deleteStudentLog($name) {
            $this->logOperationToDatabase("Delete Student Account: $name", 3, 'Student Management');
        }
        
        public function logOperationToDatabase($description, $operation, $management) {
            $id = Auth::user()->schoolid;
            $user_id = Auth::user()->id;
            $name = $this->getName();
        
            
           $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id,$name, $operation, $description, $management]);
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
    public function update(Request $request, $id)
    {
        //
    }

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
    public function convertToLocalFormat($phoneNumber)
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
}
