<?php

namespace App\Repositories\Interfaces;

interface QuestionRepositoryInterface
{

    public function create($data);
    public function createChoices($data);
    public function getSchoolQuestions($school_id);
    public function getTotalQuestion($school_id);
    public function getQuestionWithId($id);
    public function getSomeQuestions($item,$school_id);
    public function getQuestionChoices($question_id);
}

?>