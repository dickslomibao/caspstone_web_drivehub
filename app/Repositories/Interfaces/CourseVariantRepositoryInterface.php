<?php

namespace App\Repositories\Interfaces;

interface CourseVariantRepositoryInterface
{
    public function create($data);
    public function getCourseVariant($course_id);
    public function getCourseAvailableVariant($course_id);
    public function getVariantUsingId($variant_id);
}