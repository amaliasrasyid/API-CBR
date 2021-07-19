<?php
require_once '../../utils/HeaderTemplate.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$sympConsul = new SymptomConsultation($db);

//input
$idKonsultasi= isset($_POST['id_konsultasi']) ? $_POST['id_konsultasi'] : '';
$listIdGejala= isset($_POST['list_id_gejala']) ? $_POST['list_id_gejala'] : '';
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
            'message' => "input id gejala tidak boleh kosong",
            'code' => 404
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $sympConsul->update($idKonsultasi,$listIdGejala);

//response
if($stmt){
    if(http_response_code() == 200){
        echo json_encode(array(
            'code' => 200,
            'message' => 'Berhasil memperbarui konsultasi gejala',
            'result' => new stdClass()
        ));
    }
}else{
    http_response_code(409);
    echo json_encode(
        array(
            'message' => 'Gagal memperbarui konsultasi gejala',
            'code' => 409,
            'result' => new stdClass()
        )
    );
}