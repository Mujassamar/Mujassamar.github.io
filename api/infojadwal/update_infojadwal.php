<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/infojadwal.php';
    

        // get database connection
        $database = new Database();
        $db = $database->getConnection();
        
        // prepare infojadwal object
        $infojadwal = new Infojadwal($db);

        $data = $_POST['infojadwal'];
        $infojadwal->id_ready = $_POST['id_ready'];

        // set infojadwal property values
        $infojadwal->tgl_ready = $data['tgl_ready'];
        $infojadwal->nama_vaksin = $data['nama_vaksin'];
        $infojadwal->catatan = $data['catatan'];

        // update the infojadwal
        if($infojadwal->update()){
        
            // set response code - 200 ok
            http_response_code(201);
        
            // tell the user
            echo json_encode(array("message" => "infojadwal was updated."));
        }
        
        // if unable to update the infojadwal, tell the user
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
        
            // tell the user
            echo json_encode(array("message" => "Unable to update infojadwal."));
        }
    
?>