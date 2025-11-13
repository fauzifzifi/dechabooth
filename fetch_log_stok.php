<?php
include 'koneksi.php';

$log = mysqli_query($koneksi, "SELECT * FROM log_stok ORDER BY tanggal DESC");
$data = [];

while ($row = mysqli_fetch_assoc($log)) {
    $row['badge'] = $row['perubahan'] == 'penjualan' ? 'badge-penjualan' : 'badge-admin';
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>