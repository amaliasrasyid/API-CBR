<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idKonsultasi = $result['konsultasi'] ? $result['konsultasi'] : '';

if($idKonsultasi == 0){
    echo json_encode(
        array(
        'message' => 'input id_konsultasi tidak boleh kosong',
        'code' => 404
        )
    );
    http_response_code(404);
    return;
}


// initialize object
$consulResult = new ConsultationResult($db);
$consulResult->calculateResult($idKonsultasi);
$stmt = $consulResult->getConsultResult($idKonsultasi);
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
            $disease->init($id_penyakit,$kd_penyakit,$nm_penyakit,removeHtmlTags($definisi));

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