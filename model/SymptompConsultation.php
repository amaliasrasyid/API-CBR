<?php
class SymptomConsultation {
    //instance connection
    private $conn;

    //table name
    private $table_name = "cbr_konsultasi_gejala";

    //table column
    public $id_konsultasi_gejala;
    public $id_konsultasi;
    public $symptomp;
    public $status;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_konsultasi_gejala, $id_konsultasi,$symptomp,$status){
        $this->id_konsultasi_gejala = $id_konsultasi_gejala;
        $this->id_konsultasi = $id_konsultasi;
        $this->symptomp = $symptomp;
        $this->status = $status;
    }

    public function createOrUpdate($id_konsultasi,$list_id_gejala){
        // var_dump($list_id_gejala);
        $itemCount = count($list_id_gejala);
        
        for($i = 0; $i < $itemCount; $i++){
            if($this->isSameDataExist($id_konsultasi,$list_id_gejala[$i])){
                $stmt = $this->update($id_konsultasi,$list_id_gejala[$i]);
            }else{
                $query = "INSERT INTO cbr_konsultasi_gejala (id_konsultasi, id_gejala, status) VALUES ('$id_konsultasi', '$list_id_gejala[$i]', 1)";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
            }
        }
        return $stmt;
    }

    public function update($id_konsultasi,$list_id_gejala){
        $itemCount = count($list_id_gejala);
        // var_dump("proses update :".$itemCount);
        for($i = 0; $i < $itemCount; $i++){
            $query = "UPDATE cbr_konsultasi_gejala SET status=1 WHERE id_konsultasi='$id_konsultasi' AND id_gejala='$list_id_gejala[$i]";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        }
        return $stmt;
    }

    private function isSameDataExist($id_konsultasi,$id_gejala){
        $query = "SELECT kg.id_konsultasi, kg.id_gejala FROM cbr_konsultasi_gejala as kg WHERE id_konsultasi = $id_konsultasi AND id_gejala = $id_gejala";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // var_dump("data exist = ".$stmt->rowCount());
        // var_dump($stmt->rowCount() != 0 ? true : false);
        return $stmt->rowCount() != 0 ? true : false;
    }

    public function getSymptompConsultation($id_konsultasi){
        $query = "SELECT a.*,b.id_konsultasi, c.*, d.id_gejala_kategori
                FROM cbr_konsultasi_gejala a, cbr_konsultasi b, cbr_gejala c, cbr_gejala_kategori d
                WHERE a.id_konsultasi = b.id_konsultasi AND 
                a.id_gejala = c.id_gejala AND 
                c.id_gejala_kategori = d.id_gejala_kategori AND
                a.id_konsultasi =$id_konsultasi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id_konsultasi){
        $state = false;
        $deleteResult = $this->executeQuery("DELETE FROM cbr_konsultasi_hasil WHERE cbr_konsultasi_hasil.id_konsultasi = $id_konsultasi");

        if($deleteResult->rowCount() != 0){
            $deleteSymptomp = $this->executeQuery("DELETE FROM cbr_konsultasi_gejala WHERE cbr_konsultasi_gejala.id_konsultasi = $id_konsultasi");
            if($deleteSymptomp->rowCount() != 0){
                $state = true;
            }  
        }
        return $state;
    }

    private function executeQuery($query){
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}