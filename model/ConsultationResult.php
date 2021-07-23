<?php
class ConsultationResult{
    //instance connection
    private $conn;
 
    //table column
    public $id_konsultasi_hasil;
    public $consultation;
    public $medicine;
    public $disease;
    public $status;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_konsultasi_hasil,$case,$disease,$nilai,$status){
        $this->id_konsultasi_hasil = $id_konsultasi_hasil;
        $this->case = $case;
        $this->disease = $disease;
        $this->nilai = $nilai;
        $this->status = $status;
    }

    public function getConsultResult($id_konsultasi){
        $query = "SELECT a.id_konsultasi_hasil,b.*,c.*,d.*
        FROM konsultasi_hasil as a, konsultasi as b, obat as c, penyakit as d
        WHERE a.id_konsultasi = b.id_konsultasi AND  a.id_penyakit = d.id_penyakit
        AND a.id_konsultasi = $id_konsultasi AND b.status= 1";
        return executeQuery($this->conn,$query);

    }

}