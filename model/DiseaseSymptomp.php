<?php
require_once '../../utils/HeaderTemplate.php';

class DiseaseSymptomp{
    //instance connection
    private $conn;

    //table column
    public $id_gejala_penyakit;
    public $id_penyakit;
    public $id_gejala;

    public function __construct($connection = null)
    {
        $this->conn = $connection;
    }

    public function init($id_gejala_penyakit,$id_penyakit,$id_gejala){
        $this->id_gejala_penyakit = $id_gejala_penyakit;
        $this->id_penyakit = $id_penyakit;
        $this->id_gejala = $id_gejala;
    }

    private function getDiseaseSymptomps(){
        $query = "SELECT * FROM gejala_penyakit";
        return executeQuery($this->conn,$query);
    }

    /** purpose : hitung jumlah duplikasi data penyakit
     * return : id_penyakit, jumlah data gejala yg dimiliki
     */
    private function countDuplicateDisease(){
        $query = "SELECT id_penyakit, COUNT(*) as jumlah from gejala_penyakit GROUP BY id_penyakit";
        return executeQuery($this->conn,$query);
    }

    private function diseaseSymptomps(){
        $result = array();
        $diseaseSymptomps = $this->getDiseaseSymptomps();
        while($row = $diseaseSymptomps->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = array(
                'id_gejala_penyakit' => $id_gejala_penyakit,
                'id_penyakit' => $id_penyakit,
                'id_gejala' => $id_gejala
            );
            array_push($result,$item);
        }
        return $result;
    }

    private function calculateSimilarity($dataFromUser){
        $result = array();

        foreach ($dataFromUser as $index => $value) {
            $dataRule = $this->countDuplicateDisease();
            // var_dump($value);
            while($row = $dataRule->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                // var_dump($row);
                // var_dump("index name: ".$index);
                // var_dump("id_penyakit: ".$id_penyakit);
                // var_dump($index == $id_penyakit);
                if($index == $id_penyakit){
                    $calculate = ($value/$jumlah) * 100;
                    $item = array(
                        'id_penyakit' => $id_penyakit,
                        'nilai' => $calculate
                    );
                    array_push($result,$item);
                }
            }
        } 
        return $result;
    }

    public function calculateDiseaseSymp($listGejala){
        $diseasesSymptomps = $this->diseaseSymptomps();
        // var_dump($diseasesSymptomps);

        //initialization to save the result
        $listPenyakit = array();

        foreach ($listGejala as $idGejala) {
            foreach($diseasesSymptomps as $gejalaPenyakit){
                // var_dump($gejalaPenyakit);
                if($idGejala === $gejalaPenyakit['id_gejala']){
                    array_push($listPenyakit,$gejalaPenyakit['id_penyakit']);
                }
            }
        }
        //remove duplication and count the number of same value
        $listPenyakit = array_count_values($listPenyakit);
        // var_dump($listPenyakit);
        return $this->calculateSimilarity($listPenyakit);
    }
    
}