<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PromoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PromoRepository implements PromoRepositoryInterface
{
    public function create($data)
    {
        DB::table('promo')->insert($data);
    }
    public function getSinglePromoUsingId($promo_id, $school_id)
    {
        return DB::table('promo')
            ->where('id', $promo_id)
            ->where('school_id', $school_id)->first();
    }

    public function getSchoolPromo($school_id)
    {
        return DB::table('promo')->where('school_id', $school_id)->select([
            'id',
            'name',
            'start_date',
            'end_date',
            'price',
            'date_created',
            'date_updated',
        ])->get();
    }

    //api

    public function getSchoolPromoForMobile($school_id)
    {
        return DB::table('promo')
            ->where('school_id', $school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
    }
}
