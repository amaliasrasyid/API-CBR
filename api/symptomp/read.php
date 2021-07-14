<?php
require_once '../../utils/HeaderTemplate.php';

$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$symptomp = new Symptomp($db);

//query params
$queryParam = parse_url($_SERVER['QUERY_STRING']);
parse_str($queryParam['path'],$result);
$idKategoriGejala = $result['id'] ? $result['id'] :  0 ;
// var_dump($_POST['id_kategori_gejala']);
if($idKategoriGejala == 0){
    echo json_encode(
        array(
            'message' => "input id_penyakit tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $symptomp->getSymptompByCategory($idKategoriGejala);
$itemCount = $stmt->rowCount();

//response
if($itemCount > 0){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Data gejala berdasarkan kategorinya ('.$idKategoriGejala.') berhasil diperoleh!',
            'result' => array()
        );
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            
            $sympCategory = new SymptompCategory();
            $sympCategory->init($id_gejala_kategori,$gejala_kategori,$keterangan);

            $item = new Symptomp();
            $item->init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$sympCategory);
            array_push($response['result'],$item);
        }
        echo json_encode($response);
    }
}else{
    http_response_code(404);
    echo json_encode(
        array(
            'message' => 'Data Gejala berdasarkan kategorinya ('.$idKategoriGejala.') tidak ditemukan!',
            'code' => 404,
            'result' => array()
        )
    );
}