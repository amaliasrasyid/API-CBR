<?php
class Kasus {
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_kasus";
 
    //table column
    public $id_kasus;
    public $nama;
    public $disease;
    public $tanggal;
    public $status;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_kasus,$nama,$tanggal,$status){
        $this->id_kasus = $id_kasus;
        $this->nama = $nama;
        $this->tanggal = $tanggal;
        $this->status = $status;
    }

    public function getCases(){
        $query = "SELECT kasus.* FROM cbr_kasus kasus";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}