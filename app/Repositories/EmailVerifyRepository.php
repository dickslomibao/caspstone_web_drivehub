<?php

namespace App\Repositories;

use App\Repositories\Interfaces\EmailVerifyRepositoryInterface;
use Illuminate\Support\Facades\DB;


class EmailVerifyRepository implements EmailVerifyRepositoryInterface
{

    public function create($data)
    {
        DB::table('email_verify')->insert($data);
    }
    public function getwithLink($id)
    {
       return DB::table('email_verify')->where('id', $id)->first();
    }
}
?>