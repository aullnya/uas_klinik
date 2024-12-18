<?php
// Koneksi ke database
include('includes/db.php');

// Menambahkan data layanan
if (isset($_POST['submit'])) {
    $id_pasien = $_POST['id_pasien'];
    $nama_layanan = $_POST['nama_layanan'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO layanan (id_pasien, nama_layanan, deskripsi) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $id_pasien, $nama_layanan, $deskripsi);
    $stmt->execute();
    header("Location: layanan.php");
    exit();
}

// Menghapus data layanan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM layanan WHERE id_layanan = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: layanan.php");
    exit();
}

// Mengambil data layanan
$result = $conn->query("SELECT * FROM layanan");

// Mengambil data layanan untuk form edit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM layanan WHERE id_layanan = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $edit_data = $stmt->get_result()->fetch_assoc();
}

// Mengupdate data layanan
if (isset($_POST['update'])) {
    $id_layanan = $_POST['id_layanan'];
    $id_pasien = $_POST['id_pasien'];
    $nama_layanan = $_POST['nama_layanan'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("UPDATE layanan SET id_pasien = ?, nama_layanan = ?, deskripsi = ? WHERE id_layanan = ?");
    $stmt->bind_param("issi", $id_pasien, $nama_layanan, $deskripsi, $id_layanan);
    $stmt->execute();
    header("Location: layanan.php");
    exit();
}

// Mengambil data pasien untuk dropdown
$pasien_result = $conn->query("SELECT id_pasien, nama FROM pasien");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Layanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Data Layanan</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Layanan</button>

    <!-- Modal Tambah Layanan -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="layanan.php">
                        <div class="mb-3">
                            <label for="id_pasien" class="form-label">Pilih Pasien</label>
                            <select class="form-select" id="id_pasien" name="id_pasien" required>
                                <option value="">Pilih Pasien</option>
                                <?php
                                // Menampilkan daftar pasien dari database
                                while ($pasien = $pasien_result->fetch_assoc()) {
                                    echo "<option value='".$pasien['id_pasien']."'>".$pasien['id_pasien']." - ".$pasien['nama']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_layanan" class="form-label">Nama Layanan</label>
                            <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Layanan -->
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
                        <h5 class="modal-title" id="editModalLabel">Edit Layanan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="layanan.php">
                            <input type="hidden" name="id_layanan" value="<?= $edit_data['id_layanan']; ?>">
                            <div class="mb-3">
                                <label for="id_pasien" class="form-label">Pilih Pasien</label>
                                <select class="form-select" id="id_pasien" name="id_pasien" required>
                                    <option value="<?= $edit_data['id_pasien']; ?>" selected>
                                        <?= $edit_data['id_pasien']; ?> - <?= $edit_data['nama_pasien']; ?>
                                    </option>
                                    <?php
                                    // Menampilkan daftar pasien dari database
                                    $pasien_result_edit = $conn->query("SELECT id_pasien, nama FROM pasien");
                                    while ($pasien = $pasien_result_edit->fetch_assoc()) {
                                        echo "<option value='".$pasien['id_pasien']."'>".$pasien['id_pasien']." - ".$pasien['nama']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="<?= $edit_data['nama_layanan']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" required><?= $edit_data['deskripsi']; ?></textarea>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Tabel Data Layanan -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pasien</th>
                <th>ID Layanan</th>
                <th>Nama Layanan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$no++."</td>
                        <td>".$row['id_pasien']."</td>
                        <td>".$row['id_layanan']."</td>
                        <td>".$row['nama_layanan']."</td>
                        <td>".$row['deskripsi']."</td>
                        <td>
                            <a href='?edit_id=".$row['id_layanan']."' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='?delete_id=".$row['id_layanan']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'>Hapus</a>
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
