<?php
require_once '../../utils/HeaderTemplate.php';

class SymptompCategory{
    //instance connection
    private $conn;

    //table column
    public $id_gejala_kategori;
    public $gejala_kategori;
    public $keterangan;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_gejala_kategori,$gejala_kategori,$keterangan){
        $this->id_gejala_kategori = $id_gejala_kategori;
        $this->gejala_kategori = $gejala_kategori;
        $this->keterangan = $keterangan;
    }

    public function getSymptompCategory(){
        $query = "SELECT gk.* FROM gejala_kategori gk ORDER BY id_gejala_kategori ASC";
        return executeQuery($this->conn,$query);
    }
}