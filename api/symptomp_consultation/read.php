<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/Consultation.php';
include_once '../../model/Symptomp.php';
include_once '../../model/SymptompConsultation.php';
include_once '../../model/SymptompCategory.php';
include_once '../../helper/HttpResponseMessage.php';
include_once '../../helper/IndonesianDate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$sympConsul = new SymptomConsultation($db);

//input
$idKonsultasi= isset($_POST['id_konsultasi']) ? $_POST['id_konsultasi'] : '';
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
            $consultation = new Consultation();
            $consultation->init($id_konsultasi,$nama,$tanggal);

            $sympCategory = new SymptompCategory();
            $sympCategory->init($id_gejala_kategori,$gejala_kategori,$keterangan);

            $symptomp = new Symptomp();
            $symptomp->init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$keterangan,$sympCategory);

            $sympConsul->init($id_konsultasi_gejala, $consultation,$symptomp,$status);
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