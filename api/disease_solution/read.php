<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/Solution.php';
include_once '../../model/Disease.php';
include_once '../../model/DiseaseSolution.php';
include_once '../../helper/HttpResponseMessage.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$dsSolution = new DiseaseSolution($db);

//input
$idPenyakit = isset($_POST['id_penyakit']) ? $_POST['id_penyakit'] :  0 ;
// var_dump($_POST['id_penyakit']);
if($idPenyakit == 0){
    echo json_encode(
        array(
            'message' => "input id_penyakit tidak boleh kosong"
        )
    );
    return;
}

//query
$stmt = $dsSolution->getDiseaseSolutions($idPenyakit);
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Terapi Pengobatan berhasil diperoleh',
            'result' => array()
        );
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //moving each var that have been extracted into object DiseaseSolution
            $disease = new Disease();
            $disease->init($id_penyakit,$kd_penyakit,$nm_penyakit,$definisi);

            $solution = new Solution();
            $solution->init($id_solusi,$kd_solusi,$nm_solusi,$keterangan);

            $dsSolution->init($id_penyakit_solusi,$disease,$solution);
            array_push($response['result'],$dsSolution);
        }
        echo json_encode($response);
    }else{
        echo json_encode(
            array(
                'code' => http_response_code(),
                'message' => getHttpMessage(http_response_code()),
                'result' => array()
            )
        );
    }
}else{
    http_response_code(404);
    echo json_encode(
        array(
            'message' => "Data Solusi Penyakit tidak ditemukan!",
            'code' => 404,
            'result' => array()
        )
    );
}