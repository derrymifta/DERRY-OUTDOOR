<?php
session_start();
include '../koneksi.php'; 

if (empty($_SESSION['id_anggota'])) {
    header("Location:../login-anggota.php");
    exit();
}

// Ambil data anggota terbaru
$id_log = $_SESSION['id_anggota'];
$user_query = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id_log'");
$user_data = mysqli_fetch_array($user_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; transition: 0.3s; }
        .navbar { background: #1a1a1a !important; }
        .hero-member {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white; padding: 50px 20px; border-radius: 15px;
            margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .search-card {
            border: none; border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-top: -40px;
        }
        .btn-outdoor { background: #2a5298; color: white; border: none; }
        .btn-outdoor:hover { background: #1e3c72; color: white; }
        
        .card-barang { border: none; border-radius: 15px; transition: 0.3s; overflow: hidden; }
        .card-barang:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .img-container { background: #fff; padding: 15px; border-radius: 10px; }
        .img-katalog { width: 100%; height: 160px; object-fit: contain; }
        .nav-profile-img { width: 35px; height: 35px; object-fit: cover; border: 2px solid #fff; }

        /* DARK MODE STYLES */
        body.dark-mode { background-color: #121212 !important; color: #e0e0e0; }
        .dark-mode .card, .dark-mode .search-card { background-color: #1e1e1e !important; color: white; border: 1px solid #333; }
        .dark-mode .text-dark { color: #ffffff !important; }
        .dark-mode .text-muted { color: #b0b0b0 !important; }
        .dark-mode .img-container { background: #2d2d2d; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark p-3 sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🏔️ MOUNT OUTDOOR</a>
        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-sm btn-outline-light me-3" id="btnDarkMode">🌙</button>
            <a href="dashboard.php" class="btn btn-sm btn-light me-2">🏠 Dash</a>
            <a href="?halaman=history" class="btn btn-sm btn-outline-light me-2">📜 History</a>
            
            <?php 
            $f_nav = !empty($user_data['foto']) ? "../assets/img/anggota/".$user_data['foto'] : "../assets/img/default-user.png";
            ?>
            <a href="?halaman=profile" class="me-3">
                <img src="<?= $f_nav ?>" class="rounded-circle nav-profile-img" title="Edit Profil">
            </a>

            <a href="../logout.php" class="btn btn-sm btn-danger shadow-sm">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <?php 
    if (isset($_GET['halaman'])) {
        $hlm = $_GET['halaman'];
        if ($hlm == "profile") {
            include "profile.php";
        } elseif ($hlm == "history") {
            include "history.php";
        } elseif ($hlm == "proses_pengembalian") {
            include "proses_pengembalian.php";
        }
    } else { 
    ?>

    <div class="hero-member text-center">
        <h2 class="fw-bold">Selamat Berpetualang, <?= $user_data['nama_anggota']; ?>! 👋</h2>
        <p>Siapkan perlengkapanmu dan taklukkan puncak impian.</p>
    </div>

    <div class="card search-card p-4 mb-5">
        <form action="cari.php" method="post">
            <label class="fw-bold mb-2">Cari Perlengkapan Outdoor</label>
            <div class="input-group">
                <input type="text" name="kunci" class="form-control form-control-lg" placeholder="Tenda, Carrier, Sepatu, Kompor..." required>
                <button class="btn btn-outdoor px-4" type="submit">🔍 Cari Alat</button>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <h4 class="fw-bold text-dark">Alat yang Tersedia 🌲</h4>
            <hr width="50" style="height: 3px; background: #2a5298; border: none; opacity: 1;">
        </div>

        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE jumlah > 0");
        if(mysqli_num_rows($query) > 0) {
            while($b = mysqli_fetch_array($query)){
                $foto_path = "../img_barang/" . $b['foto'];
                $tampil_foto = (!empty($b['foto']) && file_exists($foto_path)) ? $foto_path : "../img_barang/default.jpg";
        ?>
        <div class="col-md-3 mb-4">
            <div class="card card-barang shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="img-container mb-3">
                        <img src="<?= $tampil_foto; ?>" class="img-fluid img-katalog" alt="<?= $b['nama_barang']; ?>">
                    </div>
                    <h5 class="fw-bold mb-1"><?= $b['nama_barang']; ?></h5>
                    <p class="badge bg-light text-primary border mb-2"><?= $b['jenis']; ?></p>
                    <div class="small text-muted mb-1">Kondisi: <b><?= $b['kondisi']; ?></b></div>
                    <div class="small text-muted mb-4">Tersedia: <span class="badge bg-secondary"><?= $b['jumlah']; ?> pcs</span></div>
                    <a href="proses_pinjam.php?id=<?= $b['id_barang']; ?>" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow-sm" onclick="return confirm('Yakin mau sewa <?= $b['nama_barang']; ?>?')">Sewa Sekarang</a>
                </div>
            </div>
        </div>
        <?php } 
        } else {
            echo "<div class='col-12'><div class='alert alert-light text-center py-5 shadow-sm rounded-4 text-muted'>Semua alat sedang dalam petualangan.</div></div>";
        } ?>
    </div>

    <?php } ?>

</div>

<footer class="text-center mt-5 mb-4 text-muted small">
    © 2026 Mount Outdoor System - Crafted for Adventure.
</footer>

<script src="../js/bootstrap.bundle.min.js"></script>
<script>
    // SCRIPT DARK MODE
    const btnDarkMode = document.getElementById('btnDarkMode');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        btnDarkMode.innerHTML = '☀️';
    }

    btnDarkMode.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            btnDarkMode.innerHTML = '☀️';
        } else {
            localStorage.setItem('theme', 'light');
            btnDarkMode.innerHTML = '🌙';
        }
    });
</script>
</body>
</html>