<?php

namespace App\Repositories\Interfaces;

interface MockExamRepositoryInterface
{
    public function createMock($data);
    public function updateMockExam($id,$data);
    public function createMockQuestions($data);
    public function getMockExam($order_list_id);
    public function alreadyHave($order_list_id,$mock_number);
    public function getMockExamQuestionsList($mock_id);
    public function getMockWithId($mock_id);
    public function getMockQuestionWithId($id);
    public function saveQuestionAnswer($id, $answer);
    public function getMockScore($mock_id);
}

?>