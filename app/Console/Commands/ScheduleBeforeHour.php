<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleBeforeHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:beforehour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $oneHourFromNow = Carbon::now()->addHour()->format('Y-m-d H:i');
            Log::info($oneHourFromNow);
            $schedules = DB::table('schedules')->where('start_date', $oneHourFromNow)->get();
            foreach ($schedules as $key => $s) {
                $students = DB::table('schedule_students')->where('schedule_id', $s->id)->get();
                foreach ($students as $student) {
                    $user = DB::table('users')->where('id', $student->student_id)->first();
                    Log::info($user->phone_number);
                    $ch = curl_init();
                    $parameters = array(
                        'apikey' => env('SEMAPHORE_KEY'),
                        'number' => $user->phone_number,
                        'message' => 'Hi ' . $user->username . ', 1hr before your schedule',
                        'sendername' => 'DriveHub'
                    );
                    curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
            }
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
        }
        return Command::SUCCESS;
    }
}
