<?php
class DbConnection{
    private $dbhost="127.0.0.1";
    private $dbname="project_wcbr";
    private $dbuser="root";
    private $dbPassword="";

    public $connection;

    public function getConnection(){
        $this->connection = null;
        try{
            $this->connection =  new PDO("mysql:host=".$this->dbhost.";dbname=".$this->dbname, $this->dbuser,$this->dbPassword);
        }catch(PDOException $e){
            echo "Database could not connected: ".$e->getMessage();
        }
        return $this->connection;
    }
}