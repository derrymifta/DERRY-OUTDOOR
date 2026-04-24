<?php 
include '../koneksi.php'; 

// Fitur Pencarian
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";

// Logika Query untuk Peminjaman (Sedang Disewa)
$q_pinjam = "SELECT * FROM transaksi 
             JOIN barang ON transaksi.id_barang = barang.id_barang 
             JOIN anggota ON transaksi.id_anggota = anggota.id_anggota 
             WHERE transaksi.status_transaksi = 'Peminjaman'";
if(!empty($keyword)) {
    $q_pinjam .= " AND (anggota.nama_anggota LIKE '%$keyword%' OR barang.nama_barang LIKE '%$keyword%')";
}
$exec = mysqli_query($koneksi, $q_pinjam . " ORDER BY transaksi.id_transaksi DESC");

// Logika Query untuk Riwayat Pengembalian
$q_kembali = "SELECT * FROM transaksi 
              JOIN barang ON transaksi.id_barang = barang.id_barang 
              JOIN anggota ON transaksi.id_anggota = anggota.id_anggota 
              WHERE transaksi.status_transaksi = 'Pengembalian'";
if(!empty($keyword)) {
    $q_kembali .= " AND (anggota.nama_anggota LIKE '%$keyword%' OR barang.nama_barang LIKE '%$keyword%')";
}
$exec_k = mysqli_query($koneksi, $q_kembali . " ORDER BY transaksi.tgl_kembali DESC");
?>

<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold">📊 Data Peminjaman Alat</h4>
            <div>
                <a href="cetak_peminjaman.php" target="_blank" class="btn btn-success me-2">🖨️ Cetak Laporan</a>
                <a href="?halaman=input_peminjaman" class="btn btn-primary">➕ Tambah Manual</a>
            </div>
        </div>
        <div class="card-body">
            <form action="" method="post" class="mb-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari nama anggota atau alat..." value="<?= $keyword ?>">
                    <button class="btn btn-secondary" type="submit">🔍 Cari</button>
                    <a href="?halaman=data_peminjaman" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
            
            <h5 class="fw-bold text-primary mb-3">📌 Sedang Disewa</h5>
            <div class="table-responsive mb-5">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light fw-bold">
                        <tr>
                            <td>No</td>
                            <td>Nama Anggota</td>
                            <td>Barang Outdoor</td>
                            <td>Tanggal Pinjam</td>
                            <td>Status</td>
                            <td>Kelola</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if(mysqli_num_rows($exec) > 0) {
                            while ($pinjam = mysqli_fetch_array($exec)) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><span class="text-primary fw-bold"><?= $pinjam['nama_anggota'] ?></span></td>
                                    <td><?= $pinjam['nama_barang'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($pinjam['tgl_pinjam'])) ?></td>
                                    <td><span class="badge bg-warning text-dark">Sedang Disewa</span></td>
                                    <td>
                                        <button onclick="confirmKembali('<?= $pinjam['nama_barang'] ?>', '<?= $pinjam['nama_anggota'] ?>', <?= $pinjam['id_transaksi'] ?>, <?= $pinjam['id_barang'] ?>)" class="btn btn-success btn-sm fw-bold">✅ Selesai</button>
                                    </td>
                                </tr>
                            <?php } 
                        } else {
                            echo "<tr><td colspan='6' class='p-4 text-muted'>Data tidak ditemukan atau belum ada penyewaan.</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white py-3">
            <h4 class="m-0 fw-bold">✅ Riwayat Pengembalian</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <td>No</td>
                            <td>Nama Anggota</td>
                            <td>Barang</td>
                            <td>Tgl Pinjam</td>
                            <td>Tgl Kembali</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no_k = 1;
                        if(mysqli_num_rows($exec_k) > 0) {
                            while ($kembali = mysqli_fetch_array($exec_k)) { ?>
                                <tr>
                                    <td><?= $no_k++; ?></td>
                                    <td><?= $kembali['nama_anggota'] ?></td>
                                    <td><?= $kembali['nama_barang'] ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($kembali['tgl_pinjam'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($kembali['tgl_kembali'])) ?></td>
                                    <td><span class="badge bg-success">Sudah Dikembalikan</span></td>
                                </tr>
                            <?php } 
                        } else {
                            echo "<tr><td colspan='6' class='p-4 text-muted'>Belum ada riwayat pengembalian.</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmKembali(barang, anggota, id_t, id_b) {
        if (confirm('Konfirmasi pengembalian ' + barang + ' oleh ' + anggota + '?')) {
            window.location.href = '?halaman=proses_pengembalian&id=' + id_t + '&barang=' + id_b;
        }
    }
</script>