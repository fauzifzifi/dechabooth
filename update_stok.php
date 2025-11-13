<?php
include 'koneksi.php'; // pastikan koneksi sudah benar

// Ambil data JSON dari fetch()
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data)) {
    foreach ($data as $item) {
        $nama_menu = mysqli_real_escape_string($koneksi, $item['name']);
        $qty = (int) $item['qty'];

        // Kurangi stok menu di database
        $query = "UPDATE menu SET stok = stok - $qty WHERE nama_menu = '$nama_menu' AND stok >= $qty";
        mysqli_query($koneksi, $query);
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "no_data"]);
}
?>