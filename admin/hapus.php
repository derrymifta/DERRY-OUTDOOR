<?php
$id    = $_GET['id'];
$barang = $_GET['barang'];

include '../koneksi.php';

$data = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id'");

if($data){
    mysqli_query($koneksi, "UPDATE barang SET status='tersedia' WHERE id_barang='$barang'");
    echo "<script>alert('✅ Data Peminjaman berhasil Dihapus');window.location.assign('?halaman=data_peminjaman')</script>";
}
?>