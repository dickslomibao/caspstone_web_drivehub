<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $appends = ['info', 'schoolid', 'acre'];
    /**\
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_image',
        'type',
        'is_verified',
        'phone_number'
    ];
    public function getInfoAttribute()
    {

        if ($this->type == 1) {
            return DB::table('schools')->where('user_id', $this->id)->first();
        }
        if ($this->type == 2) {
            return DB::table('instructors')->where('user_id', $this->id)->first();
        }
        if ($this->type == 3) {
            return DB::table('students')->where('student_id', $this->id)->first();
        }
        if ($this->type == 4) {
            return DB::table('staff')->where('staff_id', $this->id)->first();
        }
        if ($this->type == 5) {
            return DB::table('admin')->where('admin_id', $this->id)->first();
        }
        return null;
    }
    public function getSchoolidAttribute()
    {
        if ($this->type == 1) {
            return $this->id;
        }
        if ($this->type == 4) {
            return DB::table('staff')->where('staff_id', $this->id)->first()->school_id;
        }
        return null;
    }
    public function getAcreAttribute()
    {
        if ($this->type == 1) {
            return DB::table('schools')->where('user_id', $this->schoolid)->first()->accreditation_status;
        }
        if ($this->type == 4) {
            return DB::table('schools')->where('user_id', $this->schoolid)->first()->accreditation_status;
        }
        return null;
      
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
