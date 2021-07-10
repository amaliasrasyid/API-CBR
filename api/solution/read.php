<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/Solution.php';
include_once '../../helper/HttpResponseMessage.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$solution = new Solution($db);

//query
$stmt = $solution->getSolutions();
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Terapi Pengobatan berhasil diperoleh',
            'result' => array()
        );

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = array(
                'id_solusi' => $id_solusi,
                'kd_solusi' => $kd_solusi,
                'nm_solusi' => $nm_solusi,
                'keterangan' => $keterangan
            );
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
}else{
    http_response_code(204);
    echo json_encode(
        array(
            "message" => "Data Terapi Pengobatan kosong!",
            'code' => 204,
            'result' => array()
        )
    );
}