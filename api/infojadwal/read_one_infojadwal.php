<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
    
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/infojadwal.php';

    $database = new Database();
    $db = $database->getConnection();
        
    $infojadwal = new Infojadwal($db);

    $func_infojadwal = $_GET['func_infojadwal'];

    if ($func_infojadwal == "ambil_option_vaksin"){
        $option = $db->query("SELECT id_vaksin, nama_vaksin FROM ref_vaksin");
        echo "<option> PILIH NAMA VAKSIN </option>\n";
        while ($row = $option->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='". $row['id_vaksin']. "'>". $row['nama_vaksin']. "</option>\n";
        }
    }

    else if ($func_infojadwal == "ambil_single_data"){
        // set ID property of record to read
        $infojadwal->id_ready = isset($_GET['id_ready']) ? $_GET['id_ready'] : die();

        $infojadwal->read_one();

        if($infojadwal->tgl_ready != null){
            // create array
            $infojadwal_arr = array(
                "id_ready" =>  $infojadwal->id_ready,
                "tgl_ready" => $infojadwal->tgl_ready,
                "nama_vaksin" => $infojadwal->nama_vaksin,
                "catatan" => $infojadwal->catatan
            );
        
            // set response code - 200 OK
            http_response_code(200);
        
            // make it json format
            echo json_encode($infojadwal_arr);
        } else {
            // set response code - 404 Not found
            http_response_code(404);
        
            // tell the user product does not exist
            echo json_encode(array("message" => "infojadwal does not exist."));
        }
    
    }
?>