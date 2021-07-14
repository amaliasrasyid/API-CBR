<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$sympConsul = new SymptomConsultation($db);

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idKonsultasi = $result['id'] ? $result['id'] :  0 ;
if($idKonsultasi == ''){
    echo json_encode(
        array(
            'message' => "input id konsultasi tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $sympConsul->getSymptompConsultation($idKonsultasi);
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Gejala konsultasi berhasil diperoleh',
            'result' => array()
        );
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //storing each var that have been extracted into each object 

            $symptomp = new Symptomp();
            $symptomp->init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$id_gejala_kategori);

            $sympConsul->init($id_konsultasi_gejala, $id_konsultasi,$symptomp,$status);
            array_push($response['result'],$sympConsul);
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
            'message' => "Data gejala konsultasi tidak ditemukan!",
            'code' => 404,
            'result' => array()
        )
    );
}