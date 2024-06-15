<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siimun";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$status = $_POST['status'];
if ($status !== 'buka' && $status !== 'tutup') {
    echo "Nilai status tidak valid";
    $conn->close();
    exit();
}

// Perbarui status yang aktif dan non-aktif
if ($status === 'buka') {
    $conn->query("UPDATE switch_status SET status='tutup' WHERE id=1");
    $conn->query("UPDATE switch_status SET status='buka' WHERE id=2");
} else {
    $conn->query("UPDATE switch_status SET status='tutup' WHERE id=2");
    $conn->query("UPDATE switch_status SET status='buka' WHERE id=1");
}

echo "Status berhasil diperbarui menjadi $status";
$conn->close();
?>
