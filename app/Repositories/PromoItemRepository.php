<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PromoItemRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PromoItemRepository implements PromoItemRepositoryInterface
{
    public function create($data)
    {
        DB::table('promo_items')->insert($data);
    }

    //api
    public function getPromoItems($promo_id)
    {
        return DB::table('promo_items')
            ->where('promo_items.promo_id', $promo_id)
            ->get();
    }
}
