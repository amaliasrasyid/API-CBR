<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//query params=
$idKonsultasi = isset($_POST['konsultasi']) ? $_POST['konsultasi'] : '';
$idsSelectedSymptomp = isset($_POST['id_gejala']) ? $_POST['id_gejala'] : '';

if($idKonsultasi == ''){
    echo json_encode(
        array(
        'message' => 'input id_konsultasi tidak boleh kosong',
        'code' => 404
        )
    );
    http_response_code(404);
    return;
}else if(empty($idsSelectedSymptomp)){
    echo json_encode(array(
        'message' => 'input id gejala tidak boleh kosong',
        'code'=> 404
    ));
    http_response_code(404);
    return;
}


// initialize object
$consulResult = new ConsultationResult($db);
$consulResult->consultResult($idKonsultasi,$idsSelectedSymptomp);
$stmt= $consulResult->getConsultResult($idKonsultasi);
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
            // var_dump($row);
            
            $disease = new disease();
            $disease->init($id_penyakit,$kd_penyakit,$nm_penyakit,$definisi);

            $medicine = new Medicine();
            $medicine->init($id_obat,$kd_obat,$nm_obat);


            $item = new ConsultationResult();
            $item->init($id_konsultasi_hasil,$disease,$medicine,$nilai,$status);
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