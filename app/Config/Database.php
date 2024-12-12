<?php
namespace Hallax\Clone\Config;

use PDO, PDOException;
class Database{
    private $host = DB_HOST, 
            $engine = DB_ENGINE, 
            $port = DB_PORT,
            $pass = DB_PASS, 
            $user = DB_USER,
            $db_name = DB_NAME;
    
    private $dbh, $stmt;

    public function __construct()
    {
        $dsn = $this->engine . ':host=' . $this->host . ';port='. $this->port .';dbname=' . $this->db_name;

        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if( is_null($type) ){
            switch( true ){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
       return $this->stmt->rowCount();
    }
}