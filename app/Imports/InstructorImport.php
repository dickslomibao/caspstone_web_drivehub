<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class InstructorImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $errors = [];
        foreach ($rows as $row) {
            if (User::where('email', $row[7])->exists()) {
                $errors[] = $row[7] . "already used";
            }
            if (User::where('username', $row[6])->exists()) {
                $errors[] = $row[6] . "already used";
            }
            if (User::where('phone_number', '0' . $row[9])->exists()) {
                $errors[] = $row[9] . "already used";
            }
        }

        if (count($errors) == 0) {
            foreach ($rows as $row) {
                $numericDate = $row[4];
                $birthdate = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($numericDate - 2);
                $u = User::create([
                    'username' => $row[6],
                    'email' => $row[7],
                    'password' => $row[8],
                    'profile_image' => 'storage/profile/temp.png',
                    'type' => 2,
                    'phone_number' => '0' . $row[9],
                ]);
                DB::table('instructors')->insert([
                    'user_id' =>   $u->id,
                    'school_id' => auth()->user()->id,
                    'firstname' => $row[0],
                    'middlename' => $row[1],
                    'lastname' =>  $row[2],
                    'sex' => $row[3],
                    'birthdate' =>     $birthdate,
                    'address' => $row[5],
                ]);
            }
        } else {
            return redirect()->back()->with('errors', $errors);
        }
    }
}
