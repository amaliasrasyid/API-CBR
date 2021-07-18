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
    public $sympCategory;
    public $isSelected;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$sympCategory,$isSelected){
        $this->id_gejala = $id_gejala;
        $this->kd_gejala = $kd_gejala;
        $this->nm_gejala = $nm_gejala;
        $this->bobot_parameter = $bobot_parameter;
        $this->sympCategory = $sympCategory;
        $this->isSelected = $isSelected;
    }

    public function getSymptompByCategory($id_kategori_gejala){
        return $this->executeQuery("SELECT a.*, b.*
            FROM cbr_gejala as a, cbr_gejala_kategori as b
            WHERE a.id_gejala_kategori=b.id_gejala_kategori AND a.id_gejala_kategori=$id_kategori_gejala
            ORDER BY a.kd_gejala ASC");
    }

    public function isDataExistInConsult($id_konsultasi,$id_gejala){
        return $this->executeQuery("SELECT count(*) as jml_data_exist 
        FROM cbr_konsultasi_gejala 
        WHERE id_konsultasi=$id_konsultasi AND id_gejala=$id_gejala ");
    }

    private function executeQuery($query){
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
 
}