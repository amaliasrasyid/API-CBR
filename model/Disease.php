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

    public function __construct($connection=null){
        $this->conn = $connection;
    }

    public function init($id_penyakit,$kd_penyakit,$nm_penyakit,$definisi)
    {
        $this->id_penyakit = $id_penyakit;
        $this->kd_penyakit = $kd_penyakit;
        $this->nm_penyakit = $nm_penyakit;
        $this->definisi = $definisi;
    }

    public function getDiseases(){
        $query = "SELECT penyakit.* FROM cbr_penyakit as penyakit";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getDiseasesById($id_penyakit){
        $query = "SELECT penyakit.* FROM cbr_penyakit as penyakit WHERE penyakit.id_penyakit = $id_penyakit";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}