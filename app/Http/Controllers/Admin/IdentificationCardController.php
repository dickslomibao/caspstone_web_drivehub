<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class IdentificationCardController extends Controller
{
    public function index()
    {
        return view('admin.features.driving_school_management.identification_card_management.index');
    }

    public function retrieveAll()
    {

        $identification = DB::select('SELECT * FROM identification_card');

        return json_encode($identification);
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
        $message = "Added Succcessfully";
        $id = null;
        try {
            $request->validate([
                'title' => 'required'
            ]);

            $insert = DB::insert('insert into identification_card (title) values (?)', [$request->title]);
            $this-> createIdentificationLog($request->title);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function updateTerms(Request $request, $id)
    {
        $code = 200;
        $message = "Updated Succcessfully";

        try {
            $request->validate([
                'title' => 'required',
            ]);

            $termsupdate = DB::update(
                'UPDATE identification_card SET title= ? WHERE id = ?',
                [$request->title, $id]
            );
            $this-> updateIdentificationLog($request->title);

        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }


    public function deleteTerms(Request $request)
    {
        $id = $request->input('id');
        $message = "Delete Successfully";
        $code = 200;
        $details = DB::select('SELECT * from identification_card where id=?', [$id]);
        $title = $details[0]->title;


        try {
            $delete = DB::delete('DELETE from identification_card where id=?', [$id]);
            $this-> deleteIdentificationLog($title);
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


    public function createIdentificationLog($name)
    {
        $this->logOperationToDatabase("Create Identification Card: $name", 1, 'Identification Card Management');
    }

    public function updateIdentificationLog($name)
    {
        $this->logOperationToDatabase("Update Identification Card: $name", 2, 'Identification Card Management');
    }

    public function deleteIdentificationLog($name)
    {
        $this->logOperationToDatabase("Delete Identification Card: $name", 3, 'Identification Card Management');
    }


    public function logOperationToDatabase($description, $operation, $management)
    {

        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into admin_logs (user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?)', [$user_id, $name, $operation, $description, $management]);
    }
}
