<?php
require_once '../../utils/HeaderTemplate.php';

class Medicine{
    //connection instance
    private $conn;

    //table column
    public $id_obat;
    public $kd_obat;
    public $nm_obat;

    public function __construct($connection=null){
        $this->conn = $connection;
    }

    public function init($id_obat,$kd_obat,$nm_obat)
    {
        $this->id_obat = $id_obat;
        $this->kd_obat = $kd_obat;
        $this->nm_obat = $nm_obat;
    }

    public function getMedicineById($id_obat){
        return executeQuery($this->conn,"SELECT * FROM obat WHERE id_obat=$id_obat");
    }
}