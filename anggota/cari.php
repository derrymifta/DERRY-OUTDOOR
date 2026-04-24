<?php
session_start();
include '../koneksi.php';
if (empty($_SESSION['id_anggota'])) { header("Location:../login-anggota.php"); exit(); }

$kunci = isset($_POST['kunci']) ? $_POST['kunci'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cari Alat | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #1a1a1a !important; }
        .card-barang { border: none; border-radius: 15px; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-barang:hover { transform: translateY(-5px); }
        .img-katalog { width: 100%; height: 150px; object-fit: contain; padding: 10px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark p-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🏔️ MOUNT OUTDOOR</a>
        <a href="dashboard.php" class="btn btn-sm btn-outline-light">Kembali</a>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="fw-bold mb-4">🔍 Hasil Pencarian: "<?= htmlspecialchars($kunci) ?>"</h3>

    <div class="row">
        <?php
        // Query mencari alat berdasarkan nama_barang
        $res = mysqli_query($koneksi, "SELECT * FROM barang WHERE nama_barang LIKE '%$kunci%'");
        
        if (mysqli_num_rows($res) > 0) {
            while($b = mysqli_fetch_array($res)){
                // Logika Gambar Otomatis
                $foto = "default.jpg"; 
                if(stripos($b['nama_barang'], 'Tenda') !== false) $foto = "tenda.jpg";
                elseif(stripos($b['nama_barang'], 'Kompor') !== false) $foto = "kompor.jpg";
                elseif(stripos($b['nama_barang'], 'Sepatu') !== false) $foto = "sepatu.jpg";
                elseif(stripos($b['nama_barang'], 'Trakking') !== false || stripos($b['nama_barang'], 'Tongkat') !== false) $foto = "tongkat.jpg";
        ?>
            <div class="col-md-3 mb-4">
                <div class="card card-barang h-100">
                    <div class="card-body text-center">
                        <img src="../img_barang/<?= $foto; ?>" class="img-katalog" alt="Alat">
                        <h5 class="fw-bold mt-2"><?= $b['nama_barang']; ?></h5>
                        <p class="badge bg-light text-primary border"><?= $b['jenis']; ?></p>
                        <div class="small text-muted mb-3">Kondisi: <?= $b['kondisi']; ?></div>
                        
                        <?php if($b['status'] == 'Tersedia'): ?>
                            <a href="proses_pinjam.php?id=<?= $b['id_barang']; ?>" 
                               class="btn btn-primary w-100 rounded-pill"
                               onclick="return confirm('Sewa alat ini?')">Sewa Sekarang</a>
                        <?php else: ?>
                            <button class="btn btn-secondary w-100 rounded-pill" disabled>Tersewa</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<div class='col-12 text-center mt-5'><p class='text-muted'>Alat tidak ditemukan. Coba kata kunci lain.</p></div>";
        }
        ?>
    </div>
</div>
</body>
</html>