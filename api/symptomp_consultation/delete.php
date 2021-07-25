<?php
require_once '../../utils/HeaderTemplate.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$sympConsul = new SymptomConsultation($db);

//get path
$requestUri = $_SERVER['REQUEST_URI'];
// $sgs = parse_url($queryParam,);
// var_dump($requestUri);

$path = substr($requestUri,38);
// var_dump($path);

$idKonsultasi = $path ?: '';
// var_dump($idKonsultasi);
if ($idKonsultasi == ''){
    echo json_encode(
        array(
            'message' => "input id konsultasi tidak boleh kosong",
            'code' => 404
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $sympConsul->delete($idKonsultasi);

//response
if($stmt){
    if(http_response_code() == 200){
        echo json_encode(array(
            'code' => 200,
            'message' => 'Berhasil menghapus data gejala dan hasil konsultasi'
        ));
    }
}else{
    http_response_code(409);
    echo json_encode(
        array(
            'message' => 'Gagal menghapus data gejala konsultasi atau data hasil konsultasi',
            'code' => 409
        )
    );
}