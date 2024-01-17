<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function getDrivingSchoolCourse(Request $request)
    {
        return response()->json([
            'code' => 200,
            'courses' => DB::table('courses')->where('school_id', $request->school_id)->get(),
        ]);
    }
}