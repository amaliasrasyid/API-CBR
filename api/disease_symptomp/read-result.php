<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//input
$idsSelectedSymptomp = isset($_POST['id_gejala']) ? $_POST['id_gejala'] : '';
if(empty($idsSelectedSymptomp)){
    echo json_encode(array(
        'message' => 'input id gejala tidak boleh kosong',
        'code'=> 404
    ));
    http_response_code(404);
    return;
}

// initialize object
$diseaseSymptomps = new DiseaseSymptomp($db);


//query
$stmt = $diseaseSymptomps->calculateDiseaseSymp($idsSelectedSymptomp);
$itemCount = count($stmt);

// response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Gejala Penyakit berhasil diperoleh',
            'result' => array()
        );
        foreach($stmt as $item){
            array_push($response['result'],$item);
        }
        echo json_encode($response);
    }else{
        echo json_encode(
            array(
                "message" => getHttpMessage(http_response_code()),
                'code' => http_response_code(),
                'result' => array()
            )
        );
    }     
}
else{
    http_response_code(204);
    echo json_encode(
        array(
            "message" => "Data Gejala Penyakit kosong!",
            'code' => 204,
            'result' => array()
        )
    );
}