<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mount Outdoor | Adventure Starts Here</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { height: 100%; font-family: 'Segoe UI', sans-serif; }
        
        /* Background Hero dengan Gambar Gunung */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }

        .card-login {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            transition: 0.3s;
        }

        .card-login:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-outdoor {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logo-text { font-size: 2.5rem; letter-spacing: 3px; }
    </style>
</head>
<body>

<div class="hero-section">
    <div class="container text-center">
        <div class="mb-5">
            <h1 class="fw-bold logo-text">🏔️ MOUNT OUTDOOR</h1>
            <p class="lead">Penyedia perlengkapan pendakian terbaik untuk petualanganmu berikutnya.</p>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-md-4">
                <div class="card card-login p-4 h-100">
                    <div class="display-4 mb-3">🥾</div>
                    <h3 class="fw-bold">ANGGOTA</h3>
                    <p class="small text-light">Cari dan sewa alat outdoor favoritmu dengan mudah.</p>
                    <a href="login-anggota.php" class="btn btn-primary btn-outdoor mt-auto">Sewa Alat</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-login p-4 h-100">
                    <div class="display-4 mb-3">🛠️</div>
                    <h3 class="fw-bold">ADMINISTRATOR</h3>
                    <p class="small text-light">Pusat kendali inventaris dan transaksi transaksi.</p>
                    <a href="login-admin.php" class="btn btn-outline-light btn-outdoor mt-auto">Kelola Web</a>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-5">
            <p class="small opacity-75">© 2026 Mount Outdoor System - Crafted with Passion</p>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>