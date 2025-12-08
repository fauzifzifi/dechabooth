<?php
include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'] ?? '';
$cart = $data['cart'] ?? [];

if (!$name || empty($cart)) {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
    exit;
}

// === MULAI TRANSAKSI ===
mysqli_begin_transaction($koneksi);

try {
    $tgl = date("Ymd");

    // LOCK tabel sementara agar kode transaksi tidak bentrok
    $koneksi->query("LOCK TABLES transaksi_jual WRITE, menu WRITE");

    // Ambil kode transaksi terakhir hari ini
    $res = mysqli_fetch_assoc($koneksi->query(
        "SELECT kode_transaksi FROM transaksi_jual WHERE DATE(tanggal)=CURDATE() ORDER BY kode_transaksi DESC LIMIT 1"
    ));

    if ($res && preg_match('/-(\d+)$/', $res['kode_transaksi'], $matches)) {
        $no_urut = (int) $matches[1] + 1;
    } else {
        $no_urut = 1;
    }

    $kode = "TRX-$tgl-" . str_pad($no_urut, 4, "0", STR_PAD_LEFT);

    $total_all = 0; // total transaksi

    foreach ($cart as $id_menu => $item) {
        $qty = (int) $item['qty'];
        $nama = $item['name'];
        $harga = (int) $item['price'];
        $subtotal = $harga * $qty;
        $total_all += $subtotal;

        // cek stok dengan FOR UPDATE
        $cek = $koneksi->query("SELECT stok FROM menu WHERE id_menu=$id_menu FOR UPDATE");
        if ($cek->num_rows === 0)
            throw new Exception("Menu $nama tidak ditemukan");
        $stokRow = $cek->fetch_assoc();
        if ($stokRow['stok'] < $qty)
            throw new Exception("Stok $nama tidak cukup");

        // update stok
        $koneksi->query("UPDATE menu SET stok = stok - $qty WHERE id_menu=$id_menu");

        // insert ke transaksi_jual
        $koneksi->query("INSERT INTO transaksi_jual
            (kode_transaksi,id_menu,nama_menu,qty,harga,subtotal,nama_pembeli,tanggal)
            VALUES('$kode',$id_menu,'$nama',$qty,$harga,$subtotal,'$name',NOW())");
    }

    // UNLOCK tabel & commit
    $koneksi->query("UNLOCK TABLES");
    mysqli_commit($koneksi);

    // === PESAN WA ===
    $msg = "🧾 *PESANAN BARU*\n";
    $msg .= "━━━━━━━━━━━━━━\n";
    $msg .= "Nama: *$name*\n";
    $msg .= "Tanggal: " . date("d-m-Y H:i") . "\n";
    $msg .= "Kode: $kode\n\n";
    $msg .= "📦 *Detail Pesanan:*\n";
    foreach ($cart as $item) {
        $line = $item['price'] * $item['qty'];
        $msg .= "• {$item['name']} x{$item['qty']} = Rp" . number_format($line, 0, ',', '.') . "\n";
    }
    $msg .= "\n━━━━━━━━━━━━━━\n";
    $msg .= "💰 *Total Bayar:* Rp" . number_format($total_all, 0, ',', '.') . "\n";
    $msg .= "\nTerima kasih 🙏";

    echo json_encode([
        "status" => "success",
        "wa_message" => $msg,
        "kode_transaksi" => $kode,
        "total_bayar" => $total_all
    ]);

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    $koneksi->query("UNLOCK TABLES");
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>