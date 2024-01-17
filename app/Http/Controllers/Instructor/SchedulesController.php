<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\InstructorRepositoryInterface;
use App\Repositories\Interfaces\PracticalSchedulesRepositoryInterface;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{

    public $instructorRepository;
    public $practicalSchedulesRepository;
    public function __construct(InstructorRepositoryInterface $instructorRepositoryInterface, PracticalSchedulesRepositoryInterface $practicalSchedulesRepository)
    {
        $this->instructorRepository = $instructorRepositoryInterface;
        $this->practicalSchedulesRepository = $practicalSchedulesRepository;
    }

    //apiCAll
    public function getInstructorsSchedule()
    {
        $schedules = [];
        $instructor = $this->instructorRepository->getInstructorDataUsingUserId(auth()->user()->id);
        $days = $this->practicalSchedulesRepository->getInstructoSchedulesGroupByDay($instructor->id);
        foreach ($days as $day) {
            $temp = [];
            $temp['day'] = $day->day;
            $temp['schedules'] = $this->practicalSchedulesRepository->getPracticalSchedulesWithListOfId(explode(",", $day->schedule_ids));
            array_push($schedules, $temp);
        }
        return response()->json($schedules);
    }
    public function getInstructorsScheduleWithId(Request $request)
    {

        return response()->json($this->practicalSchedulesRepository->getPracticalSchedulesWithId($request->id));
    }
}