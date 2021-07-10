<?php
class Consultation {
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_konsultasi";

    //table column
    public $id_konsultasi;
    public $nama;
    public $tanggal;

    private $lastInsertedId ;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_konsultasi,$nama,$tanggal){
        $this->id_konsultasi = $id_konsultasi;
        $this->nama = $nama;
        $this->tanggal = $tanggal;
    }

    public function create($nama_konsul,$tanggal){
        $query = "INSERT INTO cbr_konsultasi(nama, tanggal, status) VALUES ('$nama_konsul', '$tanggal', 1)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $this->lastInsertedId = $this->conn->lastInsertId();
        return $stmt;
    }

    public function getLastCreatedConsultation(){
        $query = "SELECT k.* FROM cbr_konsultasi k WHERE k.id_konsultasi = $this->lastInsertedId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}