<?php
class SymptompCategory{
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_gejala_kategori";

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
        $query = "SELECT gk.* FROM cbr_gejala_kategori gk ORDER BY id_gejala_kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}