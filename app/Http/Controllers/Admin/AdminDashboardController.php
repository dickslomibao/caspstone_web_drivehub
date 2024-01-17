<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;



class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $totalschool = DB::select('SELECT COUNT(*) as total FROM schools where accreditation_status = 2')[0]->total;
        $totalstudents = DB::select('SELECT COUNT(*) as total FROM users where type = 3')[0]->total;
        $totalservices = DB::select('SELECT COUNT(*) as total FROM orders')[0]->total;
        $pending = DB::select('SELECT COUNT(*) as total FROM schools where accreditation_status = 1')[0]->total;

        $schoolData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_schools FROM schools WHERE MONTH(date_created) = ? AND YEAR(date_created) = ?', [$i, $currentYear])[0]->count_of_schools;
            $schoolData[] = $total;
        }


        $studentData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_students FROM users WHERE type = 3 AND MONTH(created_at) = ? AND YEAR(created_at) = ?', [$i, $currentYear])[0]->count_of_students;
            $studentData[] = $total;
        }


        //top school last month ()


        if ($currentMonth == 1) {
            $lastMonth = 12;
            $currentYear = ($currentYear - 1);
        } else {
            $lastMonth = ($currentMonth - 1);
        }


        $topSchool = DB::select(' SELECT 
        schools.user_id,
        schools.name, 
        schools.address, 
        users.profile_image,
        COUNT(orders.id) AS availed_service_count,
        ROUND((COUNT(CASE WHEN order_lists.status = 3 THEN 1 ELSE NULL END) / COUNT(orders.id)) * 100, 2) AS completion_rate,
        AVG(schools_review.rating) AS average_rating
    FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    LEFT JOIN orders ON schools.user_id = orders.school_id
    LEFT JOIN order_lists ON orders.id = order_lists.order_id
    LEFT JOIN schools_review ON schools.user_id = schools_review.school_id
    WHERE MONTH(orders.date_created) = ? AND YEAR(orders.date_created) = ? 
    GROUP BY schools.user_id, schools.address, schools.name, users.profile_image
    ORDER BY availed_service_count DESC
    LIMIT 5', [$lastMonth, $currentYear]);





        $reviews = DB::select('SELECT
        students.firstname,
        students.middlename,
        students.lastname,
        schools_review.*,
        courses.name,
        courses_variant.duration,
        schools.name as school_name, users.email
    FROM
        schools_review
    LEFT JOIN students ON schools_review.student_id = students.student_id
    LEFT JOIN order_lists ON schools_review.order_id = order_lists.order_id
    LEFT JOIN schools ON schools_review.school_id = schools.user_id
    LEFT JOIN courses ON order_lists.course_id = courses.id 
    LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id AND courses_variant.course_id = courses.id
    LEFT JOIN users ON schools.user_id = users.id
    ORDER BY
        schools_review.date_created
    LIMIT 5');


        $schools = DB::select('SELECT schools.*, users.profile_image, users.email, users.phone_number, schools.latitude AS school_lat, schools.longitude AS school_lng
    FROM schools
    LEFT JOIN users ON schools.user_id = users.id;
    ');



        return view('admin.index', ['pending' => $pending, 'totalschool' => $totalschool, 'totalstudents' => $totalstudents, 'totalservices' => $totalservices, 'schoolData' => $schoolData, 'studentData' => $studentData, 'topSchool' => $topSchool, 'reviews' => $reviews, 'schools' => $schools]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    public function pendingRequest()
    {

        $schools = DB::select('
        SELECT
        schools.*,
        users.profile_image,
        users.email
        FROM schools
    LEFT JOIN users ON users.id = schools.user_id
    WHERE schools.accreditation_status = 1
    GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude, schools.accreditation_status, schools.date_created, 
       schools.date_updated, users.profile_image, users.email');
        return view('admin.features.operation.pending_application', ['schools' => $schools]);
    }




    public function pendingSchoolDetails($id)
    {

        $details = $this->getSchoolDetails($id);
        // $mayor = "Mayor's Permit";


        // $datarow = "";

        // $permit = DB::select('SELECT * FROM accreditation WHERE school_id =?', [$id]);
        // if ($permit[0]->validID1 == "") {
        //     $datarow = "None";
        // }




        $status = DB::select('SELECT *  FROM schools where user_id=?', [$id]);


        $datarow = "";
        $firstValidID = DB::select('SELECT * FROM accreditation WHERE school_id =?', [$id]);
        if ($firstValidID[0]->validID1 == "") {
            $datarow = "None";
        }

        $checkvalidID2 = "";
        if ($firstValidID[0]->validID2 == "") {
            $checkvalidID2 = "None";
        }

        $checkDTI = "";
        if ($firstValidID[0]->DTI == "") {
            $checkDTI = "None";
        }


        $checkLTO = "";
        if ($firstValidID[0]->LTO == "") {
            $checkLTO = "None";
        }


        $checkcity = "";
        if ($firstValidID[0]->city_permit == "") {
            $checkcity = "None";
        }


        $checkBFP = "";
        if ($firstValidID[0]->BFP == "") {
            $checkBFP = "None";
        }

        $identification = DB::select('SELECT * FROM identification_card');

        return view('admin.features.operation.pending_requirements', ['details' => $details, 'status' => $status[0], 'datarow' => $datarow, 'firstValidID' => $firstValidID, 'checkvalidID2' => $checkvalidID2,  'checkDTI' => $checkDTI, 'checkLTO' => $checkLTO, 'checkcity' => $checkcity, 'checkBFP' => $checkBFP, 'schoolID' => $id, 'identification' => $identification]);


        //return view('admin.features.operation.pending_requirements', ['mayor' => $mayor, 'details' => $details, 'datarow' => $datarow, 'permit' => $permit]);
    }



    public function getSchoolDetails($id)
    {
        $details = DB::select('SELECT schools.*, 
            users.profile_image,
            users.email
            FROM schools
            LEFT JOIN users ON users.id = schools.user_id
            WHERE users.id = ? 
            GROUP BY schools.user_id, schools.id, schools.name, schools.address, schools.latitude, schools.longitude, schools.accreditation_status, schools.date_created, 
            schools.date_updated, users.profile_image, users.email', [$id]);

        return $details[0];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approveAccreditation(Request $request)
    {
        $schoolID = $request->input('schoolID');

        $code = 200;
        $message = "Approved Successfully";
        try {
            $update = DB::update('UPDATE schools SET accreditation_status= ? WHERE user_id = ?', [2, $schoolID]);
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
    public function retreiveAdmin()
    {
        $admins = DB::select('SELECT admin.*, users.email, users.profile_image FROM admin LEFT JOIN users ON admin.admin_id = users.id');
        return view('admin.features.admin_management.index', ['admins' => $admins]);
    }


    public function createAdmin()
    {
        return view('admin.features.admin_management.create');
    }


    public function storeAdmin(Request $request)
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
                    'type' => 5,
                ]
            );

            $insert = DB::insert(
                'insert into admin (admin_id, firstname, middlename, lastname, 
            sex, birthdate, phone_number,address ) values (?, ?, ?, ?, ?, ?, ?, ?)',
                [
                    $userId, $request->firstname, $request->middlename,
                    $request->lastname, $request->sex, $request->birthdate, $request->phone_number, $request->address
                ]
            );

            $this->createAdminLog($request->firstname . ' ' . $request->middlename . ' ' . $request->lastname);
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function updateAdmin($admin_id)
    {

        $admin = DB::select('SELECT  * FROM admin WHERE admin_id = ?', [$admin_id]);

        if ($admin == null) {
            abort(404);
        }
        return view('admin.features.admin_management.update', ['admin' => $admin[0]]);
    }


    public function saveUpdateAdmin(Request $request)
    {

        $admin_id = $request->input('admin_id');
        $code = 200;
        $message = "Added Successfully";
        try {
            $update = DB::update(
                'UPDATE admin SET firstname = ?, middlename = ?, lastname = ?, 
        sex = ?, birthdate = ?, phone_number = ?, address = ? WHERE admin_id = ?',
                [
                    $request->firstname, $request->middlename,
                    $request->lastname, $request->sex, $request->birthdate, $request->phone_number, $request->address, $admin_id
                ]
            );

            if ($request->hasFile("images")) {
                $path = $request->file('images')->storePublicly('public/profile');
                $path = Str::replace('public', 'storage', $path);
                DB::table('users')->where('id', $admin_id)->update(
                    [
                        'profile_image' => $path,
                    ]
                );
            }
            $this->updateAdminLog($request->firstname . ' ' . $request->middlename . ' ' . $request->lastname);
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function deleteAdmin(Request $request)
    {
        $id = $request->input('admin_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('Select * FROM admin where admin_id = ?', [$id]);
        $firstname = $details[0]->firstname;
        $middlename = $details[0]->middlename;
        $lastname =  $details[0]->lastname;

        try {
            $delete = DB::delete('DELETE from users where id=?', [$id]);
            $del = DB::delete('DELETE from admin where admin_id=?', [$id]);
            $this->deleteAdminLog($firstname . ' ' . $middlename . ' ' . $lastname);
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

        $admin_id = Auth::user()->id;
        $name = '';

        $admin = DB::select('Select * FROM admin WHERE admin_id=?', [$admin_id]);
        $name = $admin[0]->firstname . ' ' . $admin[0]->middlename . ' ' . $admin[0]->lastname;

        return $name;
    }


    public function createAdminLog($name)
    {
        $this->logOperationToDatabase("Create Admin Account: $name", 1, 'Admin Management');
    }

    public function updateAdminLog($name)
    {
        $this->logOperationToDatabase("Update Admin Account: $name", 2, 'Admin Management');
    }

    public function deleteAdminLog($name)
    {
        $this->logOperationToDatabase("Delete Admin Account: $name", 3, 'Admin Management');
    }


    public function logOperationToDatabase($description, $operation, $management)
    {

        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into admin_logs (user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?)', [$user_id, $name, $operation, $description, $management]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


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
