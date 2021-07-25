<?php
require_once '../../utils/HeaderTemplate.php';

class DiseaseMedicine{
    //instance connection
    private $conn;

    //table column
    public $id_penyakit_obat;
    public $id_penyakit;
    public $medicine;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_penyakit_obat,$id_penyakit = null,$medicine){
        $this->id_penyakit_obat = $id_penyakit_obat;
        $this->id_penyakit = $id_penyakit;
        $this->medicine = $medicine;
    }

    public function getDiseaseMedicine($id_penyakit){
        $query = "SELECT a.id_penyakit_obat, b.*,c.id_penyakit
        FROM penyakit_obat as a, obat as b, penyakit as c 
         WHERE a.id_obat=b.id_obat AND a.id_penyakit=c.id_penyakit AND c.id_penyakit=$id_penyakit";

        return executeQuery($this->conn,$query);
    }
}