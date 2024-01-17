<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MockExamRepositoryInterface;
use Illuminate\Support\Facades\DB;


class MockExamRepository implements MockExamRepositoryInterface
{
    public function createMock($data)
    {
        return DB::table("mock_student")->insertGetId($data);
    }
    public function createMockQuestions($data)
    {
        return DB::table("mock_student_questions")->insertGetId($data);
    }
    public function getMockExam($order_list_id)
    {
        return DB::table("mock_student")->where('order_list_id', $order_list_id)->get();
    }
    public function getMockWithId($mock_id)
    {
        return DB::table("mock_student")->where('id', $mock_id)->first();
    }
    public function getMockExamQuestionsList($mock_id)
    {
        return DB::table("mock_student_questions")->where('mock_id', $mock_id)->get();
    }

    public function alreadyHave($order_list_id, $mock_number)
    {
        return DB::table("mock_student")
            ->where('order_list_id', $order_list_id)
            ->where('mock_count', $mock_number)
            ->exists();
    }
    public function getMockScore($mock_id)
    {
        $count = 0;
        $result = DB::table("mock_student_questions")->where('mock_id', $mock_id)->get();

        foreach ($result as $key => $value) {
            if ($value->correct_answer == $value->user_answer) {
                $count++;
            }
        }
        return $count;
    }
    public function getMockQuestionWithId($id)
    {
        return DB::table("mock_student_questions")->where('id', $id)->first();
    }
    public function updateMockExam($id, $data)
    {
        return DB::table("mock_student")->where('id', $id)->update($data);
    }

    public function saveQuestionAnswer($id, $answer)
    {
        return DB::table("mock_student_questions")->where("id", $id)->update([
            'user_answer' => $answer,
        ]);
    }
}
?>