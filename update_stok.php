<?php
include 'koneksi.php';

// Ambil data JSON dari fetch()
$data = json_decode(file_get_contents("php://input"), true);

$response = [];

if (!empty($data)) {
    // Siapkan prepared statement untuk mengurangi stok
    $stmtKurangi = $koneksi->prepare("UPDATE menu SET stok = stok - ? WHERE nama_menu = ? AND stok >= ?");
    if (!$stmtKurangi) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $koneksi->error]);
        exit;
    }

    // Siapkan prepared statement untuk menambah stok
    $stmtTambah = $koneksi->prepare("UPDATE menu SET stok = stok + ? WHERE nama_menu = ?");
    if (!$stmtTambah) {
        echo json_encode(["status" => "error", "message" => "Prepare failed (tambah): " . $koneksi->error]);
        exit;
    }

    foreach ($data as $item) {
        $nama_menu = $item['name'];
        $qty = (int) $item['qty'];
        $action = $item['action'] ?? 'kurangi'; // default: kurangi

        if ($action === 'tambah') {
            $stmtTambah->bind_param("is", $qty, $nama_menu);
            $stmtTambah->execute();

            if ($stmtTambah->affected_rows > 0) {
                $response[] = [
                    "name" => $nama_menu,
                    "qty" => $qty,
                    "status" => "success",
                    "action" => "tambah"
                ];
            } else {
                $response[] = [
                    "name" => $nama_menu,
                    "qty" => $qty,
                    "status" => "failed",
                    "action" => "tambah",
                    "message" => "Menu tidak ditemukan"
                ];
            }
        } else {
            // Kurangi stok
            $stmtKurangi->bind_param("isi", $qty, $nama_menu, $qty);
            $stmtKurangi->execute();

            if ($stmtKurangi->affected_rows > 0) {
                $response[] = [
                    "name" => $nama_menu,
                    "qty" => $qty,
                    "status" => "success",
                    "action" => "kurangi"
                ];
            } else {
                $response[] = [
                    "name" => $nama_menu,
                    "qty" => $qty,
                    "status" => "failed",
                    "action" => "kurangi",
                    "message" => "Stok tidak cukup atau menu tidak ditemukan"
                ];
            }
        }
    }

    $stmtKurangi->close();
    $stmtTambah->close();

    echo json_encode([
        "status" => "completed",
        "results" => $response
    ]);
} else {
    echo json_encode(["status" => "no_data"]);
}
?>