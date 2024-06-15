<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "siimun";

    $conn = mysqli_connect($host, $user, $pass, $dbname);

    if (!$conn){
        echo "Database tidak terhubung";
    }

// Mengambil status
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT status FROM website_status WHERE id = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => $row['status']]);
    } else {
        echo json_encode(['status' => 'closed']);
    }
}

// Memperbarui status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $status = $input['status'];

    $sql = "UPDATE website_status SET status = '$status' WHERE id = 1";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => $status]);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

$conn->close();
?>