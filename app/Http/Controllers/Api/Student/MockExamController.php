<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MockExamRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class MockExamController extends Controller
{
    public $mockExamRepository;
    public $orderListRepository;
    public $questionRepository;
    public function __construct(QuestionRepositoryInterface $questionRepositoryInterface, MockExamRepositoryInterface $mockExamRepositoryInterface, OrderListRepositoryInterface $orderListRepositoryInterface)
    {
        $this->mockExamRepository = $mockExamRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->questionRepository = $questionRepositoryInterface;
    }

    public function getStudentMockList($order_list_id)
    {

        $code = 200;
        $message = "Success";
        $mock_list = [];
        try {
            $data = $this->mockExamRepository->getMockExam($order_list_id);
            foreach ($data as $key => $value) {
                $value->score = $this->mockExamRepository->getMockScore($value->id);
                array_push($mock_list, $value);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'mock_list' => $mock_list,
                'message' => $message,
            ]
        );
    }
    public function getStudentMockQuestions($mock_id)
    {

        $code = 200;
        $message = "Success";
        $questions_list = [];

        try {
            $mock = $this->mockExamRepository->getMockWithId($mock_id);
            if ($mock->status == 1) {
                $this->mockExamRepository->updateMockExam($mock_id, [
                    'status' => 2,
                    'date_started' => now(),
                ]);
            }
            $data = $this->mockExamRepository->getMockExamQuestionsList($mock_id);
            foreach ($data as $key => $value) {
                $value->question = $this->questionRepository->getQuestionWithId($value->question_id);
                $value->choices = $this->questionRepository->getQuestionChoices($value->question_id);
                array_push($questions_list, $value);
            }
        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'questions' => $questions_list,
                'message' => $message,
            ]
        );
    }
    public function saveQuestionAnswer(Request $request)
    {

        $code = 200;
        $message = "Success";


        try {

            $this->mockExamRepository->updateMockExam($request->mock_id, [
                'status' => 2,
            ]);
            $this->mockExamRepository->saveQuestionAnswer($request->id, $request->answer);



        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,
                'message' => $message,
            ]
        );


    }


    public function submitAnswer(Request $request)
    {

        $code = 200;
        $message = "Success";

        try {
            $temp = $this->mockExamRepository->getMockQuestionWithId($request->ids[0]);
            $this->mockExamRepository->updateMockExam($temp->mock_id, [
                'status' => 3,
                'date_submitted' => now(),
            ]);
            for ($i = 0; $i < count($request->ids); $i++) {
                $this->mockExamRepository->saveQuestionAnswer($request->ids[$i], $request->answers[$i]);
            }

        } catch (Exception $ex) {
            $code = 505;
            $message = $ex->getMessage();
        }
        return response()->json(
            [
                'code' => $code,

                'message' => $message,
            ]
        );


    }
}
