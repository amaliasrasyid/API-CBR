<?php
require_once '../../utils/HeaderTemplate.php';

class ConsultationResult{
    //instance connection
    private $conn;
 
    //table column
    public $id_konsultasi_hasil;
    public $disease;
    public $nilai;
    public $status;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_konsultasi_hasil,$disease,$nilai,$status){
        $this->id_konsultasi_hasil = $id_konsultasi_hasil;
        $this->disease = $disease;
        $this->nilai = $nilai;
        $this->status = $status;
    }

    // public function getConsultResult($id_konsultasi){
    //     $query = "SELECT a.id_konsultasi_hasil,b.*,c.*,d.*
    //     FROM konsultasi_hasil as a, konsultasi as b, obat as c, penyakit as d
    //     WHERE a.id_konsultasi = b.id_konsultasi AND  a.id_penyakit = d.id_penyakit
    //     AND a.id_konsultasi = $id_konsultasi AND b.status= 1";
    //     return executeQuery($this->conn,$query);
    // }
    // public function consultResult($id_konsultasi,$listGejala){
    //     $diseaseSymp = new DiseaseSymptomp($this->conn);
    //     $similarity = $diseaseSymp->calculateDiseaseSymp($listGejala);

    //     // var_dump($similarity);
    //     foreach($similarity as $item){
    //         var_dump($item);
            
    //         //insert result consultation
    //         $query = "INSERT INTO konsultasi_hasil (id_konsultasi,id_obat,id_penyakit,status"
    //         executeQuery($this->conn,$query);
    //     }
    // }

}