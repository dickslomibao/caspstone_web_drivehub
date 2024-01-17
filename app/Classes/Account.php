<?php
namespace App\Classes;

use App\Models\User;

class Account{

    public static function createAccount($data){
       return User::create($data);
    }
}