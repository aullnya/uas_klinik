<?php
// Koneksi ke database
include('includes/db.php');

// Menambahkan pasien
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    // Menyimpan data pasien ke dalam database
    $sql_insert = "INSERT INTO pasien (nama, alamat, no_telepon, tanggal_lahir, jenis_kelamin) 
                   VALUES ('$nama', '$alamat', '$no_telepon', '$tanggal_lahir', '$jenis_kelamin')";
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: pasien.php"); // Redirect setelah data ditambahkan
        exit();
    } else {
        echo "Error saat menambahkan data pasien: " . $conn->error . "<br>";
    }
}

// Menghapus pasien
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Menghapus data dari tabel antrian yang terkait dengan pasien
    $delete_antrian_sql = "DELETE FROM antrian WHERE id_pasien = $delete_id";
    if ($conn->query($delete_antrian_sql) === TRUE) {
        echo "Data antrian berhasil dihapus.<br>";
    } else {
        echo "Error saat menghapus data antrian: " . $conn->error . "<br>";
    }

    // Menghapus data pasien setelah data di antrian dihapus
    $sql_delete = "DELETE FROM pasien WHERE id_pasien = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Data pasien berhasil dihapus.";
    } else {
        echo "Error saat menghapus data pasien: " . $conn->error;
    }

    // Redirect setelah penghapusan
    header("Location: pasien.php");
    exit();
}

// Mengambil data pasien
$sql = "SELECT * FROM pasien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-body {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Data Pasien</h2>
        <a href="index.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Pasien</button>

        <!-- Modal untuk menambahkan pasien -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="pasien.php">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">No Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Pasien -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$no."</td>
                            <td>".$row['nama']."</td>
                            <td>".$row['alamat']."</td>
                            <td>".$row['no_telepon']."</td>
                            <td>".$row['tanggal_lahir']."</td>
                            <td>".$row['jenis_kelamin']."</td>
                            <td>
                                <a href='edit_pasien.php?id_pasien=".$row['id_pasien']."' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='pasien.php?delete_id=".$row['id_pasien']."' class='btn btn-danger btn-sm' onclick='return confirm(\"Anda yakin ingin menghapus pasien ini?\")'>Hapus</a>
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
