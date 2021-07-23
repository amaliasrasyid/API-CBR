<?php
require_once '../../utils/HeaderTemplate.php';

class DiseaseSolution{
    //instance connection
    private $conn;

    //table column
    public $id_penyakit_solusi;
    public $id_penyakit;
    public $solution;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_penyakit_solusi,$id_penyakit = null,$solution){
        $this->id_penyakit_solusi = $id_penyakit_solusi;
        $this->id_penyakit = $id_penyakit;
        $this->solution = $solution;
    }

    public function getDiseaseSolutions($id_penyakit){
        $query = "SELECT a.id_penyakit_solusi, b.*,c.id_penyakit
        FROM penyakit_solusi as a, solusi as b, penyakit as c 
        WHERE a.id_solusi=b.id_solusi AND a.id_penyakit=c.id_penyakit AND c.id_penyakit=$id_penyakit";

        return executeQuery($this->conn,$query);
    }
}