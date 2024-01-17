<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $progressRepository;
    public function __construct(ProgressRepositoryInterface $progessRepositoryInterface)
    {
        $this->middleware('auth');
        $this->middleware('role:6');
        $this->progressRepository = $progessRepositoryInterface;
    }
    public function index()
    {
        return view('school.features.progress_management.index');
    }

    public function retrieveAll()
    {
        return json_encode($this->progressRepository->retrieveAll(auth()->user()->schoolid));
    }
    public function retreiveSubProgress($id)
    {
        return json_encode($this->progressRepository->retrieveSubProgress($id));
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
            $id = $this->progressRepository->create([
                'school_id' => auth()->user()->schoolid,
                'title' => $request->title,
                'descriptions' => $request->description,
            ]);
            $this->createProgressLog($request->title);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'progress' => $id ? $this->progressRepository->retrieveFromId(
                $id,
                auth()->user()->schoolid
            ) : null,
        ]);
    }
    public function updateProgress(Request $request, $id)
    {
        $code = 200;
        $message = "Updated Succcessfully";

        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
            $this->progressRepository->updateProgress([
                'title' => $request->title,
                'descriptions' => $request->description,

            ], $id, auth()->user()->schoolid);
            $this->updateProgressLog($request->title);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'progress' => $this->progressRepository->retrieveFromId($id, auth()->user()->schoolid),
        ]);
    }
    public function storeSubCategory(Request $request, $progress_id)
    {
        $code = 200;
        $message = "Added Succcessfully";
        $id = null;
        try {
            $request->validate([
                'title' => 'required',
            ]);
            $id = $this->progressRepository->createSubProgress([
                'progress_id' => $progress_id,
                'title' => $request->title,
            ]);

            $details = DB::select('Select * FROM  progress WHERE id=?', [$progress_id]);
            $title = $details[0]->title;

            $this->createSubProgressLog($title, $request->title);
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json([
            'code' => $code,
            'message' => $message,
            'progress' => $id ? $this->progressRepository->retrieveSubProgressFromId($id) : null,
        ]);
    }




    public function deleteProgress(Request $request)
    {
        $id = $request->input('progress_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('Select * FROM  progress WHERE id=?', [$id]);
        $title = $details[0]->title;


        try {
            if (DB::table('course_progress')->where('progress_id', $id)->exists()) {
                throw new Exception('Cannot delete already used.', 505);
            }
            $delete = DB::delete('DELETE from progress where id=?', [$id]);
            $this->deleteProgressLog($title);
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

    public function deleteSubProgress(Request $request)
    {
        $id = $request->input('sub_progress_id');
        $message = "Delete Successfully";
        $code = 200;

        $getProgressID = DB::select('Select * FROM  sub_progress WHERE id=?', [$id]);
        $prog_id =  $getProgressID[0]->progress_id;
        $title = $getProgressID[0]->title;

        $details = DB::select('Select * FROM  progress WHERE id=?', [$prog_id]);
        $prog_title = $details[0]->title;

        try {
            $delete = DB::delete('DELETE from sub_progress where id=?', [$id]);
            $this->deleteSubProgressLog($prog_title, $title);
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



    public function updateSubProgress(Request $request)
    {
        $id = $request->input('subprog_id');

        $code = 200;
        $message = "Update Successfully";

        try {

            $title = $request->input('subtitle');
            $subProgress = DB::update(
                'UPDATE sub_progress SET title = ? WHERE id = ?',
                [$title, $id]
            );

            $getProgressID = DB::select('Select * FROM  sub_progress WHERE id=?', [$id]);
            $prog_id =  $getProgressID[0]->progress_id;

            $details = DB::select('Select * FROM  progress WHERE id=?', [$prog_id]);
            $prog_title = $details[0]->title;

            $this->updateSubProgressLog($prog_title, $title);
        } catch (Exception $ex) {
            $code = 500;
            $message = $ex->getMessage();
        }
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


    public function createProgressLog($name)
    {
        $this->logOperationToDatabase("Create Progress: $name", 1, 'Progress Management');
    }

    public function updateProgressLog($name)
    {
        $this->logOperationToDatabase("Update Progress: $name", 2, 'Progress Management');
    }

    public function deleteProgressLog($name)
    {
        $this->logOperationToDatabase("Delete Progress: $name", 3, 'Progress Management');
    }



    public function createSubProgressLog($progress, $subprogress)
    {
        $this->logOperationToDatabase("Create Sub-Progress under '$progress': $subprogress", 1, 'Progress Management');
    }

    public function updateSubProgressLog($progress, $subprogress)
    {
        $this->logOperationToDatabase("Update Sub-Progress under '$progress': $subprogress", 2, 'Progress Management');
    }

    public function deleteSubProgressLog($progress, $subprogress)
    {
        $this->logOperationToDatabase("Delete Sub-Progress under '$progress': $subprogress", 3, 'Progress Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
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
