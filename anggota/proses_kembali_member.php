<?php
session_start();
include '../koneksi.php';

if (empty($_SESSION['id_anggota'])) { 
    header("Location:../login-anggota.php"); 
    exit(); 
}

date_default_timezone_set("Asia/Jakarta");

if(isset($_GET['id']) && isset($_GET['barang'])){
    $id_t = mysqli_real_escape_string($koneksi, $_GET['id']);
    $id_b = mysqli_real_escape_string($koneksi, $_GET['barang']);
    $tgl_kembali = date('Y-m-d H:i:s');

    // Update status ke 'Pengembalian' agar muncul di dashboard admin
    $sql = "UPDATE transaksi SET 
            tgl_kembali = '$tgl_kembali', 
            status_transaksi = 'Pengembalian' 
            WHERE id_transaksi = '$id_t'";

    if(mysqli_query($koneksi, $sql)){
        // Tambah stok dan ubah status barang
        mysqli_query($koneksi, "UPDATE barang SET jumlah = jumlah + 1 WHERE id_barang = '$id_b'");
        mysqli_query($koneksi, "UPDATE barang SET status = 'Tersedia' WHERE id_barang = '$id_b'");

        echo "<script>
                alert('✅ Alat dikembalikan! Terima kasih sudah berpetualang.'); 
                window.location='history.php'; 
              </script>";
    }
}
?>