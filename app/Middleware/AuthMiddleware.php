<?php

namespace Hallax\Clone\Middleware;

use Hallax\Clone\Services\Hellper;
use Hallax\Clone\Services\Middleware;

class AuthMiddleware extends Middleware{

    public function before()
    {   
        if(!isset($_SESSION['user'])){
            Hellper::redirect('/login');
            exit;
        }
    }
}