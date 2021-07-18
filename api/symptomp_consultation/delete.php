<?php
require_once '../../utils/HeaderTemplate.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$sympConsul = new SymptomConsultation($db);

//query params
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
            'message' => "input id gejala tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $sympConsul->delete($idKonsultasi,$listIdGejala);

// var_dump($stmt->rowCount());
//response
//jika ada 1 data yg tidak terhapus karena suatu sebab, tetap mengembalikan 0 meski yg lain berhasil. hanya 1 jika semuanya 'sukses'
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