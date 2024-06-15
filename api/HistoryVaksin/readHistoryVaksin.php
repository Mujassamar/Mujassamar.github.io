<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database
include_once '../config/database.php';
include_once '../objects/history.php';

// Instantiate database and history object
$database = new Database();
$db = $database->getConnection();

$history = new History($db);

$id_pendaftaran = isset($_GET['id_pendaftaran']) ? $_GET['id_pendaftaran'] : "";    
$history->id_pendaftaran = $id_pendaftaran;

$stmt = $history->readHistory();
$num = $stmt->rowCount();

// Check if more than 0 record found
if($num > 0) {
    $history_arr = array();
    $history_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $history_item = array(
            "tgl_imunisasi" => $tgl_imunisasi,
            "id_vaksin" => $id_vaksin,
            "nama_vaksin" => $nama_vaksin
        );

        array_push($history_arr["records"], $history_item);
    }

    http_response_code(200);
    echo json_encode($history_arr);
} else {
    http_response_code(404); // Mengubah status code menjadi 404 untuk tidak ditemukan
    echo json_encode(
        array("message" => "No history found.")
    );
}
?>
