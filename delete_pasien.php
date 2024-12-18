<?php
// Koneksi ke database
include('includes/db.php');

// Jika ID pasien tidak ditemukan, redirect ke halaman daftar pasien
if (!isset($_GET['id'])) {
    header("Location: pasien.php");
    exit;
}

$id_pasien = $_GET['id'];

// Hapus data pasien berdasarkan ID
$sql_delete = "DELETE FROM pasien WHERE id_pasien = $id_pasien";

if ($conn->query($sql_delete) === TRUE) {
    header("Location: pasien.php"); // Redirect setelah data berhasil dihapus
} else {
    echo "Error: " . $conn->error;
}

?>
