<?php
require_once '../../utils/HeaderTemplate.php';

class ConsultationResult{
    //instance connection
    private $conn;
 
    //table column
    public $id_konsultasi_hasil;
    public $disease;
    public $medicine;
    public $nilai;
    public $status;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_konsultasi_hasil,$disease,$medicine,$nilai,$status){
        $this->id_konsultasi_hasil = $id_konsultasi_hasil;
        $this->disease = $disease;
        $this->medicine = $medicine;
        $this->nilai = $nilai;
        $this->status = $status;
    }

    public function getConsultResult($id_konsultasi){
        $query = "SELECT a.id_konsultasi_hasil,b.*,c.*,d.*,a.nilai
        FROM konsultasi_hasil as a, konsultasi as b, obat as c, penyakit as d
        WHERE a.id_konsultasi = b.id_konsultasi AND  a.id_penyakit = d.id_penyakit AND a.id_obat = c.id_obat
         AND a.id_konsultasi = $id_konsultasi AND b.status= 1";
        return executeQuery($this->conn,$query);
    }

    public function consultResult($id_konsultasi,$listGejala){
        $diseaseSymp = new DiseaseSymptomp($this->conn);
        $similarity = $diseaseSymp->calculateDiseaseSymp($listGejala);

        // var_dump($similarity);
        foreach($similarity as $item){
            // var_dump($item);
            
            //check if data exist
            $idPenyakit = $item['id_penyakit'];
            $oldData = executeQuery($this->conn,"SELECT * FROM konsultasi_hasil WHERE id_konsultasi=$id_konsultasi AND id_penyakit=$idPenyakit");

            //data obat 
            $medicine = new DiseaseMedicine($this->conn);
            $dataMedicine = $medicine->getDiseaseMedicine($idPenyakit)->fetch(PDO::FETCH_ASSOC);
            $id_obat = $dataMedicine['id_obat'];
            $nilai = $item['nilai'];

            if($oldData->rowCount() == 0){
                // var_dump($oldData->rowCount() == 0);
                // var_dump("id_penyakit:".$idPenyakit);
                // var_dump("id_obat:".$id_obat);
                // var_dump("nilai:".$nilai);
                executeQuery($this->conn,"INSERT INTO konsultasi_hasil (id_konsultasi, id_obat, id_penyakit,status, nilai) 
                    VALUES ($id_konsultasi, $id_obat, $idPenyakit,1,$nilai)");
            }else{
                extract($oldData->fetch(PDO::FETCH_ASSOC));
                executeQuery($this->conn,"UPDATE konsultasi_hasil SET nilai='$nilai', status=1
                    WHERE id_konsultasi=$id_konsultasi AND id_obat=$id_obat AND id_penyakit=$id_penyakit'");
            }
        }
    }

}