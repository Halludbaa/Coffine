<?php
namespace Hallax\Clone\Services;

use Hallax\Clone\Config\Database;


abstract class Model {
    
    protected $db;
    public function __construct() {
        $this->db = new Database;
    }

}