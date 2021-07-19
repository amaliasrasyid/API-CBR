<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$dsSolution = new DiseaseSolution($db);

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idPenyakit = $result['id'] ? $result['id'] :  0 ;
// var_dump($queryParam['path']);
if($idPenyakit == 0){
    echo json_encode(
        array(
            'message' => "input id_penyakit tidak boleh kosong",
            'code' => 404
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $dsSolution->getDiseaseSolutions($idPenyakit);
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data detail penyakit berhasil diperoleh',
            'result' => array()
        );
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //moving each var that have been extracted into object DiseaseSolution

            $solution = new Solution();
            $solution->init($id_solusi,$kd_solusi,$nm_solusi,$keterangan);

            $dsSolution = new DiseaseSolution();
            $dsSolution->init($id_penyakit_solusi,$id_penyakit,$solution);
            array_push($response['result'],$dsSolution);
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
            'message' => "Data detail Penyakit tidak ditemukan!",
            'code' => 404,
            'result' => array()
        )
    );
}