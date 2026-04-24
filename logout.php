<?php
// Memulai session
session_start();

// Menghapus semua data session yang tersimpan
session_destroy();

// Mengarahkan pengguna kembali ke halaman login anggota
// Gunakan jalur yang sesuai dengan letak file logout.php kamu
header("location:login-anggota.php");
exit();
?>