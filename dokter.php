<?php
// Koneksi ke database
include('includes/db.php');

// Daftar spesialisasi dokter (bisa juga diambil dari database)
$spesialisasi_list = ["Umum", "Gigi", "Mata", "THT", "Jantung", "Saraf"];

// Menambahkan data dokter
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];

    $stmt = $conn->prepare("INSERT INTO dokter (nama, spesialisasi, jadwal_praktek) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $spesialisasi, $jadwal_praktek);
    $stmt->execute();
    header("Location: dokter.php");
    exit();
}

// Menghapus data dokter
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM dokter WHERE id_dokter = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: dokter.php");
    exit();
}

// Mengambil data dokter
$result = $conn->query("SELECT * FROM dokter");

// Mengambil data dokter untuk form edit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM dokter WHERE id_dokter = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

// Mengupdate data dokter
if (isset($_POST['update'])) {
    $id_dokter = $_POST['id_dokter'];
    $nama = $_POST['nama'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];

    $stmt = $conn->prepare("UPDATE dokter SET nama = ?, spesialisasi = ?, jadwal_praktek = ? WHERE id_dokter = ?");
    $stmt->bind_param("sssi", $nama, $spesialisasi, $jadwal_praktek, $id_dokter);
    $stmt->execute();
    header("Location: dokter.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Data Dokter</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Dokter</button>

    <!-- Modal Tambah Dokter -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="spesialisasi" class="form-label">Spesialisasi</label>
                            <select class="form-control" id="spesialisasi" name="spesialisasi" required>
                                <?php foreach ($spesialisasi_list as $spesialis) { ?>
                                    <option value="<?= $spesialis ?>"><?= $spesialis ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal_praktek" class="form-label">Jadwal Praktek</label>
                            <input type="time" class="form-control" id="jadwal_praktek" name="jadwal_praktek" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Dokter -->
    <?php if (isset($edit_data)) { ?>
        <script>
            window.onload = function() {
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            };
        </script>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Dokter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="id_dokter" value="<?= $edit_data['id_dokter']; ?>">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Dokter</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $edit_data['nama']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                <select class="form-control" id="spesialisasi" name="spesialisasi" required>
                                    <?php foreach ($spesialisasi_list as $spesialis) { ?>
                                        <option value="<?= $spesialis ?>" <?= ($edit_data['spesialisasi'] == $spesialis) ? 'selected' : ''; ?>>
                                            <?= $spesialis ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jadwal_praktek" class="form-label">Jadwal Praktek</label>
                                <input type="time" class="form-control" id="jadwal_praktek" name="jadwal_praktek" value="<?= $edit_data['jadwal_praktek']; ?>" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Tabel Data Dokter -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Jadwal Praktek</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$row['nama']."</td>
                        <td>".$row['spesialisasi']."</td>
                        <td>".$row['jadwal_praktek']."</td>
                        <td>
                            <a href='?edit_id=".$row['id_dokter']."' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='?delete_id=".$row['id_dokter']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'>Hapus</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
