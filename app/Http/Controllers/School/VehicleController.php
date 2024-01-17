<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\StudentRepositoryInterface;

use App\Repositories\Interfaces\ScheduleInstructorRepositoryInterface;
use App\Repositories\Interfaces\ScheduleStudentsRepositoryInterface;

class VehicleController extends Controller
{
    private $vehicleRepository;
    public $instructorReportRepository;
    public $studentRepository;
    public $instructorRepository;
    public $scheduleInstructorRepositoryInterface;
    public $scheduleStudentsRepositoryInterface;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository,

        InstructorReportRepositoryInterface $instructorReportRepositoryInterface,
        StudentRepositoryInterface $studentRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
        ScheduleInstructorRepositoryInterface $scheduleInstructorRepositoryInterface,
        ScheduleStudentsRepositoryInterface $scheduleStudentsRepositoryInterface,
    ) {
        $this->middleware('auth');
        $this->middleware('role:2');
        $this->vehicleRepository = $vehicleRepository;

        $this->instructorReportRepository = $instructorReportRepositoryInterface;
        $this->studentRepository = $studentRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->scheduleInstructorRepositoryInterface = $scheduleInstructorRepositoryInterface;
        $this->scheduleStudentsRepositoryInterface = $scheduleStudentsRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        return view('school.features.vehicle_management.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $id = null;
        try {
            $request->validate([
                'name' => 'required',
                'type' => "required",
                'plate' => "required|unique:vehicles,plate_number",
                'manufacturer' => "required",
                'model' => "required",
                'year' => "required",
                'transmission' => "required",
                'fuel' => "required",
                'color' => "required",
                'images' => "required",
            ]);
            $id = Str::random(10);
            $path = $request->file('images')->storePublicly('public/vehicles');
            $path = Str::replace('public', 'storage', $path);
            $this->vehicleRepository->create(
                [
                    'name' => $request->input('name'),
                    'id' => $id,
                    'school_id' => auth()->user()->id,
                    'type' => $request->input('type'),
                    'plate_number' => $request->input('plate'),
                    'manufacturer' => $request->input('manufacturer'),
                    'model' => $request->input('model'),
                    'year' => $request->input('year'),
                    'transmission' => $request->input('transmission'),
                    'fuel' => $request->input('fuel'),
                    'color' => $request->input('color'),
                    'vehicle_img' => $path,
                ]
            );

            $this->createVehicleLog($request->input('name'), $request->input('plate'));
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }

        return response()->json([
            'code' => $code,
            'message' => $message,
            'vehicle' => $this->vehicleRepository->retrieveFromId($id),
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uniquePlateNumber(Request $request)
    {
        return response()->json($this->vehicleRepository->uniquePlateNumber($request->data, $request->operation, $request->id));
    }
    public function retrieveAll()
    {
        return json_encode($this->vehicleRepository->retrieveAll(auth()->user()->schoolid));
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
        $code = 200;
        $message = "Update Successfully";
        $path = $request->file('images')->storePublicly('public/vehicles');
        $path = Str::replace('public', 'storage', $path);
        try {
            $this->vehicleRepository->update(
                $id,
                [
                    'name' => $request->input('name'),
                    'type' => $request->input('type'),
                    'plate_number' => $request->input('plate'),
                    'manufacturer' => $request->input('manufacturer'),
                    'model' => $request->input('model'),
                    'year' => $request->input('year'),
                    'transmission' => $request->input('transmission'),
                    'fuel' => $request->input('fuel'),
                    'color' => $request->input('color'),
                    'vehicle_img' => $path,
                ]
            );

            $this->updateVehicleLog($request->input('name'), $request->input('plate'));
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'vehicle' => $this->vehicleRepository->retrieveFromId($id),
        ]);
    }



    public function deleteVehicle(Request $request)
    {
        $id = $request->input('vehicle_id');
        $message = "Delete Successfully";

        $vehicle = DB::select('SELECT * FROM schedule_vehicles WHERE vehicle_id =?', [$id]);
        if (count($vehicle) >= 1) {
            $code = 500;
        } else {

            $details = DB::select('SELECT * FROM vehicles WHERE id=?', [$id]);
            $name = $details[0]->name;
            $plate = $details[0]->plate_number;
            $this->deleteVehicleLog($name, $plate);


            $delete = DB::delete('DELETE from vehicles where id=?', [$id]);
            $code = 200;
        }

        return response()->json([
            'code' => $code,
            'message' => $message,

        ]);
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

    public function viewVehicle($id)
    {
        $vehicle = DB::select('SELECT * FROM vehicles WHERE id = ?', [$id]);

        $all = DB::select('SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
		LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =? and schedule_vehicles.vehicle_id = ?', [1, $id]);



        $incoming = DB::select(
            'SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
        LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =? AND schedules.status = ? AND  schedule_vehicles.vehicle_id = ?',
            [1, 1, $id]
        );


        $completed = DB::select(
            'SELECT schedules.*, schedule_students.student_id, students.firstname, students.middlename, students.lastname, courses.name, vehicles.name AS vehicle_name, vehicles.plate_number
        FROM schedules 
        LEFT JOIN schedule_instructors ON schedules.id = schedule_instructors.schedule_id 
        LEFT JOIN schedule_students ON schedules.id = schedule_students.schedule_id 
        LEFT JOIN schedule_vehicles ON schedules.id = schedule_vehicles.schedule_id
        LEFT JOIN students ON schedule_students.student_id = students.student_id 
        LEFT JOIN vehicles ON schedule_vehicles.vehicle_id = vehicles.id
        LEFT JOIN order_lists ON schedule_students.order_list_id = order_lists.id
        LEFT JOIN courses ON courses.id = order_lists.course_id
        WHERE schedules.type =?   AND schedules.status = ? AND schedule_vehicles.vehicle_id = ?',
            [1, 3, $id]
        );


        return view('school.features.vehicle_management.view', ['vehicle' => $vehicle[0], 'all' => $all, 'incoming' => $incoming, 'completed' => $completed, 'vehicle_id' => $id]);
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


    public function createVehicleLog($name, $platenumber)
    {
        $this->logOperationToDatabase("Create Vehicle: $name - $platenumber", 1, 'Vehicle Management');
    }

    public function updateVehicleLog($name, $platenumber)
    {
        $this->logOperationToDatabase("Update Vehicle: $name - $platenumber", 2, 'Vehicle Management');
    }

    public function deleteVehicleLog($name, $platenumber)
    {
        $this->logOperationToDatabase("Delete Vehicle: $name - $platenumber", 3, 'Vehicle Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
    }


    ///revision 
    public function viewVehicleReport($vehicle_id, $name)
    {
        return view('school.features.vehicle_management.report', ['vehicle_id' => $vehicle_id, 'vehicle_name' => $name]);
    }

    public function retrieveVehicleReport($id)
    {
        $ids = DB::table('schedule_vehicles')->where('vehicle_id', $id)->pluck('schedule_id')->toArray();
        $data = array();
        foreach (DB::table('schedule_report')->whereIn('schedule_id', $ids)->get() as $value) {
            $value->instructor = $this->scheduleInstructorRepositoryInterface->getSchedulesInstructor($value->schedule_id)[0];
            // $value->student = $this->studentRepository->getSchedulesInstructor($ids-);
            array_push($data, $value);
        }
        return response()->json($data);
    }


    public function viewVehicleReportDetails($id)
    {

        $value = DB::table('schedule_report')->where('id', $id)->first();

        $value->instructor = $this->scheduleInstructorRepositoryInterface->getSchedulesInstructor($value->schedule_id)[0];
        $value->student = $this->scheduleStudentsRepositoryInterface->getScheduleStudents($value->schedule_id)[0];
        $value->images = DB::table('schedule_report_image')->where('schedule_report_id', $id)->get();

        return view('school.features.vehicle_management.report_details', [
            'report' => $value,
        ]);
    }
}
