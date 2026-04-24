<?php
session_start();
if (empty($_SESSION['id_admin'])) {
    header("Location:../login-admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mount Outdoor | Admin Dashboard</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { transition: background-color 0.3s ease; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        [data-bs-theme="light"] body { background-color: #f0f2f5; }
        [data-bs-theme="dark"] body { background-color: #121212; }

        .navbar { background: #1a1a1a !important; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .card-utama { border: none; border-radius: 15px; box-shadow: 0 4px 25px rgba(0,0,0,0.08); min-height: 550px; transition: 0.3s; }
        
        .welcome-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 60px 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .shortcut-card {
            padding: 25px;
            border-radius: 12px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            display: block;
            height: 100%;
            text-decoration: none !important;
        }
        [data-bs-theme="light"] .shortcut-card { background: white; }
        [data-bs-theme="dark"] .shortcut-card { background: #1e1e1e; border: 1px solid #333; }

        .shortcut-card:hover {
            transform: translateY(-10px);
            border-color: #2a5298;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .shortcut-card h3 { font-size: 40px; margin-bottom: 15px; }
        
        .nav-link { font-weight: 500; transition: 0.3s; }
        .nav-link:hover { color: #ffc107 !important; }

        .theme-switch { cursor: pointer; padding: 5px 15px; border-radius: 20px; background: #333; color: white; display: flex; align-items: center; gap: 8px; font-size: 0.85rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark p-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🏔️ MOUNT OUTDOOR</a>
        
        <div class="d-flex align-items-center order-lg-3 ms-lg-3">
            <div class="theme-switch" id="themeBtn">
                <span id="themeIcon">🌙</span> <span id="themeText">Gelap</span>
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">🏠 Dash</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="?halaman=data_barang">📦 Barang</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="?halaman=data_anggota">👥 Anggota</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="?halaman=data_peminjaman">📝 Pinjam</a></li>
                <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white px-3 ms-lg-3 mt-2 mt-lg-0" href="logout.php">Keluar</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="card card-utama p-4">
        <?php
        include '../koneksi.php'; // Tambahkan koneksi di sini agar semua sub-halaman bisa pakai
        $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : '';

        switch ($halaman) {
            // Bagian Barang - Pastikan file input_barang.php sudah kamu buat
            case 'data_barang': include 'data_barang.php'; break;
            case 'input_barang': include 'input_barang.php'; break; 
            case 'edit_barang': include 'edit_barang.php'; break;
            case 'hapus_barang': include 'hapus_barang.php'; break;

            // Bagian Anggota
            case 'data_anggota': include 'data_anggota.php'; break;
            case 'input_anggota': include 'input_anggota.php'; break;
            case 'edit_anggota': include 'edit_anggota.php'; break;
            case 'hapus_anggota': include 'hapus_anggota.php'; break;

            // Bagian Peminjaman
            case 'data_peminjaman': include 'data_peminjaman.php'; break;
            case 'input_peminjaman': include 'input_peminjaman.php'; break;
            case 'proses_pengembalian': include 'proses_pengembalian.php'; break;
            case 'hapus': include 'hapus.php'; break;

            default:
        ?>
            <div class="welcome-section text-center shadow">
                <h1 class="fw-bold mb-3">Halo, Administrator Outdoor! ✨</h1>
                <p class="lead">Pusat kendali inventaris alat pendakian dan aktivitas transaksi.</p>
            </div>
            
            <div class="row g-4 text-center mt-2">
                <div class="col-md-4">
                    <div class="shortcut-card shadow-sm">
                        <a href="?halaman=data_barang" class="text-decoration-none text-reset">
                            <h3>📦</h3>
                            <h5>Kelola Barang</h5>
                            <p class="text-muted small mb-3">Update stok tas, tenda, kompor, dan alat lainnya.</p>
                        </a>
                        <a href="?halaman=input_barang" class="btn btn-outline-primary btn-sm w-100">Tambah Barang</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shortcut-card shadow-sm">
                        <a href="?halaman=data_anggota" class="text-decoration-none text-reset">
                            <h3>👥</h3>
                            <h5>Data Anggota</h5>
                            <p class="text-muted small mb-3">Atur dan pantau data pelanggan/peminjam aktif.</p>
                        </a>
                        <a href="?halaman=input_anggota" class="btn btn-outline-info btn-sm w-100">📝 Daftar Anggota</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shortcut-card shadow-sm">
                        <a href="?halaman=data_peminjaman" class="text-decoration-none text-reset">
                            <h3>📝</h3>
                            <h5>Transaksi</h5>
                            <p class="text-muted small mb-3">Proses peminjaman, pengembalian, dan riwayat.</p>
                        </a>
                        <a href="?halaman=input_peminjaman" class="btn btn-outline-warning btn-sm w-100">🛒 Buat Pesanan</a>
                    </div>
                </div>
            </div>

            <div class="mt-5 p-4 bg-body-tertiary rounded-3 border-start border-primary border-4">
                <h6><i class="text-primary">💡</i> <strong>Tips Cepat:</strong></h6>
                <p class="text-muted mb-0 small">Klik ikon untuk melihat data, atau klik tombol di bawahnya untuk menambah data secara langsung.</p>
            </div>
        <?php
                break;
        }
        ?>
    </div>
    <p class="text-center mt-4 text-muted small">© 2026 Mount Outdoor System - Crafted with Passion.</p>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>

<script>
    // Logika Dark Mode tetap dipertahankan
    const themeBtn = document.getElementById('themeBtn');
    const htmlTag = document.documentElement;
    const themeIcon = document.getElementById('themeIcon');
    const themeText = document.getElementById('themeText');

    if (localStorage.getItem('theme') === 'dark') { setDarkMode(); }

    themeBtn.addEventListener('click', () => {
        if (htmlTag.getAttribute('data-bs-theme') === 'light') { setDarkMode(); } 
        else { setLightMode(); }
    });

    function setDarkMode() {
        htmlTag.setAttribute('data-bs-theme', 'dark');
        localStorage.setItem('theme', 'dark');
        themeIcon.innerText = '☀️';
        themeText.innerText = 'Terang';
    }

    function setLightMode() {
        htmlTag.setAttribute('data-bs-theme', 'light');
        localStorage.setItem('theme', 'light');
        themeIcon.innerText = '🌙';
        themeText.innerText = 'Gelap';
    }
</script>

</body>
</html>