<?php
// Taruh logika PHP di paling atas
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    
    // Ambil data dan amankan
    $nik            = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_anggota   = mysqli_real_escape_string($koneksi, $_POST['nama_anggota']);
    $username       = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password       = mysqli_real_escape_string($koneksi, $_POST['password']);
    $telepon        = mysqli_real_escape_string($koneksi, $_POST['telepon']);

    // Sesuaikan query dengan nama kolom di database kamu
    // Pastikan di database, nama kolom 'nis' diganti 'nik' dan 'kelas' diganti 'telepon' (atau tetap pakai nama lama tapi isinya nomor hp)
    $query = "INSERT INTO anggota(nis, nama_anggota, username, password, kelas) VALUES('$nik', '$nama_anggota', '$username', '$password', '$telepon')";
    $data = mysqli_query($koneksi, $query);

    if($data){
        session_start();
        $_SESSION['id_anggota']   = mysqli_insert_id($koneksi);
        $_SESSION['username']     = $username;
        $_SESSION['nama_anggota'] = $nama_anggota;
        echo "<script>alert('✅ Pendaftaran Berhasil! Selamat bergabung di Mount Outdoor.'); window.location.assign('anggota/dashboard.php');</script>";
    } else {
        echo "<script>alert('❌ Pendaftaran Gagal! Silakan coba lagi.'); window.location.assign('pendaftaran-anggota.php');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gabung Member | Mount Outdoor</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            padding: 35px;
        }
        .brand-icon { font-size: 40px; text-align: center; margin-bottom: 10px; }
        .register-card h4 { font-weight: 700; color: #1e3c72; text-align: center; }
        .register-card p { color: #666; font-size: 0.9rem; text-align: center; margin-bottom: 25px; }
        
        .form-label { font-size: 0.85rem; font-weight: 600; color: #555; }
        .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        .btn-register {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
            color: white;
        }
        .footer-link {
            text-decoration: none;
            color: #2a5298;
            font-size: 0.85rem;
            display: inline-block;
            margin-top: 10px;
        }
        .footer-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="brand-icon">🎒</div>
        <h4>DAFTAR MEMBER</h4>
        <p>Lengkapi data untuk mulai menyewa alat.</p>

        <form method="post" action="">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Nomor Identitas (NIK)</label>
                    <input name="nik" type="number" class="form-control" placeholder="Contoh: 3201..." required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Nama Lengkap</label>
                    <input name="nama_anggota" type="text" class="form-control" placeholder="Nama sesuai KTP" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" placeholder="Untuk login" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Nomor WhatsApp</label>
                    <input name="telepon" type="text" class="form-control" placeholder="0812..." required>
                </div>
            </div>

            <button type="submit" name="tombol" class="btn btn-register w-100">Buat Akun Member</button>
            
            <div class="text-center mt-3">
                <a href="login-anggota.php" class="footer-link">Sudah punya akun? Login di sini</a>
            </div>
        </form>
    </div>

</body>
</html>