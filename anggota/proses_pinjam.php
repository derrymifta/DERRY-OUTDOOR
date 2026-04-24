<?php
session_start();
include '../koneksi.php';

// 1. Pastikan member sudah login
if (empty($_SESSION['id_anggota'])) { 
    header("Location:../login-anggota.php"); 
    exit(); 
}

date_default_timezone_set("Asia/Jakarta");

// 2. Ambil data dari URL dan Session
// Pastikan di dashboard member linknya: proses_pinjam.php?id=...
if (isset($_GET['id'])) {
    $id_barang  = mysqli_real_escape_string($koneksi, $_GET['id']);
    $id_anggota = $_SESSION['id_anggota'];
    $tgl_pinjam = date('Y-m-d H:i:s');

    // 3. Cek stok barang saat ini
    $cek_stok = mysqli_query($koneksi, "SELECT jumlah FROM barang WHERE id_barang='$id_barang'");
    $row = mysqli_fetch_array($cek_stok);

    if ($row['jumlah'] > 0) {
        // 4. Masukkan data ke tabel transaksi
        // Status 'Peminjaman' sesuai dengan ENUM database kamu
        $query_input = "INSERT INTO transaksi (id_barang, id_anggota, tgl_pinjam, status_transaksi) 
                        VALUES ('$id_barang', '$id_anggota', '$tgl_pinjam', 'Peminjaman')";

        if (mysqli_query($koneksi, $query_input)) {
            
            // 5. LOGIKA STOK: Kurangi jumlah barang sebanyak 1
            mysqli_query($koneksi, "UPDATE barang SET jumlah = jumlah - 1 WHERE id_barang = '$id_barang'");

            // 6. LOGIKA STATUS: Jika stok sisa 0, ubah status jadi 'Dipinjam'
            // Ini supaya barang otomatis tidak muncul di katalog jika habis
            mysqli_query($koneksi, "UPDATE barang SET status = 'Dipinjam' WHERE id_barang = '$id_barang' AND jumlah = 0");

            echo "<script>
                    alert('🚀 Pesanan Berhasil! Stok berkurang. Silahkan ambil alat di admin.'); 
                    window.location='dashboard.php';
                  </script>";
        } else {
            echo "Error Transaksi: " . mysqli_error($koneksi);
        }
    } else {
        // Jika stok 0 tapi member maksa akses lewat URL
        echo "<script>
                alert('⚠️ Maaf, stok barang ini sedang habis!'); 
                window.location='dashboard.php';
              </script>";
    }
} else {
    header("Location:dashboard.php");
}
?>