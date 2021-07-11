<?php
class Symptomp {
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_gejala";
 
    //table column
    public $id_gejala;
    public $kd_gejala;
    public $nm_gejala;
    public $bobot_parameter;
    public $keterangan;
    public $sympCategory;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$keterangan,$sympCategory){
        $this->id_gejala = $id_gejala;
        $this->kd_gejala = $kd_gejala;
        $this->nm_gejala = $nm_gejala;
        $this->bobot_parameter = $bobot_parameter;
        $this->keterangan = $keterangan;
        $this->sympCategory = $sympCategory;
    }

    public function getSymptompByCategory($id_kategori_gejala){
        $query = "SELECT a.*, b.* 
            FROM cbr_gejala as a, cbr_gejala_kategori as b
            WHERE a.id_gejala_kategori=b.id_gejala_kategori AND a.id_gejala_kategori=$id_kategori_gejala
            ORDER BY a.kd_gejala ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addSymptomConsultation(){

    }
 
}