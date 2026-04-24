<?php
$server   = "localhost";
$pengguna = "root";
$password = "";
$database = "perpusder";

$koneksi = mysqli_connect($server, $pengguna, $password, $database);

if(!$koneksi){
    echo "Koneksi Error : " . mysqli_connect_error();
}
?>