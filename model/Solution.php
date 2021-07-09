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

    public function __construct($connection){
        $this->conn = $connection;
    }

    public function getDiseaseSolution($id_penyakit){

    }
}