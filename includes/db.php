<?php
$host = "localhost"; // Sesuaikan dengan host Anda
$username = "root";  // Username MySQL
$password = "";      // Password MySQL
$database = "db_antriklinik"; // Nama database

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
