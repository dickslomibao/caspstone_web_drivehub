<?php

namespace App\Repositories\Interfaces;

interface EmailVerifyRepositoryInterface
{
    public function create($data);
    public function getwithLink($id);
    

}

?>