<?php
include '../koneksi.php';
$id_log = $_SESSION['id_anggota']; // Ambil ID dari session login
$ambil  = mysqli_query($koneksi, "SELECT * FROM anggota WHERE id_anggota='$id_log'");
$user   = mysqli_fetch_array($ambil);
?>

<div class="card p-4 shadow-sm border-0">
    <h4 class="fw-bold mb-4">⚙️ Pengaturan Profil</h4>
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <?php 
                $pic = !empty($user['foto']) ? "../assets/img/anggota/".$user['foto'] : "../assets/img/default-user.png";
                ?>
                <img src="<?= $pic ?>" class="rounded-circle img-thumbnail mb-3" width="150" height="150" style="object-fit:cover;">
                <input type="file" name="foto" class="form-control form-control-sm">
                <small class="text-muted">Pilih foto profil baru</small>
            </div>
            <div class="col-md-8">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control mb-2" value="<?= $user['nama_anggota'] ?>">
                
                <label>Username</label>
                <input type="text" name="user" class="form-control mb-2" value="<?= $user['username'] ?>">
                
                <label>Password Baru</label>
                <input type="password" name="pass" class="form-control mb-3" placeholder="Kosongkan jika tidak ganti">
                
                <button name="save_profile" class="btn btn-primary w-100 fw-bold">💾 SIMPAN PERUBAHAN</button>
            </div>
        </div>
    </form>
</div>

<?php
if(isset($_POST['save_profile'])){
    $nama = $_POST['nama'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $nama_foto = $_FILES['foto']['name'];
    $lokasi    = $_FILES['foto']['tmp_name'];

    // Jika upload foto baru
    if(!empty($lokasi)){
        move_uploaded_file($lokasi, "../assets/img/anggota/".$nama_foto);
        $query_foto = ", foto='$nama_foto'";
    } else {
        $query_foto = "";
    }

    // Jika ganti password
    $query_pass = !empty($pass) ? ", password='$pass'" : "";

    $update = mysqli_query($koneksi, "UPDATE anggota SET 
              nama_anggota='$nama', username='$user' $query_foto $query_pass 
              WHERE id_anggota='$id_log'");

    if($update){
        echo "<script>alert('Profil Berhasil Diperbarui!'); window.location='dashboard.php?halaman=profile';</script>";
    }
}
?>