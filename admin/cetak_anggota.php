<?php 
include '../koneksi.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Data Anggota | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            tr { -webkit-print-color-adjust: exact; }
        }
        .foto-print { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body onload="window.print()">

    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">LAPORAN DATA ANGGOTA</h2>
            <h4 class="text-secondary">Mount Outdoor Adventure</h4>
            <hr>
        </div>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama Anggota</th>
                    <th>Username</th>
                    <th>Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY nama_anggota ASC");
                while ($d = mysqli_fetch_array($query)) {
                    $path_foto = "../assets/img/anggota/" . $d['foto'];
                    $tampil_foto = (!empty($d['foto']) && file_exists($path_foto)) ? $path_foto : "../assets/img/default-user.png";
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <img src="<?= $tampil_foto ?>" class="foto-print border">
                    </td>
                    <td><?= $d['nis'] ?></td>
                    <td class="text-start ps-3"><?= $d['nama_anggota'] ?></td>
                    <td><?= $d['username'] ?></td>
                    <td><?= $d['kelas'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="mt-5 text-end pe-5">
            <p>Bandung, <?= date('d F Y') ?></p>
            <br><br>
            <p class="fw-bold text-decoration-underline">Admin Mount Outdoor</p>
        </div>
    </div>

    <div class="text-center no-print mb-5">
        <button class="btn btn-primary" onclick="window.print()">Klik untuk Cetak</button>
    </div>

</body>
</html>