<?php
class ConsultationResult{
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_konsultasi_hasil";
 
    //table column
    public $id_konsultasi_hasil;
    public $case;
    public $disease;
    public $nilai;
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

    public function calculateResult($id_konsultasi){
        // $updateConsul = $this->executeQuery("UPDATE cbr_konsultasi_hasil SET status=0 WHERE id_konsultasi=$id_konsultasi");
        $listCase = $this->executeQuery("SELECT a.id_kasus, a.nama, a.id_penyakit, a.tanggal, a.status, b.kd_penyakit, b.nm_penyakit  
                    FROM cbr_kasus as a, cbr_penyakit as b WHERE a.id_penyakit=b.id_penyakit AND a.status=1");
        while($row = $listCase->fetch(PDO::FETCH_ASSOC)){
            //Hitung nilai total kesamaan gejala pasien dengan kasus
            extract($row);
            $qDataPatient = $this->executeQuery("SELECT SUM(c.bobot_parameter) as jml_1
                            FROM cbr_kasus as a, cbr_kasus_gejala as b, cbr_gejala as c, cbr_konsultasi_gejala as d
                            WHERE a.id_kasus=b.id_kasus AND b.id_gejala=c.id_gejala AND b.id_gejala=d.id_gejala 
                            AND d.id_konsultasi=$id_konsultasi AND a.id_kasus=$id_kasus AND d.status=1");
            $qDataCase = $this->executeQuery("SELECT SUM(c.bobot_parameter) as jml_2
                            FROM cbr_kasus as a, cbr_kasus_gejala as b, cbr_gejala as c
                            WHERE a.id_kasus=b.id_kasus AND b.id_gejala=c.id_gejala AND a.id_kasus=$id_kasus");
            //extract data
            extract($qDataPatient->fetch(PDO::FETCH_ASSOC));
            extract($qDataCase->fetch(PDO::FETCH_ASSOC));
            $hasil = 0;
            if($jml_2 > 0){
                $hasil = $jml_1/$jml_2;
            }
            if($hasil > 0){
                //check if data exist
                $oldData = $this->executeQuery("SELECT id_konsultasi, id_kasus, nilai FROM cbr_konsultasi_hasil WHERE id_konsultasi=$id_konsultasi AND id_penyakit=$id_penyakit");
                if($oldData->rowCount() == 0){
                    $this->executeQuery("INSERT INTO cbr_konsultasi_hasil (id_konsultasi, id_kasus, id_penyakit, nilai, status) 
                        VALUES ($id_konsultasi, $id_kasus, $id_penyakit, $hasil, 1)");
                }else{
                    extract($oldData->fetch(PDO::FETCH_ASSOC));
                    if($id_kasus == $row['id_kasus']){
                        $this->executeQuery("UPDATE cbr_konsultasi_hasil SET nilai='$hasil', status=1
                            WHERE id_konsultasi=$id_konsultasi AND id_kasus=$id_kasus AND id_penyakit=$id_penyakit'");
                    }else if($nilai < $hasil){
                        $this->executeQuery("UPDATE cbr_konsultasi_hasil SET nilai='$hasil', id_kasus=$d_kasus[id_kasus], status=1
                            WHERE id_konsultasi=$id_konsultasi AND id_kasus=$id_kasus AND id_penyakit=$id_penyakit");
                    }
                }
            }

        }
    }

    public function getConsultResult($id_konsultasi){
        return $this->executeQuery("SELECT b.id_konsultasi_hasil, a.*, c.*, b.nilai
        FROM cbr_kasus as a, cbr_konsultasi_hasil as b, cbr_penyakit as c
        WHERE a.id_kasus=b.id_kasus AND b.id_penyakit=c.id_penyakit AND b.id_konsultasi=$id_konsultasi
            AND b.status=1
        ORDER BY b.nilai DESC");

    }

    private function executeQuery($query){
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}