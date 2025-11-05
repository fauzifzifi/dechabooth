<?php
// koneksi.php
$host = "localhost";
$user = "root";
$pass = "";  // Kosongkan jika default XAMPP
$db = "decha_booth";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>