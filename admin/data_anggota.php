<?php 
include '../koneksi.php'; 

// 1. PENGATURAN PAGINATION (PEMBATAS 7 DATA)
$jumlahDataPerHalaman = 7;
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : (isset($_GET['keyword']) ? $_GET['keyword'] : "");

// Hitung total data untuk menentukan jumlah halaman
if (!empty($keyword)) {
    $result = mysqli_query($koneksi, "SELECT * FROM anggota WHERE nama_anggota LIKE '%$keyword%' OR nis LIKE '%$keyword%'");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM anggota");
}

$totalData = mysqli_num_rows($result);
$jumlahHalaman = ceil($totalData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET['page'])) ? $_GET['page'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// 2. QUERY DATA (DENGAN LIMIT 7)
if (!empty($keyword)) {
    $query = "SELECT * FROM anggota WHERE 
              nama_anggota LIKE '%$keyword%' OR 
              nis LIKE '%$keyword%' 
              ORDER BY id_anggota DESC LIMIT $awalData, $jumlahDataPerHalaman";
} else {
    $query = "SELECT * FROM anggota ORDER BY id_anggota DESC LIMIT $awalData, $jumlahDataPerHalaman";
}
$data = mysqli_query($koneksi, $query);
?>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-4"><h4 class="m-0 fw-bold">👥 Data Anggota</h4></div>
            <div class="col-md-8 text-end">
                <a href="cetak_anggota.php" target="_blank" class="btn btn-success shadow-sm me-2">🖨️ Cetak</a>
                <a href="?halaman=input_anggota" class="btn btn-primary shadow-sm">➕ Tambah</a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <form action="" method="post" class="mb-3">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Cari Nama/NIS..." value="<?= $keyword ?>">
                <button name="cari" class="btn btn-secondary" type="submit">🔍 Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light fw-bold">
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>NIS</td>
                        <td>Nama Anggota</td>
                        <td>Kelas</td>
                        <td>Kelola</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = $awalData + 1;
                    while ($anggota = mysqli_fetch_array($data)) { 
                        $path_foto = "../assets/img/anggota/" . $anggota['foto'];
                        $tampil_foto = (!empty($anggota['foto']) && file_exists($path_foto)) ? $path_foto : "../assets/img/default-user.png";
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><img src="<?= $tampil_foto ?>" class="rounded-circle border" width="50" height="50" style="object-fit: cover;"></td>
                            <td><?= $anggota['nis'] ?></td>
                            <td class="fw-bold"><?= $anggota['nama_anggota'] ?></td>
                            <td><?= $anggota['kelas'] ?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="?halaman=edit_anggota&id=<?= $anggota['id_anggota'] ?>">📝</a>
                                <a class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')" href="?halaman=hapus_anggota&id=<?= $anggota['id_anggota'] ?>">🗑️</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center mt-3">
                <?php if($halamanAktif > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=data_anggota&page=<?= $halamanAktif - 1 ?>&keyword=<?= $keyword ?>">Previous</a></li>
                <?php endif; ?>

                <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                    <li class="page-item <?= ($i == $halamanAktif) ? 'active' : '' ?>">
                        <a class="page-link" href="?halaman=data_anggota&page=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if($halamanAktif < $jumlahHalaman) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=data_anggota&page=<?= $halamanAktif + 1 ?>&keyword=<?= $keyword ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>