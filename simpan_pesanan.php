<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST["nama_pelanggan"]);
    $total = floatval($_POST["total_harga"]);
    $cart = json_decode($_POST["cart"], true);

    // Simpan ke tabel pesanan
    $query = "INSERT INTO pesanan (nama_pelanggan, total_harga) VALUES ('$nama', '$total')";
    if (mysqli_query($koneksi, $query)) {
        $id_pesanan = mysqli_insert_id($koneksi);

        // Kurangi stok menu berdasarkan pesanan
        foreach ($cart as $nama_menu => $item) {
            $qty = intval($item["qty"]);
            $update = "UPDATE menu SET stok = GREATEST(stok - $qty, 0) WHERE nama_menu = '$nama_menu'";
            mysqli_query($koneksi, $update);
        }

        echo "success";
    } else {
        echo "error: " . mysqli_error($koneksi);
    }
}
?>