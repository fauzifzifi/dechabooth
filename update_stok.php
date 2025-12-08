<?php
include 'koneksi.php';

// Ambil JSON dari request
$data = json_decode(file_get_contents("php://input"), true);

// Jika tidak ada data → hentikan
if (empty($data)) {
    echo json_encode([
        "status" => "error",
        "message" => "Tidak ada data dikirim"
    ]);
    exit;
}

/*
FORMAT DATA YANG DIHARAPKAN DARI ADMIN:

[
  { "id_menu": 1, "qty": 5, "action": "tambah" },
  { "id_menu": 2, "qty": 2, "action": "kurangi" }
]

action:
- tambah  -> stok bertambah (restock)
- kurangi -> stok dikurangi (untuk koreksi stok admin)
*/

$response = [];

foreach ($data as $item) {

    $id_menu = (int) $item['id_menu'];
    $qty = (int) $item['qty'];
    $action = $item['action'] ?? 'kurangi';

    if ($qty <= 0) {
        $response[] = [
            "id_menu" => $id_menu,
            "qty" => $qty,
            "status" => "failed",
            "message" => "Qty tidak valid"
        ];
        continue;
    }

    // Ambil stok sekarang
    $query = $koneksi->query("SELECT stok FROM menu WHERE id_menu = $id_menu");
    if ($query->num_rows === 0) {
        $response[] = [
            "id_menu" => $id_menu,
            "qty" => $qty,
            "status" => "failed",
            "message" => "Menu tidak ditemukan"
        ];
        continue;
    }

    $current_stok = (int) $query->fetch_assoc()['stok'];

    // Tentukan update stok
    if ($action === "tambah") {
        $new_stok = $current_stok + $qty;
        $koneksi->query("UPDATE menu SET stok = $new_stok WHERE id_menu = $id_menu");

        $response[] = [
            "id_menu" => $id_menu,
            "qty" => $qty,
            "status" => "success",
            "action" => "tambah"
        ];

    } else { // kurangi

        // Cegah stok negatif
        if ($qty > $current_stok) {
            $response[] = [
                "id_menu" => $id_menu,
                "qty" => $qty,
                "status" => "failed",
                "message" => "Stok tidak mencukupi"
            ];
            continue;
        }

        $new_stok = $current_stok - $qty;
        $koneksi->query("UPDATE menu SET stok = $new_stok WHERE id_menu = $id_menu");

        $response[] = [
            "id_menu" => $id_menu,
            "qty" => $qty,
            "status" => "success",
            "action" => "kurangi"
        ];
    }
}

echo json_encode([
    "status" => "completed",
    "results" => $response
]);
?>