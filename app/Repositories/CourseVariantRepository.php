<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CourseVariantRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CourseVariantRepository implements CourseVariantRepositoryInterface
{
    public function create($data)
    {
        return DB::table('courses_variant')->insert($data);
    }
    public function getCourseVariant($course_id)
    {
        return
            DB::table('courses_variant')
                ->where('course_id', $course_id)
                ->orderBy('price')
                ->get();
    }
    public function getCourseAvailableVariant($course_id)
    {
        return
            DB::table('courses_variant')
                ->where('course_id', $course_id)
                ->where('status',1)
                ->orderBy('price')
                ->get();
    }
    
    public function getVariantUsingId($variant_id)
    {
        return DB::table('courses_variant')->where('id', $variant_id)->first();

    }
}
