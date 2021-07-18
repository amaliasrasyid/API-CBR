<?php
require_once '../../utils/HeaderTemplate.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$sympConsul = new SymptomConsultation($db);

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idKonsultasi= $result['id_konsultasi'] ? $result['id_konsultasi'] : '';
$listIdGejala= $result['id_gejala'] ? $result['id_gejala'] : '';
if ($idKonsultasi == ''){
    echo json_encode(
        array(
            'message' => "input id konsultasi tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}else if(empty($listIdGejala)){
    echo json_encode(
        array(
            'message' => "input id gejala tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $sympConsul->delete($idKonsultasi,$listIdGejala);

//response
if($stmt->rowCount() != 0){
    if(http_response_code() == 200){
        echo json_encode(array(
            'code' => 200,
            'message' => 'Berhasil menghapus konsultasi gejala'
        ));
    }
}else{
    http_response_code(409);
    echo json_encode(
        array(
            'message' => 'Gagal menghapus konsultasi gejala',
            'code' => 409
        )
    );
}