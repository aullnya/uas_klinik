<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_antriklinik";

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menambahkan data antrian
if (isset($_POST['submit'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $id_layanan = $_POST['id_layanan'];
    $status_antrian = $_POST['status_antrian'];

    // Validasi foreign key
    $cek_pasien = $conn->query("SELECT id_pasien FROM pasien WHERE id_pasien = '$id_pasien'");
    $cek_dokter = $conn->query("SELECT id_dokter FROM dokter WHERE id_dokter = '$id_dokter'");
    $cek_layanan = $conn->query("SELECT id_layanan FROM layanan WHERE id_layanan = '$id_layanan'");

    if ($cek_pasien->num_rows == 0) {
        echo "<script>alert('Error: ID Pasien tidak ditemukan di database.'); window.location='antrian.php';</script>";
    } elseif ($cek_dokter->num_rows == 0) {
        echo "<script>alert('Error: ID Dokter tidak ditemukan di database.'); window.location='antrian.php';</script>";
    } elseif ($cek_layanan->num_rows == 0) {
        echo "<script>alert('Error: ID Layanan tidak ditemukan di database.'); window.location='antrian.php';</script>";
    } else {
        // Jika semua valid, jalankan INSERT
        $sql_insert = "INSERT INTO antrian (id_pasien, id_dokter, id_layanan, status_antrian, waktu_antri) 
                       VALUES ('$id_pasien', '$id_dokter', '$id_layanan', '$status_antrian', NOW())";
        if ($conn->query($sql_insert) === TRUE) {
            header("Location: antrian.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Mengambil data antrian
$sql = "SELECT * FROM antrian";
$result = $conn->query($sql);

// Mengambil data pasien untuk dropdown
$sql_pasien = "SELECT id_pasien, nama FROM pasien";
$result_pasien = $conn->query($sql_pasien);

// Mengambil data dokter untuk dropdown (pastikan kolom yang digunakan benar)
$sql_dokter = "SELECT id_dokter, nama FROM dokter";  // Ganti nama_dokter dengan nama yang benar
$result_dokter = $conn->query($sql_dokter);

// Mengambil data layanan untuk dropdown
$sql_layanan = "SELECT id_layanan, nama_layanan FROM layanan";
$result_layanan = $conn->query($sql_layanan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Data Antrian</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Antrian</button>

        <!-- Modal untuk menambahkan antrian -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Antrian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="antrian.php">
                            <div class="mb-3">
                                <label for="id_pasien" class="form-label">ID Pasien</label>
                                <select class="form-control" id="id_pasien" name="id_pasien" required>
                                    <option value="">Pilih Pasien</option>
                                    <?php
                                    // Menampilkan pasien yang ada dalam dropdown
                                    while ($row_pasien = $result_pasien->fetch_assoc()) {
                                        echo "<option value='".$row_pasien['id_pasien']."'>".$row_pasien['id_pasien']." - ".$row_pasien['nama']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_dokter" class="form-label">ID Dokter</label>
                                <select class="form-control" id="id_dokter" name="id_dokter" required>
                                    <option value="">Pilih Dokter</option>
                                    <?php
                                    // Menampilkan dokter yang ada dalam dropdown
                                    while ($row_dokter = $result_dokter->fetch_assoc()) {
                                        echo "<option value='".$row_dokter['id_dokter']."'>".$row_dokter['id_dokter']." - ".$row_dokter['nama']."</option>";  // Pastikan kolom yang benar
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_layanan" class="form-label">ID Layanan</label>
                                <select class="form-control" id="id_layanan" name="id_layanan" required>
                                    <option value="">Pilih Layanan</option>
                                    <?php
                                    // Menampilkan layanan yang ada dalam dropdown
                                    while ($row_layanan = $result_layanan->fetch_assoc()) {
                                        echo "<option value='".$row_layanan['id_layanan']."'>".$row_layanan['id_layanan']." - ".$row_layanan['nama_layanan']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="status_antrian" class="form-label">Status Antrian</label>
                                <select class="form-control" id="status_antrian" name="status_antrian" required>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Antrian -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pasien</th>
                    <th>ID Dokter</th>
                    <th>ID Layanan</th>
                    <th>Waktu Antri</th>
                    <th>Status Antrian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no."</td>
                            <td>".$row['id_pasien']."</td>
                            <td>".$row['id_dokter']."</td>
                            <td>".$row['id_layanan']."</td>
                            <td>".$row['waktu_antri']."</td>
                            <td>".$row['status_antrian']."</td>
                            <td>
                                <a href='edit_antrian.php?id_antrian=".$row['id_antrian']."' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='antrian.php?delete_id=".$row['id_antrian']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin ingin menghapus antrian ini?\")'>Hapus</a>
                            </td>
                        </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
