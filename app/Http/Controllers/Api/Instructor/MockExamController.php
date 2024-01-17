<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorReportRepositoryInterface;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\MockExamRepositoryInterface;
use App\Repositories\Interfaces\OrderListRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class MockExamController extends Controller
{
    public $mockExamRepository;
    public $orderListRepository;
    public $questionRepository;
    public $instructorRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepositoryInterface, QuestionRepositoryInterface $questionRepositoryInterface, MockExamRepositoryInterface $mockExamRepositoryInterface, OrderListRepositoryInterface $orderListRepositoryInterface)
    {
        $this->mockExamRepository = $mockExamRepositoryInterface;
        $this->orderListRepository = $orderListRepositoryInterface;
        $this->questionRepository = $questionRepositoryInterface;
        $this->instructorRepository = $instructorRepositoryInterface;
    }
    public function createMockExam(Request $request)
    {

        $code = 200;
        $message = "success";
        try {
            $q = $this->questionRepository->getTotalQuestion($this->instructorRepository->getInstructorDataUsingUserId(auth()->user()->id)->school_id);
            if (
                $request->item_count > $q
            ) {
                throw new Exception($q . ' only available questions');
            }
            foreach ($request->order_list_id as $key => $id) {
                $order = $this->orderListRepository->getSingleOrderListWithId($id);
                $item_count = $request->item_count;
                if ($this->mockExamRepository->alreadyHave($id, $request->mock_count)) {
                    continue;
                }
                $mock_id = $this->mockExamRepository->createMock([
                    'order_list_id' => $id,
                    'assigned_by' => auth()->user()->id,
                    'student_id' => $order->student_id,
                    'mock_count' => $request->mock_count,
                    'items' => $item_count,
                ]);
                $questions = $this->questionRepository->getSomeQuestions($item_count, auth()->user()->info->school_id);
                foreach ($questions as $key => $q) {
                    $this->mockExamRepository->createMockQuestions([
                        'mock_id' => $mock_id,
                        'question_id' => $q->id,
                        'correct_answer' => $q->answer,
                    ]);
                }
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
