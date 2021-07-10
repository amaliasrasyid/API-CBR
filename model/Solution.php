<?php
class Solution{
    //instance connection
    private $conn;

    //table name
    private $table_name="cbr_solusi";

    //table column
    public $id_solusi;
    public $kd_solusi;
    public $nm_solusi;
    public $keterangan;

    public function __construct($connection = null){
        $this->conn = $connection;
    }

    public function init($id_solusi,$kd_solusi,$nm_solusi,$keterangan){
        $this->id_solusi = $id_solusi;
        $this->kd_solusi = $kd_solusi;
        $this->nm_solusi = $nm_solusi;
        $this->keterangan = $keterangan;
    }

    public function getSolutions(){
        $query = "SELECT id_solusi, kd_solusi, nm_solusi, keterangan FROM cbr_solusi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}