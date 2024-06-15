<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');
    
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/daftar.php';

    $database = new Database();
    $db = $database->getConnection();
        
    $daftar = new Daftar($db);

    $func_daftar = $_GET['func_daftar'];

    if ($func_daftar == "ambil_option_anak"){
        $option = $db->query("SELECT id_pendaftaran, nama_anak FROM daftar_imunisasi");
        echo "<option> PILIH NAMA ANAK </option>\n";
        while ($row = $option->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='". $row['id_pendaftaran']. "'>". $row['nama_anak']. "</option>\n";
        }
    }

    else if ($func_daftar == "ambil_single_data"){
        // set ID property of record to read
        $daftar->id_pendaftaran = isset($_GET['id_pendaftaran']) ? $_GET['id_pendaftaran'] : die();

        $daftar->read_one();

        if($daftar->id_pendaftaran != null){
            // create array
            $daftar_arr = array(
                "id_pendaftaran" =>  $daftar->id_pendaftaran,
                "nik_anak" =>  $daftar->nik_anak,
                "nama_anak" => $daftar->nama_anak,
                "tanggal_lahir_anak" => $daftar->tanggal_lahir_anak,
                "nama_ibu" => $daftar->nama_ibu,
                "no_hp" => $daftar->no_hp,
                "alamat" => $daftar->alamat

            );
        
            // set response code - 200 OK
            http_response_code(200);
        
            // make it json format
            echo json_encode($daftar_arr);
        } else {
            // set response code - 404 Not found
            http_response_code(404);
        
            // tell the user product does not exist
            echo json_encode(array("message" => "daftar does not exist."));
        }
    
    }
?>