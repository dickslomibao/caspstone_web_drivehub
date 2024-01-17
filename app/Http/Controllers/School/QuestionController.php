<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

use Stichoza\GoogleTranslate\GoogleTranslate;

class QuestionController extends Controller
{

    private $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepositoryInterface)
    {
        $this->middleware('auth');
        $this->middleware('role:9');
        $this->questionRepository = $questionRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('school.features.question_management.index', [
            'questions' => $this->questionRepository->getSchoolQuestions(auth()->user()->schoolid)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.features.question_management.create');
    }
    public function getSchoolQuestion()
    {
        return response()->json($this->questionRepository->getSchoolQuestions(auth()->user()->schoolid));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = new GoogleTranslate('en');
        $lang->setSource('en')->setTarget('tl');
        $path = "";
        if ($request->hasFile("images")) {
            $path = $request->file('images')->storePublicly('public/reference');
            $path = Str::replace('public', 'storage', $path);
        }


        $id = $this->questionRepository->create([
            'school_id' => auth()->user()->schoolid,
            'questions' => $request->input('question'),
            'tagalog' => $lang->translate($request->input('question')),
            'status' => $request->input('status'),
            'images' => $path,
            'answer' => $request->input('answer'),
        ]);
        foreach ($request->input('choices') as $key => $value) {
            $this->questionRepository->createChoices(
                [
                    'question_id' => $id,
                    'code' => ++$key,
                    'body' => $value,
                    'body_tagalog' => $lang->translate($value),
                ]
            );
        }

        $this->createQuestionLog($request->input('question'));
        return redirect()->route('index.question');
    }




    public function deleteQuestion(Request $request)
    {
        $id = $request->input('question_id');
        $message = "Delete Successfully";
        $code = 200;

        $details = DB::select('Select * FROM  questions WHERE id=?', [$id]);
        $question = $details[0]->questions;

        try {
            if (DB::table('mock_student_questions')->where('question_id', $id)->exists()) {
                throw new Exception('Cannot delete. Already used.', 505);
            }
            $delete = DB::delete('DELETE from questions where id=?', [$id]);
            $del = DB::delete('DELETE from question_choices where question_id=?', [$id]);
            $this->deleteQuestionLog($question);
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



    public function updateQuestion($id)
    {
        $details = DB::select('Select * FROM  questions WHERE id=?', [$id]);
        $choices = DB::select('Select * FROM  question_choices WHERE question_id=? ORDER BY CODE ASC', [$id]);

        return view('school.features.question_management.update', ['details' => $details[0], 'choices' => $choices]);
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
    public function update(Request $request)
    {
        $lang = new GoogleTranslate('en');
        $lang->setSource('en')->setTarget('tl');

        $path = "";
        $id = $request->input('question_id');
        $question = $request->input('question');

        $status = $request->input('status');
        $answer = $request->input('answer');
        $code = 200;

        $message = "Update Successfully";

        try {

            if ($request->hasFile("images")) {
                $path = $request->file('images')->storePublicly('public/reference');
                $path = Str::replace('public', 'storage', $path);

                $pic = DB::update(
                    'UPDATE questions SET images = ? WHERE id = ?',
                    [$path, $id]
                );
            }

            $questionUpdate = DB::update(
                'UPDATE questions SET questions = ?, status = ?, tagalog = ?,   answer = ? WHERE id = ?',
                [$question, $status, $lang->translate($request->input('question')), $answer, $id]
            );

            $del = DB::delete('DELETE from question_choices where question_id=?', [$id]);

            foreach ($request->input('choices') as $key => $value) {
                $this->questionRepository->createChoices(
                    [
                        'question_id' => $id,
                        'code' => ++$key,
                        'body' => $value,
                        'body_tagalog' => $lang->translate($value),
                    ]
                );
            }

            $this->updateQuestionLog($question);
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


    public function createQuestionLog($name)
    {
        $this->logOperationToDatabase("Create Question: $name", 1, 'Question Management');
    }

    public function updateQuestionLog($name)
    {
        $this->logOperationToDatabase("Update Question: $name", 2, 'Question Management');
    }

    public function deleteQuestionLog($name)
    {
        $this->logOperationToDatabase("Delete Question: $name", 3, 'Question Management');
    }

    public function logOperationToDatabase($description, $operation, $management)
    {
        $id = Auth::user()->schoolid;
        $user_id = Auth::user()->id;
        $name = $this->getName();


        $insert = DB::insert('insert into logs (school_id, user_id, name, operation, description, management_type) values (?, ?, ?, ?, ?, ?)', [$id, $user_id, $name, $operation, $description, $management]);
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
