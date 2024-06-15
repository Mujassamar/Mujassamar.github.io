<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/daftar.php';
    
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
        
        // prepare daftar object
        $daftar = new Daftar($db);

        $data = $_POST['daftar'];
        $daftar->id_pendaftaran = $_POST['id_pendaftaran'];

        // set daftar property values
        $daftar->nik_anak = $data['nik_anak'];
        $daftar->nama_anak = $data['nama_anak'];
        $daftar->tanggal_lahir_anak = $data['tanggal_lahir_anak'];
        $daftar->nama_ibu = $data['nama_ibu'];
        $daftar->no_hp = $data['no_hp'];
        $daftar->alamat = $data['alamat'];

        // update the daftar
        if($daftar->update()){
        
            // set response code - 200 ok
            http_response_code(201);
        
            // tell the user
            echo json_encode(array("message" => "daftar was updated."));
        }
        
        // if unable to update the daftar, tell the user
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
        
            // tell the user
            echo json_encode(array("message" => "Unable to update daftar."));
        }
    
?>