<?php

namespace App\Http\Controllers\Schoo;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\SchoolRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public $schoolRepository;
    public function __construct(
        SchoolRepositoryInterface $schoolRepositoryInterface,
    ) {
        $this->schoolRepository = $schoolRepositoryInterface;
    }
    public function index()
    {

        $id = Auth::user()->schoolid;

        $openHours = DB::select('SELECT * FROM school_openhours WHERE school_id = ?', [$id]);

        return view('school.features.profile.index', [
            'terms' => DB::table('school_policy')->where('school_id', auth()->user()->schoolid)->first(),
            'about' => DB::table('school_about')->where('school_id', auth()->user()->schoolid)->first(),
            'school' => $this->schoolRepository->getDrivingSchoolWithId(auth()->user()->schoolid),
            'openHours' => $openHours[0]
        ]);
    }

    public function addtermsAndConditon(Request $request)
    {
        DB::table('school_policy')->insert([
            'school_id' => auth()->user()->schoolid,
            'content' => $request->content,
        ]);
        return redirect()->back()->with('message', 'Added Successfully');
    }
    public function updatetermsAndConditon(Request $request, $id)
    {
        DB::table('school_policy')->where('id', $id)->update([

            'content' => $request->content,
        ]);
        return redirect()->back()->with('message', 'Updated Successfully');
    }
    public function updateAbout(Request $request, $id)
    {
        DB::table('school_about')->where('id', $id)->update([

            'content' => $request->content,
        ]);
        return redirect()->back()->with('message', 'Updated Successfully');
    }

    public function addAbout(Request $request)
    {
        DB::table('school_about')->insert([
            'school_id' => auth()->user()->schoolid,
            'content' => $request->content,
        ]);
        return redirect()->back()->with('message', 'Added Successfully');
    }


    public function updateOpenHours(Request $request)
    {

        $id = Auth::user()->schoolid;

        DB::table('school_openhours')
            ->where('school_id', $id)
            ->update([
                'opening_time' => $request->opening,
                'closing_time' => $request->closing,
                'type' => $request->openFrom
            ]);
        return redirect()->back()->with('message', 'Update Successfully');
    }

    // $id = Auth::user()->schoolid;

    // $openFrom =  $request->input('openFrom');
    // $opening =  $request->input('opening');
    // $closing =  $request->input('closing');

    // $open_hours = DB::update('UPDATE school_openhours SET opening_time = ?, closing_time = ?, type = ? WHERE school_id = ?', [$opening, $closing, $openFrom, $id]);

    // // return redirect()->back()->with('message', 'Updated Successfully');

    //return dd($openFrom);
}
