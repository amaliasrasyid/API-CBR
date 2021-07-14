<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$disease = new Disease($db);

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idPenyakit = $result['id'] ? $result['id'] :  0 ;

// var_dump($url);
// var_dump($result['id']);
if($idPenyakit == 0){
    echo json_encode(
        array(
            'message' => "input id_penyakit tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $disease->getDiseasesById($idPenyakit);
$itemCount = $stmt->rowCount();


//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Penyakit berhasil diperoleh',
            'result' => new stdClass
        );

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $disease->init($id_penyakit,$kd_penyakit,$nm_penyakit,$definisi);
            // var_dump($item);
             $response['result']=$disease;
        }
        echo json_encode($response);
    }else{
        echo json_encode(
            array(
                "message" => getHttpMessage(http_response_code()),
                'code' => http_response_code()
            )
        );
    }     
}
else{
    http_response_code(404);
    echo json_encode(
        array(
            "message" => "Data Penyakit tidak ditemukan!",
            'code' => 404
        )
    );
}