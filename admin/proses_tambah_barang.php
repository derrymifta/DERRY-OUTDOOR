<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_barang'];
    $jenis = $_POST['jenis'];
    $kondisi = $_POST['kondisi'];
    
    // Proses Gambar
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    
    // Beri nama unik agar gambar tidak bentrok (contoh: 23042026tenda.jpg)
    $foto_baru = date('dmYHis').$foto;
    $path = "../img_barang/".$foto_baru;

    if (move_uploaded_file($tmp, $path)) {
        // Query Simpan
        $sql = "INSERT INTO barang (nama_barang, jenis, kondisi, status, foto) 
                VALUES ('$nama', '$jenis', '$kondisi', 'Tersedia', '$foto_baru')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>alert('Data Berhasil Disimpan!'); window.location='dashboard.php?halaman=data_barang';</script>";
        } else {
            echo "Gagal simpan ke database: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Gagal upload gambar!'); window.location='dashboard.php?halaman=input_barang';</script>";
    }
}
?>