<?php
require_once '../../utils/HeaderTemplate.php';

//instantiate database
$dbConn = new DbConnection();
$db = $dbConn->getConnection();

//initialize object
$consultation = new Consultation($db);

//input
$namaKonsul = isset($_POST['nama_konsul']) ? $_POST['nama_konsul'] : '';
$tanggal = date('Y-m-d H:i:s');
if ($namaKonsul == ''){
    echo json_encode(
        array(
            'message' => "input nama tidak boleh kosong"
        )
    );
    http_response_code(404);
    return;
}

//query
$stmt = $consultation->create($namaKonsul,$tanggal);

//response
if($stmt){
    if(http_response_code() == 200){
        $response = array(
            'code' => 200,
            'message' => 'Berhasil membuat konsultasi',
            'result' => new stdClass()
        );
        //fetch last inserted data
        $stmt = $consultation->getLastCreatedConsultation();
        if($stmt->rowCount() > 0){
            extract($stmt->fetch(PDO::FETCH_ASSOC));
            $item = array(
                'id_konsultasi' => $id_konsultasi,
                'nama' => $nama,
                'tanggal' => convertToIndoDate($tanggal)
            );
            $response['result'] = $item;
        }
        echo json_encode($response);
    }
}else{
    http_response_code(409);
    echo json_encode(
        array(
            'message' => 'Gagal membuat konsultasi',
            'code' => 409,
            'result' => new stdClass()
        )
    );
}