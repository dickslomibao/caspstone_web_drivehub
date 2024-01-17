<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.features.driving_school_management.terms_management.index');
    }

    public function retrieveAll()
    {

        $terms = DB::select('SELECT * FROM terms');

        return json_encode($terms);
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
                'title' => 'required',
                'description' => 'required',
            ]);

            $insert = DB::insert('insert into terms (title, description) values (?, ?)', [$request->title, $request->description]);
            $this->createTermsLog($request->title);
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
                'description' => 'required',
            ]);

            $termsupdate = DB::update(
                'UPDATE terms SET title= ?, description = ? WHERE id = ?',
                [$request->title, $request->description, $id]
            );
            $this->updateTermsLog($request->title);

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
        $id = $request->input('progress_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('SELECT * from terms where id=?', [$id]);
        $title = $details[0]->title;


        try {
            $delete = DB::delete('DELETE from terms where id=?', [$id]);
            $this->deleteTermsLog($title);
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


    public function createTermsLog($name)
    {
        $this->logOperationToDatabase("Create Terms of Services: $name", 1, 'Terms of Services Management');
    }

    public function updateTermsLog($name)
    {
        $this->logOperationToDatabase("Update Terms of Services: $name", 2, 'Terms of Services Management');
    }

    public function deleteTermsLog($name)
    {
        $this->logOperationToDatabase("Delete Terms of Services: $name", 3, 'Terms of Services Management');
    }


    public function logOperationToDatabase($description, $operation, $management)
    {

        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into admin_logs (user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?)', [$user_id, $name, $operation, $description, $management]);
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
}
