<?php 


namespace App\Repositories\Interfaces;

interface PromoItemRepositoryInterface{
    public function create($data);
    public function getPromoItems($promo_id);
}
