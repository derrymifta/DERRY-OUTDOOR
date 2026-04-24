<?php
include '../koneksi.php';

// Set zona waktu agar tanggal kembali akurat
date_default_timezone_set("Asia/Jakarta");

// Ambil ID Transaksi dan ID Barang dari URL
// Pastikan link di dashboard admin: ?halaman=pengembalian&id=...&barang=...
$id_transaksi = mysqli_real_escape_string($koneksi, $_GET['id']); 
$id_barang    = mysqli_real_escape_string($koneksi, $_GET['barang']); 
$tgl_sekarang = date('Y-m-d H:i:s');

// 1. Update data di tabel TRANSAKSI
// Mengubah status menjadi 'Pengembalian' sesuai ENUM database kamu
$query_transaksi = "UPDATE transaksi SET 
                    tgl_kembali = '$tgl_sekarang', 
                    status_transaksi = 'Pengembalian' 
                    WHERE id_transaksi = '$id_transaksi'";

$proses_transaksi = mysqli_query($koneksi, $query_transaksi);

if($proses_transaksi){
    // 2. LOGIKA STOK: Tambah stok barang kembali sebanyak 1
    mysqli_query($koneksi, "UPDATE barang SET jumlah = jumlah + 1 WHERE id_barang = '$id_barang'");

    // 3. LOGIKA STATUS: Pastikan status kembali 'Tersedia'
    // Status ini penting agar barang muncul lagi di dashboard member
    mysqli_query($koneksi, "UPDATE barang SET status = 'Tersedia' WHERE id_barang = '$id_barang'");

    echo "<script>
            alert('✅ Alat Berhasil Dikembalikan! Stok otomatis bertambah +1.'); 
            window.location.assign('dashboard.php?halaman=data_peminjaman'); 
          </script>";
} else {
    echo "Gagal memproses pengembalian: " . mysqli_error($koneksi);
}
?>