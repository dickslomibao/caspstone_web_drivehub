<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:7');
    }
    public function index()
    {
        return view("school.features.tracking.index");
    }
}
