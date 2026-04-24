<?php
include'../koneksi.php';
$id = $_GET['id'];
$query_anggota = mysqli_query($koneksi,"SELECT*FROM anggota WHERE id_anggota='$id'");
$data_anggota = mysqli_fetch_array($query_anggota);
?>
<h4> 👥 Edit Data Anggota</h4>
<form method="post" action="#" class="mt-3">
    <input value="<?= $data_anggota['nis'] ?>" name="nis" type="number" class="form-control mb-2" placeholder="NIS" required>
    <input value="<?= $data_anggota['nama_anggota'] ?>" name="nama_anggota" type="text" class="form-control mb-2" placeholder="Nama Anggota" required>
    <input value="<?= $data_anggota['username'] ?>" name="username" type="text" class="form-control mb-2" placeholder="Username" required>
    <input value="<?= $data_anggota['password'] ?>" name="password" type="text" class="form-control mb-2" placeholder="Password" required>
    <input value="<?= $data_anggota['kelas'] ?>" name="kelas" type="text" class="form-control mb-2" placeholder="Kelas" required>
    <button name="tombol" type="submit" class="btn btn-primary"> 💾 SIMPAN</button>
</form>
<?php
if(isset($_POST['tombol'])){
    $nis           = $_POST['nis'];
    $nama_anggota  = $_POST['nama_anggota'];
    $username      = $_POST['username'];
    $pass          = $_POST['password'];
    $kelas         = $_POST['kelas'];
    include'../koneksi.php';
    $query = "UPDATE anggota SET nis='$nis',nama_anggota='$nama_anggota',username='$username',password='$pass',kelas='$kelas'";
    $data = mysqli_query($koneksi, $query);
    if($data){
        echo"<script>alert('✅ data tersimpan'); window.location.assign('?halaman=data_anggota');</script>";
    }else{
        echo"<script>alert('😡 data gagal tersimpan'); window.location.assign('?halaman=input_anggota');</script>";
    }
}
?>