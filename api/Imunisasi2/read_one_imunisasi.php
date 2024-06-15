<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/imunisasi.php';

$database = new Database();
$db = $database->getConnection();

$imunisasi = new Imunisasi($db);

// Ambil nilai func_imunisasi dari parameter GET
$func_imunisasi = isset($_GET['func_imunisasi']) ? $_GET['func_imunisasi'] : die();

// Cek nilai func_imunisasi dan jalankan aksi yang sesuai
if ($func_imunisasi == "ambil_option_anak"){
    $option = $db->query("SELECT id_pendaftaran, nama_anak FROM daftar_imunisasi");
    echo "<option> PILIH NAMA ANAK </option>\n";
    while ($row = $option->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='". $row['id_pendaftaran']. "'>". $row['nama_anak']. "</option>\n";
    }
}

else if ($func_imunisasi == "ambil_option_vaksin"){
    $option = $db->query("SELECT id_vaksin, nama_vaksin FROM ref_vaksin");
    echo "<option> PILIH NAMA VAKSIN </option>\n";
    while ($row = $option->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='". $row['id_vaksin']. "'>". $row['nama_vaksin']. "</option>\n";
    }
    
} else if ($func_imunisasi == "ambil_single_data"){
    // Pastikan id_imunisasi diberikan
    $imunisasi->id_imunisasi = isset($_GET['id_imunisasi']) ? $_GET['id_imunisasi'] : die();

    // Ambil data satu baris berdasarkan id_imunisasi
    $imunisasi->read_one();

    // Jika data ditemukan
    if($imunisasi->id_imunisasi != null){
        // Buat array untuk menyimpan data imunisasi
        $imunisasi_arr = array(
            "id_imunisasi" =>  $imunisasi->id_imunisasi,
            "tgl_imunisasi" =>  $imunisasi->tgl_imunisasi,
            "usia_saat_vaksin" => $imunisasi->usia_saat_vaksin,
            "tinggi_badan" => $imunisasi->tinggi_badan,
            "berat_badan" => $imunisasi->berat_badan,
            "nama_ibu" => $imunisasi->nama_ibu,
            "nama_vaksin" => $imunisasi->nama_vaksin,
            "nama_anak" => $imunisasi->nama_anak
        );

        // Set response code - 200 OK
        http_response_code(200);

        // Return data as JSON
        echo json_encode($imunisasi_arr);
    } else {
        // Jika data tidak ditemukan, set response code - 404 Not found
        http_response_code(404);

        // Beri pesan kepada pengguna bahwa data imunisasi tidak ditemukan
        echo json_encode(array("message" => "Data imunisasi tidak ditemukan."));
    }
}
?>