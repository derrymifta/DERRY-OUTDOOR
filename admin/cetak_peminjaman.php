<?php 
include '../koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } }
        body { font-size: 12px; }
        .header-laporan { border-bottom: 3px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body onload="window.print()">
    <div class="container mt-4">
        <div class="header-laporan text-center">
            <h2 class="fw-bold">LAPORAN PENYEWAAN ALAT OUTDOOR</h2>
            <h4 class="text-secondary">Mount Outdoor Adventure</h4>
            <p>Bandung, Jawa Barat | Tanggal Cetak: <?= date('d/m/Y H:i') ?></p>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Nama Barang</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $res = mysqli_query($koneksi, "SELECT * FROM transaksi 
                                              JOIN anggota ON transaksi.id_anggota = anggota.id_anggota 
                                              JOIN barang ON transaksi.id_barang = barang.id_barang 
                                              ORDER BY tgl_pinjam DESC");
                while($d = mysqli_fetch_array($res)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama_anggota'] ?></td>
                        <td><?= $d['nama_barang'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($d['tgl_pinjam'])) ?></td>
                        <td><?= ($d['status_transaksi'] == 'Peminjaman') ? '-' : date('d/m/Y H:i', strtotime($d['tgl_kembali'])) ?></td>
                        <td><strong><?= $d['status_transaksi'] ?></strong></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <div class="mt-5 text-end pe-5">
            <p>Mengetahui,</p>
            <br><br><br>
            <p class="fw-bold">Petugas Admin</p>
        </div>
    </div>
</body>
</html>