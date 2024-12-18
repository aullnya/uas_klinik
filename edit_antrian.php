<?php
// Koneksi ke database
include('includes/db.php');

// Mengambil data yang akan diedit
if (isset($_GET['id_antrian'])) {
    $id_antrian = $_GET['id_antrian'];
    $sql = "SELECT * FROM antrian WHERE id_antrian = $id_antrian";
    $result = $conn->query($sql);

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data antrian tidak ditemukan.";
        exit();
    }
}

// Menyimpan perubahan data antrian
if (isset($_POST['submit'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $id_layanan = $_POST['id_layanan'];
    $status_antrian = $_POST['status_antrian'];

    $sql_update = "UPDATE antrian SET 
                    id_pasien = '$id_pasien',
                    id_dokter = '$id_dokter',
                    id_layanan = '$id_layanan',
                    status_antrian = '$status_antrian'
                    WHERE id_antrian = $id_antrian";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: antrian.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Antrian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Antrian</h2>
        <a href="antrian.php" class="btn btn-secondary mb-3">Kembali ke Data Antrian</a>

        <form method="POST" action="edit_antrian.php?id_antrian=<?php echo $row['id_antrian']; ?>">
            <div class="mb-3">
                <label for="id_pasien" class="form-label">ID Pasien</label>
                <input type="number" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $row['id_pasien']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_dokter" class="form-label">ID Dokter</label>
                <input type="number" class="form-control" id="id_dokter" name="id_dokter" value="<?php echo $row['id_dokter']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_layanan" class="form-label">ID Layanan</label>
                <input type="number" class="form-control" id="id_layanan" name="id_layanan" value="<?php echo $row['id_layanan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status_antrian" class="form-label">Status Antrian</label>
                <select class="form-control" id="status_antrian" name="status_antrian" required>
                    <option value="Menunggu" <?php if($row['status_antrian'] == 'Menunggu') echo 'selected'; ?>>Menunggu</option>
                    <option value="Diproses" <?php if($row['status_antrian'] == 'Diproses') echo 'selected'; ?>>Diproses</option>
                    <option value="Selesai" <?php if($row['status_antrian'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                    <option value="Dibatalkan" <?php if($row['status_antrian'] == 'Dibatalkan') echo 'selected'; ?>>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
