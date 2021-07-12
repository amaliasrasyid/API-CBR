<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/ConsultationResult.php';
include_once '../../model/Kasus.php';
include_once '../../model/Disease.php';
include_once '../../helper/HttpResponseMessage.php';
include_once '../../helper/FormatNumber.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$consulResult = new ConsultationResult($db);
$consulResult->calculateResult(82);
$stmt = $consulResult->getConsultResult(82);
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data hasil konsultasi berhasil diperoleh',
            'result' => array()
        );
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $case = new Kasus();
            $case->init($id_kasus,$nama,$tanggal,$status);

            $disease = new Disease();
            $disease->init($id_penyakit,$kd_penyakit,$nm_penyakit,$definisi);

            $item = new ConsultationResult();
            $item->init($id_konsultasi_hasil,$case,$disease,$nilai,$status);
            array_push($response['result'], $item);
        }
        echo json_encode($response);
    }
}else{
    http_response_code(404);
    echo json_encode(
        array(
            'message' => 'Data hasil konsultasi tidak ditemukan',
            'code' => 404
        )
    );
}