<?php
session_start();
include '../koneksi.php';
if (empty($_SESSION['id_anggota'])) { header("Location:../login-anggota.php"); exit(); }
$id_anggota = $_SESSION['id_anggota'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>History | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #1a1a1a !important; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .badge-custom { border-radius: 20px; padding: 6px 15px; }
        
        /* Style untuk cetak agar tombol tidak ikut terprint */
        @media print {
            .navbar, .btn-print, .btn-danger, .btn-outline-light, .btn-aksi { display: none !important; }
            .table-container { box-shadow: none; border: none; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark p-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🏔️ MOUNT OUTDOOR</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-sm btn-outline-light me-2">🏠 Dash</a>
            <button onclick="window.print()" class="btn btn-sm btn-info text-white me-2 btn-print">🖨️ Cetak History</button>
            <a href="../logout.php" class="btn btn-sm btn-danger">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="table-container">
        <h3 class="fw-bold mb-4 text-center">📜 Riwayat Penyewaan</h3>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th class="btn-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Gabungkan tabel transaksi dan barang
                    $res = mysqli_query($koneksi, "SELECT * FROM transaksi 
                                                   JOIN barang ON transaksi.id_barang = barang.id_barang 
                                                   WHERE transaksi.id_anggota = '$id_anggota' 
                                                   ORDER BY id_transaksi DESC");
                    
                    while($row = mysqli_fetch_array($res)){
                        $tgl_p = ($row['tgl_pinjam'] != '0000-00-00 00:00:00') ? date('d/m/Y H:i', strtotime($row['tgl_pinjam'])) : '-';
                        
                        $tgl_k = ($row['tgl_kembali'] != '0000-00-00 00:00:00' && !empty($row['tgl_kembali'])) 
                                 ? date('d/m/Y H:i', strtotime($row['tgl_kembali'])) 
                                 : '<span class="text-muted">--:--</span>';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><b class="text-primary text-uppercase"><?= $row['nama_barang']; ?></b></td>
                        <td><small><?= $tgl_p; ?></small></td>
                        <td><small><?= $tgl_k; ?></small></td>
                        <td>
                            <?php if($row['status_transaksi'] == 'Peminjaman'): ?>
                                <span class="badge bg-warning text-dark badge-custom">Sedang Dibawa</span>
                            <?php else: ?>
                                <span class="badge bg-success badge-custom">Sudah Pulang</span>
                            <?php endif; ?>
                        </td>
                        <td class="btn-aksi">
                            <?php if($row['status_transaksi'] == 'Peminjaman'): ?>
                                <a href="proses_kembali_member.php?id=<?= $row['id_transaksi']; ?>&barang=<?= $row['id_barang']; ?>" 
                                   class="btn btn-sm btn-danger fw-bold shadow-sm" 
                                   onclick="return confirm('Apakah Anda yakin sudah mengembalikan alat ini ke basecamp?')">
                                   ↩️ Kembalikan
                                </a>
                            <?php else: ?>
                                <span class="text-muted small">Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <p class="text-muted mt-3 small text-center">*Klik tombol kembalikan jika alat sudah diserahkan ke Admin.</p>
    </div>
</div>
</body>
</html>