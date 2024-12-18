<?php
// Koneksi ke database
include('includes/db.php');

// Menambahkan data rekam medis
if (isset($_POST['submit'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];

    $sql_insert = "INSERT INTO rekam_medis (id_pasien, id_dokter, diagnosa, tindakan, tanggal_pemeriksaan) 
                   VALUES ('$id_pasien', '$id_dokter', '$diagnosa', '$tindakan', '$tanggal_pemeriksaan')";
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: rekam_medis.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

// Mengambil data pasien dan dokter untuk dropdown
$sql_pasien = "SELECT * FROM pasien";
$result_pasien = $conn->query($sql_pasien);

$sql_dokter = "SELECT * FROM dokter";
$result_dokter = $conn->query($sql_dokter);

// Mengambil data rekam medis
$sql = "SELECT * FROM rekam_medis";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rekam Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Data Rekam Medis</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Rekam Medis</button>

        <!-- Modal untuk menambahkan rekam medis -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Rekam Medis</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="rekam_medis.php">
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
                                <label for="diagnosa" class="form-label">Diagnosa</label>
                                <textarea class="form-control" id="diagnosa" name="diagnosa" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tindakan" class="form-label">Tindakan</label>
                                <textarea class="form-control" id="tindakan" name="tindakan" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                                <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Rekam Medis -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pasien</th>
                    <th>ID Dokter</th>
                    <th>Diagnosa</th>
                    <th>Tindakan</th>
                    <th>Tanggal Pemeriksaan</th>
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
                            <td>".$row['diagnosa']."</td>
                            <td>".$row['tindakan']."</td>
                            <td>".$row['tanggal_pemeriksaan']."</td>
                            <td>
                                <a href='edit_rekam_medis.php?id_rekam=".$row['id_rekam']."' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='rekam_medis.php?delete_id=".$row['id_rekam']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin ingin menghapus rekam medis ini?\")'>Hapus</a>
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
