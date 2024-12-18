<?php
// Koneksi ke database
include('includes/db.php');

// Mengambil data yang akan diedit
if (isset($_GET['id_rekam'])) {
    $id_rekam = $_GET['id_rekam'];
    $sql = "SELECT * FROM rekam_medis WHERE id_rekam = $id_rekam";
    $result = $conn->query($sql);

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data rekam medis tidak ditemukan.";
        exit();
    }
}

// Menyimpan perubahan data rekam medis
if (isset($_POST['submit'])) {
    $id_pasien = $_POST['id_pasien'];
    $id_dokter = $_POST['id_dokter'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];

    $sql_update = "UPDATE rekam_medis SET 
                    id_pasien = '$id_pasien',
                    id_dokter = '$id_dokter',
                    diagnosa = '$diagnosa',
                    tindakan = '$tindakan',
                    tanggal_pemeriksaan = '$tanggal_pemeriksaan'
                    WHERE id_rekam = $id_rekam";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: rekam_medis.php");
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
    <title>Edit Rekam Medis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Rekam Medis</h2>
        <a href="rekam_medis.php" class="btn btn-secondary mb-3">Kembali ke Data Rekam Medis</a>

        <form method="POST" action="edit_rekam_medis.php?id_rekam=<?php echo $row['id_rekam']; ?>">
            <div class="mb-3">
                <label for="id_pasien" class="form-label">ID Pasien</label>
                <input type="number" class="form-control" id="id_pasien" name="id_pasien" value="<?php echo $row['id_pasien']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_dokter" class="form-label">ID Dokter</label>
                <input type="number" class="form-control" id="id_dokter" name="id_dokter" value="<?php echo $row['id_dokter']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="diagnosa" class="form-label">Diagnosa</label>
                <textarea class="form-control" id="diagnosa" name="diagnosa" required><?php echo $row['diagnosa']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tindakan" class="form-label">Tindakan</label>
                <textarea class="form-control" id="tindakan" name="tindakan" required><?php echo $row['tindakan']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" value="<?php echo $row['tanggal_pemeriksaan']; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
