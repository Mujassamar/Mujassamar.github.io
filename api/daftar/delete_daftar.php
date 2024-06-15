<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include database and object file
    include_once '../config/database.php';
    include_once '../objects/daftar.php';
    
    $func_daftar = $_POST['func_daftar'];

    if ($func_daftar == "delete"){
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
        
        // prepare daftar object
        $daftar = new daftar($db);
        
        // set daftar id to be deleted
        $daftar->id_pendaftaran = $_POST['id_pendaftaran'];
        
        // delete the vaksin
        if($daftar->delete()){
        
            // set response code - 200 ok
            http_response_code(200);
        
            // tell the user
            echo json_encode(array("message" => "vaksin was deleted."));
        }
        
        // if unable to delete the vaksin
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
        
            // tell the user
            echo json_encode(array("message" => "Unable to delete vaksin."));
        }
    }
?>