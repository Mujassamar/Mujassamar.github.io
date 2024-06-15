<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // include database and object file
    include_once '../config/database.php';
    include_once '../objects/infojadwal.php';
    
    $func_infojadwal = $_POST['func_infojadwal'];

    if ($func_infojadwal == "delete"){
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
        
        // prepare infojadwal object
        $infojadwal = new Infojadwal($db);
        
        // set infojadwal id to be deleted
        $infojadwal->id_ready = $_POST['id_ready'];
        
        // delete the infojadwal
        if($infojadwal->delete()){
        
            // set response code - 200 ok
            http_response_code(200);
        
            // tell the user
            echo json_encode(array("message" => "infojadwal was deleted."));
        }
        
        // if unable to delete the infojadwal
        else{
        
            // set response code - 503 service unavailable
            http_response_code(503);
        
            // tell the user
            echo json_encode(array("message" => "Unable to delete infojadwal."));
        }
    }
?>