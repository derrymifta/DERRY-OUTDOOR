<?php
include '../koneksi.php';

// --- LOGIKA PAGINATION & SEARCH ---
$batas = 5; // Pembatas per 5 benda sesuai permintaan
$halaman = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';

// Query hitung total untuk pagination
if (!empty($cari)) {
    $query_hitung = "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%' OR jenis LIKE '%$cari%'";
} else {
    $query_hitung = "SELECT * FROM barang";
}

$data_hitung = mysqli_query($koneksi, $query_hitung);
$jumlah_data = mysqli_num_rows($data_hitung);
$total_halaman = ceil($jumlah_data / $batas);

// Query ambil data utama
if (!empty($cari)) {
    $query_data = "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%' OR jenis LIKE '%$cari%' LIMIT $halaman_awal, $batas";
} else {
    $query_data = "SELECT * FROM barang LIMIT $halaman_awal, $batas";
}
$data_barang = mysqli_query($koneksi, $query_data);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">📦 Data Barang Outdoor</h4>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="?halaman=input_barang" class="btn btn-primary shadow-sm fw-bold">➕ Tambah Data</a>
        <a href="cetak_barang.php" target="_blank" class="btn btn-success shadow-sm fw-bold ms-1">🖨️ Cetak</a>
    </div>
    <div class="col-md-6">
        <form action="" method="GET">
            <input type="hidden" name="halaman" value="data_barang">
            <div class="input-group shadow-sm">
                <input type="text" name="cari" class="form-control" placeholder="Cari alat gunung..." value="<?= $cari ?>">
                <button class="btn btn-dark" type="submit">🔍 Cari</button>
                <?php if(!empty($cari)): ?>
                    <a href="?halaman=data_barang" class="btn btn-outline-secondary">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered text-center align-middle bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th width="5%">No</th>
                <th width="15%">Gambar</th>
                <th>Nama Barang</th>
                <th>Jenis</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th width="15%">Kelola</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $nomor = $halaman_awal + 1;
            while($row = mysqli_fetch_array($data_barang)): 
            ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td>
                    <?php 
                        // Cek apakah file ada di folder
                        $file_foto = "../img_barang/" . $row['foto'];
                        $tampil = (!empty($row['foto']) && file_exists($file_foto)) ? $file_foto : "../img_barang/default.jpg";
                    ?>
                    <img src="<?= $tampil ?>" width="65" height="65" style="object-fit:cover;" class="rounded border shadow-sm">
                </td>
                <td class="text-start fw-bold text-uppercase"><?= $row['nama_barang'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td><small class="badge bg-light text-dark border"><?= $row['kondisi'] ?></small></td>
                <td><?= $row['jumlah'] ?></td>
                <td>
                    <?php if($row['status'] == 'Tersedia'): ?>
                        <span class="badge bg-success">Tersedia</span>
                    <?php elseif($row['status'] == 'Dipinjam'): ?>
                        <span class="badge bg-danger">Dipinjam</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">-</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="btn-group">
                        <a href="?halaman=edit_barang&id=<?= $row['id_barang'] ?>" class="btn btn-warning btn-sm shadow-sm" title="Edit">📝</a>
                        <a href="?halaman=hapus_barang&id=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Hapus barang ini?')" title="Hapus">🗑️</a>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if($jumlah_data == 0): ?>
                <tr><td colspan="8" class="text-muted p-5">Barang tidak ditemukan...</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<nav>
    <ul class="pagination justify-content-center mt-3">
        <?php for($x=1; $x<=$total_halaman; $x++): ?>
            <li class="page-item <?= ($halaman == $x) ? 'active' : '' ?>">
                <a class="page-link shadow-sm <?= ($halaman == $x) ? 'bg-dark border-dark text-white' : 'text-dark' ?>" 
                   href="?halaman=data_barang&p=<?= $x ?>&cari=<?= $cari ?>">
                   <?= $x ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>