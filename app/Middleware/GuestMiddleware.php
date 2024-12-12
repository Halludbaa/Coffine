<?php
namespace Hallax\Clone\Middleware;

use Hallax\Clone\Services\Hellper;
use Hallax\Clone\Services\Middleware;

class GuestMiddleware extends Middleware {

    public function before()
    {   
        
        if(isset($_SESSION['user'])){
            Hellper::redirect('/');
            exit;
        } 
    }
}
