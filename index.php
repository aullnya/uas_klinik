<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: 'Arial', sans-serif;
            color: #fff;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            height: 250px; /* Tinggi tetap untuk semua kartu */
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .card-body {
            text-align: center;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 18px;
            padding: 12px 20px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        h1 {
            font-size: 40px;
            font-weight: 600;
            margin-bottom: 50px;
        }

        .col-md-3 {
            padding: 15px;
        }

        .col-md-3.no-gap {
            padding: 15px; /* Hilangkan jarak untuk kolom tanpa gap */
        }

        .card-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card-body a {
            text-decoration: none;
            color: white;
        }

        .card-body a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .dashboard-section {
            border-bottom: 2px solid #ddd;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Dashboard Klinis -->
        <h1 class="text-center mt-4">Dashboard Klinik</h1>

        <!-- Section untuk Pasien, Dokter, dan Layanan -->
        <div class="row mt-5 dashboard-section">
            <!-- Card untuk Pasien -->
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Pasien</h5>
                    </div>
                    <div class="card-body">
                        <i class="fas fa-users card-icon" style="color:rgb(194, 221, 251);"></i>
                        <a href="pasien.php" class="btn btn-primary">Lihat Pasien</a>
                    </div>
                </div>
            </div>
            <!-- Card untuk Dokter -->
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Dokter</h5>
                    </div>
                    <div class="card-body">
                        <i class="fas fa-user-md card-icon" style="color: #28a745;"></i>
                        <a href="dokter.php" class="btn btn-primary">Lihat Dokter</a>
                    </div>
                </div>
            </div>
            <!-- Card untuk Layanan -->
            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Layanan</h5>
                    </div>
                    <div class="card-body">
                        <i class="fas fa-cogs card-icon" style="color: #17a2b8;"></i>
                        <a href="layanan.php" class="btn btn-primary">Lihat Layanan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section untuk Antrian dan Rekam Medis -->
        <div class="row">
            <!-- Card untuk Antrian -->
            <div class="col-md-3 no-gap">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Antrian</h5>
                    </div>
                    <div class="card-body">
                        <i class="fas fa-clipboard-list card-icon" style="color: #fd7e14;"></i>
                        <a href="antrian.php" class="btn btn-primary">Lihat Antrian</a>
                    </div>
                </div>
            </div>
            <!-- Card untuk Rekam Medis -->
            <div class="col-md-3 no-gap">
                <div class="card bg-light">
                    <div class="card-header">
                        <h5>Rekam Medis</h5>
                    </div>
                    <div class="card-body">
                        <i class="fas fa-notes-medical card-icon" style="color: #dc3545;"></i>
                        <a href="rekam_medis.php" class="btn btn-primary">Lihat Rekam Medis</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
