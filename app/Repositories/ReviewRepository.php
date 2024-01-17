<?php

namespace App\Repositories;


use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function createCourseReview($data)
    {
        return DB::table('courses_review')->insertGetId($data);
    }
    public function createInsructorReview($data)
    {
        return DB::table('instructor_review')->insertGetId($data);
    }
    public function createSchoolReview($data)
    {
        return DB::table('schools_review')->insertGetId($data);
    }

    public function orderListIdAlreadyRview($order_list_id)
    {
        return DB::table('courses_review')->where('order_list_id', $order_list_id)->count();
    }
    public function orderIdAlreadyRview($order_id)
    {
        return DB::table('schools_review')->where('order_id', $order_id)->count();
    }


    public function getCourseRating($courseId)
    {
        $r = DB::table('courses_review')->where('course_id', $courseId)->avg('rating');
        return $r == null ? 0 : $r;
    }
    public function getSchoolRating($school_id)
    {
        $r = DB::table('schools_review')->where('school_id', $school_id)->avg('rating');
        return $r == null ? 0 : $r;
    }

    public function topFive($school_id)
    {
        return DB::table('instructor_review')
            ->where('school_id', $school_id)
            ->select('instructor_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('instructor_id')
            ->orderByDesc('average_rating')
            ->limit(3)
            ->get();
    }
    public function checkIfStudentRateInstructorAlready($schedule_id, $student_id, $instructor_id)
    {
        return DB::table('instructor_review')
            ->where('student_id', $student_id)
            ->where('schedule_id', $schedule_id)
            ->where('instructor_id', $instructor_id)
            ->count();
    }
    public function totalCourseReview($courseId)
    {
        return DB::table('courses_review')->where('course_id', $courseId)->count();
    }
    public function totalSchoolReview($school_id)
    {
        return DB::table('schools_review')->where('school_id', $school_id)->count();
    }
    public function getCourseReview($courseId)
    {
        return DB::table('courses_review')
            ->join('students', 'courses_review.student_id', '=', 'students.student_id')
            ->join('users', '.students.student_id', '=', 'users.id')
            ->where('courses_review.course_id', $courseId)
            ->select(['courses_review.*', 'students.student_id', 'students.firstname', 'students.middlename', 'students.lastname', 'users.profile_image'])
            ->get();
    }
    public function getSchoolReview($school_id)
    {
        return DB::table('schools_review')
            ->join('students', 'schools_review.student_id', '=', 'students.student_id')
            ->join('users', '.students.student_id', '=', 'users.id')
            ->where('schools_review.school_id', $school_id)
            ->select(['schools_review.*', 'students.student_id', 'students.firstname', 'students.middlename', 'students.lastname', 'users.profile_image'])
            ->orderBy('schools_review.date_created', 'DESC')
            ->get();
    }

    public function getInstructorReview($instructor_id)
    {
        return DB::table('instructor_review')
            ->join('students', 'instructor_review.student_id', '=', 'students.student_id')
            ->join('users', '.students.student_id', '=', 'users.id')
            ->where('instructor_review.school_id', $instructor_id)
            ->select(['instructor_review.*', 'students.student_id', 'students.firstname', 'students.middlename', 'students.lastname', 'users.profile_image'])
            ->orderBy('instructor_review.date_created', 'DESC')
            ->get();
    }
}