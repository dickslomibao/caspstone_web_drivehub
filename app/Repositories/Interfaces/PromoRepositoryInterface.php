<?php 


namespace App\Repositories\Interfaces;

interface PromoRepositoryInterface{
    public function create($data);
    public function getSinglePromoUsingId($promo_id, $school_id);


    public function getSchoolPromo($school_id);
    public function getSchoolPromoForMobile($school_id);

}

?>