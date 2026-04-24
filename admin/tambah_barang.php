<?php
session_start();
include '../koneksi.php';

// Proses Simpan Data
if (isset($_POST['simpan'])) {
    $nama    = $_POST['nama_barang'];
    $jenis   = $_POST['jenis'];
    $kondisi = $_POST['kondisi'];
    $jumlah  = $_POST['jumlah'];
    $status  = $_POST['status'];

    // Kelola Upload Foto
    $foto_nama = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];
    $folder    = "../img_barang/";

    if (!empty($foto_nama)) {
        // Pindahkan file ke folder img_barang
        move_uploaded_file($tmp_name, $folder . $foto_nama);
        $foto_db = $foto_nama;
    } else {
        // Jika tidak upload, sesuaikan dengan logika dashboard (tenda.jpg / kompor.jpg)
        $foto_db = "default.jpg"; 
    }

    $query = "INSERT INTO barang (nama_barang, jenis, kondisi, jumlah, status, foto) 
              VALUES ('$nama', '$jenis', '$kondisi', '$jumlah', '$status', '$foto_db')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Barang Berhasil Ditambah!'); window.location='data_barang.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Alat | Mount Outdoor</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-tambah { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-simpan { background: #1e3c72; color: white; border-radius: 10px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-tambah p-4">
                <h3 class="fw-bold text-center mb-4">🏔️ Tambah Alat Baru</h3>
                <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="fw-bold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Tenda Eiger 4 Orang" required>
                    </div>

                    <div class="mb-3">
    <label class="fw-bold">Jenis Alat</label>
    <select name="jenis" class="form-select" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="Tenda">⛺ Tenda</option>
        <option value="Kompor">🔥 Kompor / Nesting</option>
        <option value="Sepatu">👟 Sepatu Gunung</option>
        <option value="Carrier">🎒 Tas Carrier</option>
        <option value="Tongkat">🦯 Tracking Pole (Tongkat)</option>
        <option value="Lampu">🔦 Senter / Headlamp</option>
        <option value="Hammock">🛌 Hammock / Matras</option>
        <option value="Lainnya">📦 Lain-lain</option>
    </select>
</div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Kondisi</label>
                            <select name="kondisi" class="form-select">
                                <option value="Bagus">Bagus</option>
                                <option value="Lecet Pemakaian">Lecet Pemakaian</option>
                                <option value="Baru">Baru</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">Jumlah Stok</label>
                            <input type="number" name="jumlah" class="form-control" value="1" min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Status Awal</label>
                        <select name="status" class="form-select">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold">Upload Foto Barang</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Gunakan file .jpg atau .png (Contoh: tenda.jpg)</small>
                    </div>

                    <button type="submit" name="simpan" class="btn btn-simpan w-100 p-2 fw-bold">💾 Simpan ke Database</button>
                    <a href="dashboard_admin.php" class="btn btn-light w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>