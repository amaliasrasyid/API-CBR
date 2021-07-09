<?php
class Disease{
    //connection instance
    private $conn;

    //table name
    private $table_name = "cbr_penyakit";

    //table column
    public $id_penyakit;
    public $kd_penyakit;
    public $nm_penyakit;
    public $definisi;

    public function __construct($connection){
        $this->conn = $connection;
    }

    public function getDiseases(){
        $query = "SELECT id_penyakit, kd_penyakit, nm_penyakit, definisi FROM cbr_penyakit";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}