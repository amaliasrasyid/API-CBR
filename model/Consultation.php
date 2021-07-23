<?php
require_once '../../utils/HeaderTemplate.php';

class Consultation {
    //instance connection
    private $conn;

    //table column
    public $id_konsultasi;
    public $nama;
    public $tanggal;
    public $status;

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
        $query = "INSERT INTO konsultasi(nama, tanggal, status) VALUES ('$nama_konsul', '$tanggal', 1)";
        $stmt = executeQuery($this->conn,$query);
        $this->lastInsertedId = $this->conn->lastInsertId();
        return $stmt;
    }

    public function getLastCreatedConsultation(){
        $query = "SELECT k.* FROM konsultasi k WHERE k.id_konsultasi = $this->lastInsertedId";
        return executeQuery($this->conn,$query);
    }
}