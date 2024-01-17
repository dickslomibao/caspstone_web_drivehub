<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProgressRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProgressRepository implements ProgressRepositoryInterface
{

    public function create($data)
    {
        return DB::table('progress')->insertGetId($data);
    }
    public function createSubProgress($data)
    {
        return DB::table('sub_progress')->insertGetId($data);
    }
    public function updateProgress($data, $id, $school_id)
    {
        return DB::table('progress')->where('id', $id)->where('school_id', $school_id)->update($data);
    }
    public function retrieveAll($school_id)
    {
        return DB::table('progress')->select('*', DB::raw('(SELECT count(id) from sub_progress where sub_progress.progress_id = progress.id) as total_sub_progress'))
            ->where('school_id', $school_id)->get();
    }
    public function retrieveFromId($id, $school_id)
    {
        return DB::table('progress')->select('*', DB::raw('(SELECT count(id) from sub_progress where sub_progress.progress_id = progress.id) as total_sub_progress'))->where('id', $id)->where('school_id', $school_id)->first();
    }
    public function retrieveSubProgress($id)
    {
        return DB::table('sub_progress')->where('progress_id', $id)->get();
    }
    public function retrieveSubProgressFromId($id)
    {
        return DB::table('sub_progress')->where('id', $id)->first();
    }
    public function addCourseProgress($data)
    {
        return DB::table('course_progress')->insert($data);
    }
    public function addStudentProgress($data)
    {
        return DB::table('student_course_progress')->insert($data);
    }
    public function getCourseProgress($course_id)
    {
        return DB::table('course_progress')->where('course_id', $course_id)->get();
    }


    public function getOrderListProgress($order_list_id)
    {

        $progress = [];

        $progress_group = DB::table('student_course_progress')
            ->where('student_course_progress.order_list_id', $order_list_id)
            ->select(['student_course_progress.progress_id'])
            ->groupBy('student_course_progress.progress_id')
            ->get();

        foreach ($progress_group as $value) {
            $value->progress = DB::table("progress")->where('id', $value->progress_id)->first();
            $value->sub_progress = DB::table("student_course_progress")
                ->join('sub_progress', 'student_course_progress.sub_progress_id', "=", "sub_progress.id")
                ->where('student_course_progress.progress_id', $value->progress_id)
                ->where('student_course_progress.order_list_id', $order_list_id)
                ->select(['student_course_progress.*', 'sub_progress.title'])
                ->get();



            array_push($progress, $value);
        }
        return $progress;
    }
    public function updateStudentProgress($id, $data)
    {
        return DB::table('student_course_progress')->where('id', $id)->update($data);
    }

    public function checkAllOrderListProgress($order_list_id, $user_id)
    {
        return DB::table('student_course_progress')
            ->where('order_list_id', $order_list_id)
            ->where('status', 1)
            ->update([
                'status' => 2,
                'process_by' => $user_id
            ]);
    }
}
