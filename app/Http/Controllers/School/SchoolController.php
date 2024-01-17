<?php

namespace App\Http\Controllers\School;

use App\Classes\Account;
use App\Http\Controllers\Controller;

use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Carbon\Carbon;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $reviewRepository;
    public $instructorRepository;
    public function __construct(
        ReviewRepositoryInterface $reviewRepositoryInterface,
        InstructorRepositoryInterface $instructorRepositoryInterface,
    ) {
        $this->reviewRepository = $reviewRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
    }
    public function index()
    {
       





        $id = Auth::user()->schoolid;
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;


        // if ($currentMonth == 1) {
        //     $lastMonth = 12;
        //     $currentYear = ($currentYear - 1);
        // } else {
        //     $lastMonth = ($currentMonth - 1);
        // }
        $totalstudents = DB::select('SELECT COUNT(DISTINCT student_id) AS total FROM school_students WHERE school_id = ?', [$id])[0]->total;
        $totalcourses = DB::select('SELECT COUNT(*) as total FROM courses where school_id = ?', [$id])[0]->total;
        $totalvehicles = DB::select('SELECT COUNT(*) as total FROM vehicles where school_id = ?', [$id])[0]->total;
        $totalservices = DB::select('SELECT COUNT(*) as total FROM orders where school_id = ? AND status = 5', [$id])[0]->total;
        $totalrevenue = DB::select('SELECT SUM(total_amount) as total FROM orders where school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) =? AND status = 5 ', [$id, $currentMonth, $currentYear])[0]->total ?? 0;
        $totalpending = DB::select('SELECT COUNT(*) as total FROM orders where school_id = ? AND status = 1', [$id])[0]->total;

        //$totalrevenue = DB::select('SELECT SUM(amount) as total FROM cash_payment where school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) =? ', [$id, $lastMonth, $currentYear])[0]->total ?? 0;


        $studentData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(DISTINCT student_id) AS count_of_students FROM school_students WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->count_of_students;
            $studentData[] = $total;
        }
        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_orders FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?  AND status = ?', [$id, $i, $currentYear, 5])[0]->count_of_orders;
            $orderData[] = $total;
        }

        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT SUM(total_amount) as total_revenue FROM orders where status = 5 and school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->total_revenue ?? 0;
            $revenueData[] = $total;
        }


        $reviews = DB::select('SELECT
        students.firstname, students.middlename, students.lastname, schools_review.*,
        courses.name, courses_variant.duration
    FROM
        schools_review
    LEFT JOIN students ON schools_review.student_id = students.student_id
    LEFT JOIN order_lists ON schools_review.order_id = order_lists.order_id
    LEFT JOIN courses ON order_lists.course_id = courses.id 
    LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id AND courses_variant.course_id = courses.id
    WHERE
        schools_review.school_id = ?
    ORDER BY
        schools_review.date_created desc
    LIMIT 5
        ', [$id]);


        return view('school.index', ['totalstudents' => $totalstudents, 'totalcourses' => $totalcourses, 'totalvehicles' => $totalvehicles, 'totalservices' => $totalservices, 'totalrevenue' => $totalrevenue, 'studentData' => $studentData, 'orderData' => $orderData, 'revenueData' => $revenueData, 'totalpending' => $totalpending, 'reviews' => $this->reviewRepository->getSchoolReview(auth()->user()->schoolid)]);
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
        $user = null;
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'name' => ['required', 'max:255'],
                'address' => ['required', 'max:255'],
                'latitude' => ['required'],
                'longitude' => ['required']
            ]);
            $path = $request->file('image')->storePublicly('public/profile');
            $path = Str::replace('public', 'storage', $path);
            $user = Account::createAccount(
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'profile_image' => $path,
                ]
            );

            $lastInsertedId = $user->id;

            DB::table('schools')->insertGetId([
                'user_id' => $user->id,
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            $blank = "";
            $insert = DB::insert('insert into accreditation (school_id, validID1, validID2, DTI, LTO, city_permit, BFP) values (?, ?, ?, ?, ?, ?, ?)', [$lastInsertedId, $blank, $blank, $blank, $blank, $blank, $blank]);

            ///revision
            $open_hours = DB::insert('insert into school_openhours (school_id) values (?)', [$lastInsertedId]);

            event(new Registered($user));
            Auth::login($user);
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function filterStudentGrowthPage()
    {

        $id = Auth::user()->schoolid;
        $currentYear = Carbon::now()->year;


        $studentData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(DISTINCT student_id) AS count_of_students FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->count_of_students;
            $studentData[] = $total;
        }


        return view('school.features.filter.student_growth_page', ['studentData' => $studentData]);
    }



    public function filterStudentGrowthGraph(Request $request)
    {

        $year = $request->input('year');
        $id = Auth::user()->schoolid;

        $studentData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(DISTINCT student_id) AS count_of_orders FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $year])[0]->count_of_orders;
            $studentData[] = $total;
        }


        return view('school.features.filter.filter_student_growth_graph', ['studentData' => $studentData, 'year' => $year]);
    }


    public function filterOrderGrowthPage()
    {

        $id = Auth::user()->schoolid;
        $currentYear = Carbon::now()->year;


        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_order FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ? AND status=?', [$id, $i, $currentYear, 2])[0]->count_of_order;
            $orderData[] = $total;
        }

        return view('school.features.filter.order_growth_page', ['orderData' => $orderData]);
    }









    public function filterOrderGrowthGraph(Request $request)
    {

        $year = $request->input('year');
        $id = Auth::user()->schoolid;


        $orderData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT COUNT(*) AS count_of_students FROM orders WHERE school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ? AND status = ?', [$id, $i, $year, 2])[0]->count_of_students;
            $orderData[] = $total;
        }

        return view('school.features.filter.filter_order_growth_graph', ['orderData' => $orderData, 'year' => $year]);
    }



    public function filterRevenueGrowthPage()
    {

        $id = Auth::user()->schoolid;
        $currentYear = Carbon::now()->year;


        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT SUM(total_amount) as total_revenue FROM orders where status = 5 and school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $currentYear])[0]->total_revenue ?? 0;
            $revenueData[] = $total;
        }

        return view('school.features.filter.revenue_growth_page', ['revenueData' => $revenueData,]);
    }



    public function filterRevenueGrowthGraph(Request $request)
    {

        $year = $request->input('year');
        $id = Auth::user()->schoolid;


        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = DB::select('SELECT SUM(total_amount) as total_revenue FROM orders where school_id = ? AND MONTH(date_created) = ? AND YEAR(date_created) = ?', [$id, $i, $year])[0]->total_revenue ?? 0;
            $revenueData[] = $total;
        }

        return view('school.features.filter.filter_revenue_growth_graph', ['revenueData' => $revenueData, 'year' => $year]);
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

    public function schoolAccreditation()
    {

        $id = Auth::user()->schoolid;

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
        return view('school.features.accreditation_management.index', ['status' => $status[0], 'datarow' => $datarow, 'firstValidID' => $firstValidID, 'checkvalidID2' => $checkvalidID2, 'checkDTI' => $checkDTI, 'checkLTO' => $checkLTO, 'checkcity' => $checkcity, 'checkBFP' => $checkBFP, 'identification' => $identification]);
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
    public function storeSchoolAccreditationValidID(Request $request)
    {

        $id = Auth::user()->schoolid;

        $code = 200;
        $message = "Added Successfully";
        $user = null;
        try {

            $path = $request->file('pdfFile')->storePublicly('public/accreditation');
            $path = str_replace('public', 'storage', $path);

            $type = $request->input('acceptable');
            $idColumn = $request->input('idColumn');


            $ValidID = DB::select('SELECT * FROM accreditation WHERE school_id =?', [$id]);
            if ($ValidID[0]->ID1_type != $ValidID[0]->ID1_type) {
            }

            if ($idColumn == "validID1") {
                // if ($type == $ValidID[0]->ID2_type) {

                //     return response()->json(['code' => 222]);
                // }
                $termsupdate = DB::update('UPDATE accreditation SET validID1= ?, ID1_type = ? WHERE school_id = ?', [$path, $type, $id]);
            } else {
                // if ($type == $ValidID[0]->ID1_type) {

                //     return response()->json(['code' => 222]);
                // }
                $termsupdate = DB::update('UPDATE accreditation SET validID2= ? , ID2_type = ?  WHERE school_id = ?', [$path, $type, $id]);
            }
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
    public function storeSchoolAccreditationBusiness(Request $request)
    {
        $code = 200;

        $id = Auth::user()->schoolid;
        if($request->input('business_column_update') == "Update"){
        $code = 201;
        }
       
        $message = "Added Successfully";

        try {

            $path = $request->file('pdfFile_business')->storePublicly('public/accreditation');
            $path = str_replace('public', 'storage', $path);
            $Column = $request->input('business_column');
            // $V = DB::select('SELECT * FROM accreditation WHERE school_id =?', [$id]);
            // if ($ValidID[0]->ID1_type != $ValidID[0]->ID1_type) {
            // }
            if ($Column == "DTI") {
                $update = DB::update('UPDATE accreditation SET DTI= ? WHERE school_id = ?', [$path, $id]);
            } else if ($Column == "LTO") {
                $update = DB::update('UPDATE accreditation SET LTO= ? WHERE school_id = ?', [$path, $id]);
            } else if ($Column == "city_permit") {
                $update = DB::update('UPDATE accreditation SET city_permit= ? WHERE school_id = ?', [$path, $id]);
            } else if ($Column == "BFP") {
                $update = DB::update('UPDATE accreditation SET BFP= ? WHERE school_id = ?', [$path, $id]);
            }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function schoolAccreditationPage()
    {

        $id = Auth::user()->schoolid;

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

        return view('school.features.accreditation_management.page', ['status' => $status[0], 'datarow' => $datarow, 'firstValidID' => $firstValidID, 'checkvalidID2' => $checkvalidID2, 'checkDTI' => $checkDTI, 'checkLTO' => $checkLTO, 'checkcity' => $checkcity, 'checkBFP' => $checkBFP]);
    }

    public function schoolRatings()
    {
        $id = Auth::user()->schoolid;

        $reviews = DB::select('SELECT
        students.firstname, students.middlename, students.lastname, schools_review.*,
        courses.name, courses_variant.duration
    FROM
        schools_review
    LEFT JOIN students ON schools_review.student_id = students.student_id
    LEFT JOIN order_lists ON schools_review.order_id = order_lists.order_id
    LEFT JOIN courses ON order_lists.course_id = courses.id 
    LEFT JOIN courses_variant ON order_lists.variant_id = courses_variant.id AND courses_variant.course_id = courses.id
    WHERE
        schools_review.school_id = ?
    ORDER BY
        schools_review.date_created desc
        ', [$id]);

        return view('school.features.reviews.index', ['reviews' => $reviews]);
    }




    ///newest as in

    public function updateSchoolAccreditationValidID(Request $request)
    {

        $id = Auth::user()->schoolid;

        $code = 200;
        $message = "Updated Successfully";
        $user = null;
        try {

            $path = $request->file('pdfFile_update')->storePublicly('public/accreditation');
            $path = str_replace('public', 'storage', $path);

            $type = $request->input('acceptable_update');
            $idColumn = $request->input('idColumn_update');


            $ValidID = DB::select('SELECT * FROM accreditation WHERE school_id =?', [$id]);
            if ($ValidID[0]->ID1_type != $ValidID[0]->ID1_type) {
            }

            if ($idColumn == "validID1") {
                $termsupdate = DB::update('UPDATE accreditation SET validID1= ?, ID1_type = ? WHERE school_id = ?', [$path, $type, $id]);
            } else {
                $termsupdate = DB::update('UPDATE accreditation SET validID2= ? , ID2_type = ?  WHERE school_id = ?', [$path, $type, $id]);
            }
        } catch (Exception $th) {
            $code = 500;
            $message = $th->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }

}
