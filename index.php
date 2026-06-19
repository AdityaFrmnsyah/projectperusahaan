<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="css/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        .navbar { border-bottom: 2px solid #000; }
        .hero-section { background-color: #f8f9fa; padding: 80px 0; border-bottom: 2px solid #000; }
        .job-list-item { padding: 20px; border-bottom: 2px solid #000 !important; transition: 0.2s; position: relative; cursor: pointer; }
        .job-list-item:hover { background-color: #f1f3f5; transform: scale(1.005); }
        .stretched-link { color: #000; text-decoration: none; font-weight: 700; font-size: 1.1rem; }
        .btn-custom-sm { border: 2px solid #000; border-radius: 4px; font-weight: 600; font-size: 0.85rem; position: relative; z-index: 2; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Abuya Group Portal</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="job.php">Job</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Abuya Group</h1>
            <p class="lead text-muted">Membangun Masa Depan Melalui Solusi Digital Terbaik.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h3 class="fw-bold mb-4">Lowongan Tersedia</h3>
            
            <?php
            // Ambil data lowongan yang statusnya masih dibuka
            $query = mysqli_query($koneksi, "SELECT * FROM lowongan WHERE status = 'buka' ORDER BY id DESC");
            if (mysqli_num_rows($query) > 0) {
            ?>
                <div class="card border-dark border-2">
                    <div class="card-body p-0">
                        <ol class="list-group list-group-numbered list-group-flush">
                            <?php while($row = mysqli_fetch_assoc($query)) { ?>
                                <li class="list-group-item job-list-item d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="ms-2 me-auto mb-2 mb-md-0">
                                        <a href="job.php" class="stretched-link"><?= $row['posisi']; ?></a>
                                        <div class="text-muted small mt-1"><i class="fa-solid fa-location-dot me-1"></i><?= $row['lokasi']; ?></div>
                                    </div>
                                    <div>
                                        <a href="job.php" class="btn btn-outline-dark btn-custom-sm me-2">View More</a>
                                        <a href="job.php" class="btn btn-dark btn-custom-sm">Lamar</a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            <?php } else { ?>
                <div class="p-5 text-center bg-light border border-2 border-dark rounded shadow-sm">
                    <i class="fa-solid fa-folder-open display-4 text-muted mb-3"></i>
                    <h4 class="fw-bold text-dark">Belum Ada Lowongan yang Dibuka</h4>
                    <p class="text-muted mx-auto mb-0" style="max-width: 500px;">Saat ini kami belum membuka posisi baru. Silakan cek kembali halaman ini secara berkala.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white text-center border-top border-dark border-2">
        <p class="m-0">&copy; 2026 Abuya Group</p>
    </footer>

    <script src="css/js/bootstrap.bundle.min.js"></script>
</body>
</html>