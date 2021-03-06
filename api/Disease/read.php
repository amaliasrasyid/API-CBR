<?php
require_once '../../utils/HeaderTemplate.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

// initialize object
$diseases = new Disease($db);

//query
$stmt = $diseases->getDiseases();
$itemCount = $stmt->rowCount();


//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data Penyakit berhasil diperoleh',
            'result' => array()
        );

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = array(
                'id_penyakit' => $id_penyakit,
                'kd_penyakit' => $kd_penyakit,
                'nm_penyakit' => $nm_penyakit,
                'definisi' => removeHtmlTags($definisi)
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
}
else{
    http_response_code(204);
    echo json_encode(
        array(
            "message" => "Data Penyakit kosong!",
            'code' => 204,
            'result' => array()
        )
    );
}