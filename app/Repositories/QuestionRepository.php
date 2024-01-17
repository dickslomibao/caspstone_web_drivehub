<?php
namespace App\Repositories;

use App\Repositories\Interfaces\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuestionRepository implements QuestionRepositoryInterface
{
    public function create($data)
    {
        return DB::table('questions')->insertGetId($data);
    }

    public function createChoices($data)
    {
        return DB::table('question_choices')->insertGetId($data);
    }
    public function getQuestionWithId($id)
    {
        return DB::table('questions')->where('id', $id)->first();
    }

    public function getQuestionChoices($question_id)
    {
        return DB::table('question_choices')->where('question_id', $question_id)->inRandomOrder()->get();
    }
    public function getSomeQuestions($item, $school_id)
    {
        return DB::table('questions')
            ->where('status', 1)
            ->where('school_id', $school_id)
            ->inRandomOrder()
            ->limit($item)
            ->get();
    }
    public function getTotalQuestion($school_id)
    {
        return DB::table('questions')
            ->where('status', 1)
            ->where('school_id', $school_id)
            ->count();
    }
    public function getSchoolQuestions($school_id)
    {
        return DB::table('questions')
            ->join('question_choices', function ($join) {
                $join->on('questions.answer', '=', 'question_choices.code')
                    ->on('questions.id', "=", "question_choices.question_id");

            })
            ->where('school_id', $school_id)
            ->select(['questions.*', "question_choices.body as answer_body"])
            ->get();
    }
}
?>