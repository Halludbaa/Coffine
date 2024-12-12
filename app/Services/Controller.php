<?php

namespace Hallax\Clone\Services;

abstract class Controller{
    public function __construct()
    {
        if(isset($_COOKIE['user'])) $_SESSION['user'] = $_COOKIE['user'];
    }
}