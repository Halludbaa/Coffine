<?php

namespace Hallax\Clone\Controller;

use Hallax\Clone\Services\Hellper;

class MainController{

    public function index(){
        
        Hellper::view('index');
    }
}