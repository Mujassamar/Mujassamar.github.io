<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    

    include_once '../config/database.php';
    include_once '../objects/infojadwal.php';


    $database = new Database();
    $db = $database->getConnection();
        
    $infojadwal = new Infojadwal($db);

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $func_infojadwal = $_GET['func_infojadwal'];
        if ($func_infojadwal == "ambil_option_vaksin"){
            $option = $db->query("SELECT id_vaksin, nama_vaksin FROM ref_vaksin");
            echo "<option> PILIH NAMA VAKSIN </option>\n";
            while ($row = $option->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='". $row['id_vaksin']. "'>". $row['nama_vaksin'] . "</option>\n";
            }
        }
    }

    else {
        // get posted data
        $data = $_POST['infojadwal'];
        
        // make sure data is not empty
        if(
            !empty($data['tgl_ready']) &&
            !empty($data['catatan'])
        ){
        
            // set product property values
            $infojadwal->tgl_ready = $data['tgl_ready'];
            $infojadwal->catatan = $data['catatan'];
            $infojadwal->nama_vaksin = $data['nama_vaksin'];
            
        
            // create the infojadwal
            if($infojadwal->create()){
        
                // set response code - 201 created
                http_response_code(201);
        
                // tell the user
                echo json_encode(array("message" => "infojadwal was created."));
                
            }
        
            // if unable to create the infojadwal, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(503);
        
                // tell the user
                echo json_encode(array("message" => "Unable to create infojadwal."));
            }
        }
        
        // tell the user data is incomplete
        else{
        
            // set response code - 400 bad request
            http_response_code(400);
        
            // tell the user
            echo json_encode(array("message" => "Unable to create infojadwal. Data is incomplete."));
        }
    } 
    
?>