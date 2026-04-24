<?php
// Taruh logika PHP di atas agar tidak ada error header sent
if(isset($_POST['tombol'])){
    include 'koneksi.php';
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $data = mysqli_query($koneksi, $query);

    if(mysqli_num_rows($data) > 0){
        $data = mysqli_fetch_array($data);
        session_start();
        $_SESSION['id_admin']   = $data['id_admin'];
        $_SESSION['username']   = $data['username'];
        $_SESSION['nama_admin'] = $data['nama_admin'];
        header("Location:admin/dashboard.php");
        exit();
    } else {
        echo "<script>alert('Login Gagal, Username / Password Salah');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Mount Outdoor</title>
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
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            padding: 40px;
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
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.2);
            border-color: #1e3c72;
        }
        .btn-login {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
            color: white;
        }
        .footer-link {
            text-decoration: none;
            color: #2a5298;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.3s;
        }
        .footer-link:hover {
            color: #1e3c72;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <div class="brand-icon">🏔️</div>
        <h4>MOUNT OUTDOOR</h4>
        <p>Administrator Access Control</p>

        <form method="post" action="">
            <div class="text-start">
                <label class="small fw-bold mb-1 text-muted">Username</label>
                <input name="username" class="form-control" placeholder="Masukkan username" required>
                
                <label class="small fw-bold mb-1 text-muted">Password</label>
                <input name="password" type="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="tombol" class="btn btn-login w-100 mb-3">Login Sekarang</button>
            
            <div class="mt-2">
                <a href="login-anggota.php" class="footer-link">Bukan Admin? Login sebagai Peminjam</a>
            </div>
        </form>
    </div>

</body>
</html>