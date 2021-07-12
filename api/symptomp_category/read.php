<?php
require_once '../../config/HeaderTemplate.php';

// instantiate database
$dbConn = New DbConnection();
$db = $dbConn->getConnection();

//query
$sympCategory = new SymptompCategory($db);
$stmt = $sympCategory->getSymptompCategory();
$itemCount = $stmt->rowCount();

//resposen
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data kategori gejala berhasil diperoleh',
            'result' => array()
        );

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $item = array(
                'id_gejala_kategori' => $id_gejala_kategori,
                'gejala_kategori' => $gejala_kategori,
                'keterangan' => $keterangan
            );
            array_push($response['result'],$item);
        }
        echo json_encode($response);
    }else {
        echo json_encode(
            array(
                'message' => getHttpMessage(http_response_code()),
                'code' => http_response_code(),
                'result' => array()
            )
        );
    }
}else{
    http_response_code(204);
    echo json_encode(
        array(
            'message' => "Data kategori penyakit kosong!",
            'code' => 204,
            'result' => array()
        )
    );
}