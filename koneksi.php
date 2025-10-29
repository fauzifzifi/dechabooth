<?php
$koneksi = mysqli_connect("localhost", "root", "", "decha_booth");

if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
