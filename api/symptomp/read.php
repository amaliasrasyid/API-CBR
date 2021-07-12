<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database,helper, and object files
include_once '../../config/DbConnection.php';
include_once '../../model/Symptomp.php';
include_once '../../model/SymptompCategory.php';
include_once '../../helper/HttpResponseMessage.php';

// instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$symptomp = new Symptomp($db);

//input
$idKategoriGejala = isset($_POST['id_kategori_gejala']) ? $_POST['id_kategori_gejala'] : 0;
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
            //storing data category in an object
            $sympCategory = new SymptompCategory();
            $sympCategory->init($id_gejala_kategori,$gejala_kategori,$keterangan);
            
            $item = new Symptomp();
            $item->init($id_gejala,$kd_gejala,$nm_gejala,$bobot_parameter,$keterangan,$sympCategory);
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