<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    

    include_once '../config/database.php';
    include_once '../objects/imunisasi.php';


    $database = new Database();
    $db = $database->getConnection();
        
    $imunisasi = new Imunisasi($db);

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $func_imunisasi = $_GET['func_imunisasi'];
        if ($func_imunisasi == "ambil_option_anak"){
            $option = $db->query("SELECT id_pendaftaran, nama_anak FROM daftar_imunisasi");
            echo "<option> PILIH NAMA ANAK </option>\n";
            while ($row = $option->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='". $row['id_pendaftaran'].  "'>". $row['nama_anak'] . "</option>\n";
            }
        }
    
        else if ($func_imunisasi == "ambil_option_vaksin"){
            $option = $db->query("SELECT id_vaksin, nama_vaksin FROM ref_vaksin");
            echo "<option> PILIH NAMA VAKSIN </option>\n";
            while ($row = $option->fetch(PDO::FETCH_ASSOC)){
                echo "<option value='". $row['id_vaksin']. "'>". $row['nama_vaksin'] . "</option>\n";
            }
        }
    }

    else {
        // get posted data
        $data = $_POST['imunisasi'];
        
        // make sure data is not empty
        if(
            !empty($data['tgl_imunisasi']) &&
            !empty($data['usia_saat_vaksin']) &&
            !empty($data['tinggi_badan']) && 
            !empty($data['berat_badan'])
        ){
        
            // set product property values
            $imunisasi->tgl_imunisasi = $data['tgl_imunisasi'];
            $imunisasi->usia_saat_vaksin = $data['usia_saat_vaksin'];
            $imunisasi->tinggi_badan = $data['tinggi_badan'];
            $imunisasi->berat_badan = $data['berat_badan'];
            // $imunisasi->nama_ibu = $data['nama_ibu'];
            $imunisasi->nama_anak = isset($data['nama_anak']) ? $data['nama_anak'] : "";
            $imunisasi->nama_vaksin = $data['nama_vaksin'];
            
        
            // create the imunisasi
            if($imunisasi->create()){
        
                // set response code - 201 created
                http_response_code(201);
        
                // tell the user
                echo json_encode(array("message" => "imunisasi was created."));
                
            }
        
            // if unable to create the imunisasi, tell the user
            else{
        
                // set response code - 503 service unavailable
                http_response_code(503);
        
                // tell the user
                echo json_encode(array("message" => "Unable to create imunisasi."));
            }
        }
        
        // tell the user data is incomplete
        else{
        
            // set response code - 400 bad request
            http_response_code(400);
        
            // tell the user
            echo json_encode(array("message" => "Unable to create imunisasi. Data is incomplete."));
        }
    } 
    
?>

