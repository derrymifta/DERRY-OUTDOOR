<?php
include '../koneksi.php';

// Set zona waktu agar tgl_kembali akurat
date_default_timezone_set("Asia/Jakarta");

// Ambil data dari URL dengan pengamanan string
$id_transaksi = mysqli_real_escape_string($koneksi, $_GET['id']);
$id_barang    = mysqli_real_escape_string($koneksi, $_GET['barang']);
$tgl_sekarang = date('Y-m-d H:i:s');

// 1. UPDATE status transaksi menjadi 'Pengembalian' (Sesuai ENUM database)
$query_update_transaksi = "UPDATE transaksi SET 
                           tgl_kembali = '$tgl_sekarang', 
                           status_transaksi = 'Pengembalian' 
                           WHERE id_transaksi = '$id_transaksi'";

$eksekusi_transaksi = mysqli_query($koneksi, $query_update_transaksi);

if($eksekusi_transaksi){
    // 2. UPDATE stok barang (jumlah + 1) dan pastikan status 'Tersedia'
    $query_update_barang = "UPDATE barang SET 
                            jumlah = jumlah + 1, 
                            status = 'Tersedia' 
                            WHERE id_barang = '$id_barang'";
    
    mysqli_query($koneksi, $query_update_barang);

    echo "<script>
            alert('✅ Pengembalian Berhasil! Data sudah masuk ke tabel riwayat.');
            window.location.assign('dashboard.php?halaman=data_peminjaman');
          </script>";
} else {
    echo "Gagal memproses data: " . mysqli_error($koneksi);
}
?>