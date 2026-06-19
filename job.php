<?php 
include 'koneksi.php'; 

// Logika Fitur Pencarian
$keyword = "";
$query_str = "SELECT * FROM lowongan WHERE status = 'buka'";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    // PERBAIKAN DI SINI: Mengubah 'mysqli_real_escape_num_string' menjadi 'mysqli_real_escape_string'
    $keyword = mysqli_real_escape_string($koneksi, $_GET['search']);
    $query_str .= " AND (posisi LIKE '%$keyword%' OR lokasi LIKE '%$keyword%')";
}
$query_str .= " ORDER BY id DESC";
$query = mysqli_query($koneksi, $query_str);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan - Abuya Group Portal</title>
    <link href="css/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        .navbar { border-bottom: 2px solid #000; }
        .search-container { background-color: #000; padding: 40px 0; color: #fff; }
        .card-job { border: 2px solid #000; border-radius: 8px; margin-bottom: 20px; background-color: #fff; }
        .job-header-click { cursor: pointer; padding: 20px; }
        .job-header-click:hover { background-color: #f8f9fa; }
        .qualification-box { padding: 20px; border-top: 1px dashed #000; background-color: #fafafa; }
        .btn-apply-final { background-color: #000; color: #fff; border: 2px solid #000; font-weight: 600; border-radius: 4px; text-decoration: none; display: inline-block; }
        .btn-apply-final:hover { background-color: #fff; color: #000; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Abuya Group Portal</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-bold" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="job.php">Job</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="search-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center mb-3 fw-bold">Cari Lowongan Pekerjaan</h2>
                    <form action="job.php" method="GET" class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control border-dark" placeholder="Ketik posisi pekerjaan..." value="<?= htmlspecialchars($keyword); ?>">
                        <button class="btn btn-primary px-4 border-dark" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            
            <?php if (mysqli_num_rows($query) > 0) { ?>
                <h4 class="fw-bold mb-4"><i class="fa-solid fa-list me-2"></i>Klik Pada Pekerjaan Untuk Melihat Kualifikasi</h4>
                
                <?php while($row = mysqli_fetch_assoc($query)) { ?>
                    <div class="card card-job shadow-sm">
                        <div class="job-header-click" data-bs-toggle="collapse" data-bs-target="#loker<?= $row['id']; ?>">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h4 class="fw-bold mb-1 text-dark"><?= $row['posisi']; ?></h4>
                                    <span class="text-muted small"><i class="fa-solid fa-location-dot me-1"></i><?= $row['lokasi']; ?></span>
                                </div>
                                <span class="badge bg-dark px-3 py-2 mt-2 mt-md-0">Lihat Detail <i class="fa-solid fa-chevron-down ms-1"></i></span>
                            </div>
                        </div>
                        
                        <div id="loker<?= $row['id']; ?>" class="collapse">
                            <div class="qualification-box">
                                <h5 class="fw-bold">Kualifikasi:</h5>
                                <ul>
                                    <?php 
                                    // Memecah teks string berdasarkan tanda titik koma (;) menjadi list array
                                    $lists = explode(";", $row['kualifikasi']);
                                    foreach($lists as $list) {
                                        if(!empty(trim($list))) {
                                            echo "<li>" . htmlspecialchars($list) . "</li>";
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="mt-4">
                                    <a href="<?= $row['link_google_docs']; ?>" target="_blank" class="btn btn-apply-final px-4 py-2">
                                        <i class="fa-brands fa-google-drive me-2"></i>Lamar Posisi Ini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center py-5 bg-white border border-2 border-dark rounded">
                        <div class="mb-3">
                            <span class="p-3 bg-light rounded-circle d-inline-block border border-dark">
                                <i class="fa-solid fa-briefcase-slash display-6 text-secondary"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold">Mohon Maaf, Karir Belum Tersedia</h4>
                        <p class="text-secondary mb-4">Tidak ada lowongan aktif yang sesuai dengan pencarian Anda saat ini.</p>
                        <a href="index.php" class="btn btn-dark border-dark px-4 py-2 fw-bold">Kembali ke Home</a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>

    <footer class="py-4 bg-dark text-white text-center mt-auto border-top border-dark border-2">
        <p class="m-0">&copy; 2026 Abuya Group</p>
    </footer>

    <script src="css/js/bootstrap.bundle.min.js"></script>
</body>
</html>