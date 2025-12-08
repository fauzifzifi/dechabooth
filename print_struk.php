<?php
include "koneksi.php";

$kode = $_GET['kode'] ?? '';

if (!$kode)
    die("Kode transaksi tidak ditemukan!");

$q = $koneksi->query("SELECT * FROM transaksi_jual WHERE kode_transaksi='$kode'");
if ($q->num_rows == 0)
    die("Transaksi tidak ditemukan!");

$items = [];
$total = 0;
$first = null;

while ($r = $q->fetch_assoc()) {
    if (!$first)
        $first = $r;
    $items[] = $r;
    $total += $r['subtotal'];
}

$tgl = date("d/m/Y H:i", strtotime($first['tanggal']));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk - <?= $kode ?></title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        /* ==== AREA STRUK ==== */
        #strukArea {
            width: 200px;
            padding: 10px;
            font-size: 11px;
            font-family: Arial, sans-serif;
            line-height: 1.25;
            margin: auto;
            background: white;

            /* anti ketumpuk */
            overflow: hidden;
        }

        .center {
            text-align: center;
        }

        .logo {
            width: 55px;
            margin: auto;
            display: block;
        }

        .line {
            border-top: 1px dashed black;
            margin: 8px 0;
        }

        .item {
            margin-bottom: 6px;
        }

        /* Anti putus halaman html2canvas */
        * {
            page-break-inside: avoid;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            #strukArea {
                width: 200px;
            }
        }
    </style>
</head>

<body>

    <div id="strukArea">

        <div class="center">
            <img src="images/logo.png" class="logo">
            <div style="font-size:14px; font-weight:bold;">DECHA BOOTH</div>
            <div>0823-3688-1878</div>
        </div>

        <div class="line"></div>

        <b>Kode:</b> <?= $kode ?><br>
        <b>Tanggal:</b> <?= $tgl ?><br>
        <b>Pembeli:</b> <?= $first['nama_pembeli'] ?><br>

        <div class="line"></div>

        <?php foreach ($items as $i): ?>
            <div class="item">
                <?= $i['nama_menu'] ?><br>
                <?= $i['qty'] ?> x Rp <?= number_format($i['harga'], 0, ',', '.') ?><br>
                <b>Rp <?= number_format($i['subtotal'], 0, ',', '.') ?></b>
            </div>
        <?php endforeach; ?>

        <div class="line"></div>

        <b>Total: Rp <?= number_format($total, 0, ',', '.') ?></b>

        <div class="line"></div>

        <div class="center" style="margin-top:5px;">Terima kasih telah berbelanja di <br>Decha Booth!</div>

    </div>

    <br><br>

    <div class="center no-print">
        <button onclick="window.print()">🖨 PRINT STRUK</button>
        <button onclick="downloadPDF()">📄 DOWNLOAD PDF</button>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('strukArea');

            const opt = {
                margin: 0,
                filename: 'Struk_<?= $kode ?>.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: {
                    scale: 4,           // sangat tajam (tidak blur)
                    useCORS: true,
                    letterRendering: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: [58, 200],  // ukuran thermal 58mm
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>

</body>

</html>