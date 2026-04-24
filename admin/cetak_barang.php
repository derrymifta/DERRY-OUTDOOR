<?php
include '../koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Barang Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .tabel-cetak { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tabel-cetak th, .tabel-cetak td { border: 1px solid #000; padding: 8px; text-align: center; }
        @media print {
            .btn-print { display: none; } /* Sembunyikan tombol saat di-print */
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2>LAPORAN DATA BARANG MOUNT OUTDOOR</h2>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table class="tabel-cetak">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Kondisi</th>
                <th>Jumlah Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");
            while ($row = mysqli_fetch_array($query)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="text-align: left; font-weight: bold;"><?= $row['nama_barang'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td><?= $row['kondisi'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        // Otomatis membuka jendela print saat halaman dimuat
        window.print();
    </script>

</body>
</html>