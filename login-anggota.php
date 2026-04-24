<?php
// Logika PHP ditaruh di paling atas
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    // Gunakan real_escape_string agar lebih aman dari hacker
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM anggota WHERE username='$username' AND password='$password'";
    $data = mysqli_query($koneksi, $query);

    if(mysqli_num_rows($data) > 0){
        $data = mysqli_fetch_array($data);
        session_start();
        $_SESSION['id_anggota']   = $data['id_anggota'];
        $_SESSION['username']     = $data['username'];
        $_SESSION['nama_anggota'] = $data['nama_anggota'];

        header("Location:anggota/dashboard.php");
        exit();
    } else {
        echo "<script>alert('Login Gagal, Username / Password Salah'); window.location.assign('login-anggota.php');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penyewa | Mount Outdoor</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
        }
        .brand-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .login-card h4 {
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 5px;
        }
        .login-card p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .btn-login {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); /* Warna hijau sukses biar beda sama admin */
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }
        .footer-links {
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .footer-link {
            text-decoration: none;
            color: #2a5298;
            font-size: 0.85rem;
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
            transition: 0.3s;
        }
        .footer-link:hover {
            color: #1e3c72;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-icon">🏕️</div>
        <h4>LOGIN PENYEWA</h4>
        <p>Jelajahi petualanganmu bersama kami!</p>

        <form method="post" action="">
            <div class="text-start">
                <label class="small fw-bold mb-1 text-muted">Username</label>
                <input name="username" type="text" class="form-control" placeholder="Masukkan username" required>
                
                <label class="small fw-bold mb-1 text-muted">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="tombol" class="btn btn-login w-100 mb-2">Masuk Sekarang</button>
            
            <div class="footer-links">
                <a href="login-admin.php" class="footer-link">💻 Login Sebagai Pemilik (Admin)</a>
                <a href="pendaftaran-anggota.php" class="footer-link">👥 Belum punya akun? Daftar Member</a>
            </div>
        </form>
    </div>

</body>
</html>