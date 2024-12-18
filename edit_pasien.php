<?php
// Koneksi ke database
include('includes/db.php');

// Mengambil data pasien yang ingin diedit
if (isset($_GET['id_pasien'])) {
    $id_pasien = $_GET['id_pasien'];
    $sql = "SELECT * FROM pasien WHERE id_pasien = $id_pasien";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Mengupdate data pasien
if (isset($_POST['update'])) {
    $id_pasien = $_POST['id_pasien'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $sql_update = "UPDATE pasien SET nama='$nama', alamat='$alamat', no_telepon='$no_telepon', 
                   tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin' WHERE id_pasien=$id_pasien";
    if ($conn->query($sql_update) === TRUE) {
        header("Location: pasien.php"); // Redirect setelah update
        exit();
    } else {
        echo "Error saat mengupdate data pasien: " . $conn->error . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Pasien</h2>
        <form method="POST" action="edit_pasien.php">
            <input type="hidden" name="id_pasien" value="<?= $row['id_pasien']; ?>">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $row['alamat']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="<?= $row['no_telepon']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $row['tanggal_lahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?= ($row['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($row['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
