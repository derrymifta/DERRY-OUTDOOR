<?php
include '../koneksi.php';
// Mengambil data anggota untuk dropdown
$anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
// Mengambil data barang yang tersedia
$barang  = mysqli_query($koneksi, "SELECT * FROM barang WHERE status='tersedia'"); 
?>

<h4>🎒 Tambah Peminjaman Outdoor</h4>
<form method="post" action="" class="mt-3">
    <select name="id_anggota" class="form-control mb-2" required>
        <option value="">== 👥 Pilih Anggota ==</option>
        <?php foreach($anggota as $data){
            echo "<option value='$data[id_anggota]'>$data[nama_anggota]</option>";
        } ?>
    </select>

    <select name="id_barang" class="form-control mb-2" required>
        <option value="">== ⛺ Pilih Barang ==</option>
        <?php foreach($barang as $data){
            // Kuncinya di sini: Sesuaikan dengan kolom nama_barang di database kamu
            echo "<option value='$data[id_barang]'>$data[nama_barang]</option>";
        } ?>
    </select>

    <input name="tgl_pinjam" type="datetime-local" class="form-control mb-2" required>
    <button name="tombol" type="submit" class="btn btn-primary">💾 SIMPAN</button>
</form>

<?php
if(isset($_POST['tombol'])){
    $id_anggota = $_POST['id_anggota'];
    $id_barang  = $_POST['id_barang']; // Mengambil id_barang
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $status_transaksi = "Peminjaman";

    // Simpan ke tabel transaksi
    $query = "INSERT INTO transaksi(id_anggota, id_barang, tgl_pinjam, status_transaksi) 
              VALUES('$id_anggota', '$id_barang', '$tgl_pinjam', '$status_transaksi')";
    $data = mysqli_query($koneksi, $query);

    if($data){
        // Update status barang menjadi 'tidak' tersedia
        mysqli_query($koneksi, "UPDATE barang SET status='tidak' WHERE id_barang='$id_barang'");
        echo "<script>alert('✅ Data peminjaman tersimpan'); window.location.assign('?halaman=data_peminjaman');</script>";
    } else {
        echo "<script>alert('❌ Data gagal tersimpan'); window.location.assign('?halaman=input_peminjaman');</script>";
    }
}
?>