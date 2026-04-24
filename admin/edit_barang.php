<?php
include '../koneksi.php';

// Ambil ID dari URL
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id'");
$data = mysqli_fetch_array($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='?halaman=data_barang';</script>";
}
?>

<div class="card p-4 shadow-sm">
    <h4 class="fw-bold">🏕️ Edit Data Barang Outdoor</h4>
    <hr>
    <form method="post" action="">
        <div class="mb-2">
            <label class="form-label">Nama Barang</label>
            <input value="<?= $data['nama_barang'] ?>" name="nama_barang" type="text" class="form-control" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Jenis/Kategori</label>
            <input value="<?= $data['jenis'] ?>" name="jenis" type="text" class="form-control" required>
        </div>

        <div class="mb-2">
            <label class="form-label">Kondisi Alat</label>
            <input value="<?= $data['kondisi'] ?>" name="kondisi" type="text" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Stok</label>
            <input value="<?= $data['jumlah'] ?>" name="jumlah" type="number" class="form-control" required>
        </div>

        <button name="tombol" type="submit" class="btn btn-primary fw-bold">💾 SIMPAN PERUBAHAN</button>
        <a href="?halaman=data_barang" class="btn btn-light">Batal</a>
    </form>
</div>

<?php
if (isset($_POST['tombol'])) {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $jenis       = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $kondisi     = mysqli_real_escape_string($koneksi, $_POST['kondisi']);
    $jumlah      = mysqli_real_escape_string($koneksi, $_POST['jumlah']);

    $sql = "UPDATE barang SET 
                nama_barang='$nama_barang',
                jenis='$jenis',
                kondisi='$kondisi',
                jumlah='$jumlah'
              WHERE id_barang='$id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('✅ Data berhasil diupdate!'); window.location='?halaman=data_barang';</script>";
    } else {
        echo "<script>alert('❌ Gagal update: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>