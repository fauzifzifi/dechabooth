<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
include 'koneksi.php';

// ===================== HAPUS TRANSAKSI =====================
if (isset($_GET['delete'])) {
    $kode = $_GET['delete'];

    // Hapus semua item yang memiliki kode ini
    $koneksi->query("DELETE FROM transaksi_jual WHERE kode_transaksi='$kode'");

    // Redirect agar tidak repeat delete saat refresh
    header("Location: admin_order.php?hapus=success");
    exit;
}

// === FILTER ===
$search = isset($_GET['search']) ? $_GET['search'] : '';
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

$where = "WHERE 1=1";

if ($search != '') {
    $where .= " AND (kode_transaksi LIKE '%$search%' OR nama_pembeli LIKE '%$search%' OR nama_menu LIKE '%$search%')";
}

if ($tgl_awal != '' && $tgl_akhir != '') {
    $where .= " AND DATE(tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$query = "
    SELECT 
    kode_transaksi,
    nama_pembeli,
    tanggal,
    SUM(subtotal) AS total,
    CONCAT('<ul>', GROUP_CONCAT(CONCAT('<li>', nama_menu, ' x', qty, '</li>') SEPARATOR ''), '</ul>') AS detail_menu
FROM transaksi_jual
GROUP BY kode_transaksi, nama_pembeli, tanggal
ORDER BY kode_transaksi DESC
";
$orders = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Riwayat Order | Admin</title>

    <!-- bootstrap core css (your local file) -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />
    <!-- font awesome (if used) -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- responsive (keep if you have) -->
    <link href="css/responsive.css" rel="stylesheet" />

    <!-- ADMIN CSS (must be last so it overrides older rules) -->
    <link href="css/admin.css" rel="stylesheet" />

    <!-- Alert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- ================= SIDEBAR ================= -->
    <aside class="az-sidebar" id="azSidebar" aria-label="Sidebar Admin">
        <button class="az-sidebar-close" id="azSidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="az-sidebar-header">
            <div class="az-brand">
                <img src="images/logo.png" class="az-brand-logo">
                <div class="az-brand-text">Decha Booth</div>
            </div>
        </div>

        <nav class="az-nav">
            <ul>
                <li><a href="admin_menu.php"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a>
                </li>
                <li><a href="manage_menu.php"><i class="bi bi-box me-2"></i><span>Kelola Menu</span></a></li>
                <li><a href="admin_trigger.php"><i class="bi bi-clock-history me-2"></i><span>Riwayat Stok</span></a>
                </li>
                <li><a href="admin_contact.php"><i class="bi bi-envelope me-2"></i><span>Ulasan Pelanggan</span></a>
                </li>
                <li class="active"><a href="admin_order.php"><i class="bi bi-receipt-cutoff me-2"></i><span>Riwayat
                            Order</span></a></li>
                <li><a class="az-btn-logout" href="logout.php"><i
                            class="bi bi-box-arrow-right me-2"></i><span>Logout</span></a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="az-sidebar-overlay" id="azSidebarOverlay"></div>

    <!-- ================= NAVBAR MOBILE ================= -->
    <header class="az-mobile-navbar">
        <div class="az-mobile-left">
            <div class="az-mobile-brand">Decha Booth</div>
        </div>
        <div class="az-mobile-right">
            <button id="azSidebarToggle" class="az-toggler">
                <span class="az-toggler-line"></span>
                <span class="az-toggler-line"></span>
                <span class="az-toggler-line"></span>
            </button>
        </div>
    </header>

    <!-- ================= MAIN ================= -->
    <main class="az-main-content" id="azMainContent" role="main">
        <div class="container-fluid mt-3 main-wrapper">

            <div class="dashboard-header">
                <h1 class="dashboard-title">Riwayat Order</h1>
                <p class="dashboard-subtitle">Pencatatan seluruh transaksi jual dan pembuatan struk</p>
            </div>

            <!-- FILTER SECTION  -->
            <section class="product_section card mb-4 container-fluid mt-3">
                <div class="container container-fluid">
                    <div class="container-fluid">

                        <form method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Cari Kode / Nama Pembeli / Menu</label>
                                <input type="text" name="search" class="form-control" value="<?= $search ?>"
                                    placeholder="Masukkan kata kunci...">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?>">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?>">
                            </div>

                            <button type="submit" class="btn btn-secondary">
                                Filter
                            </button>

                            <button type="reset" class="btn btn-secondary">
                                Reset
                            </button>
                        </form>

                    </div>
                </div>
            </section>


            <!-- TABLE -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="orderTable">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">Kode</th>
                                <th>Nama Pembeli</th>
                                <th class="align-middle">Detail Pesanan</th>
                                <th class="align-middle">Total</th>
                                <th class="align-middle">Tanggal</th>
                                <th class="align-middle">Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($orders) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($orders)): ?>
                                    <tr>
                                        <td><?= $row['kode_transaksi'] ?></td>
                                        <td><?= $row['nama_pembeli'] ?></td>
                                        <td class="text-left"><?= $row['detail_menu'] ?></td>
                                        <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td>
                                            <a href="print_struk.php?kode=<?= $row['kode_transaksi'] ?>" target="_blank"
                                                class="btn btn-sm btn-warning">Print</a>

                                            <button class="btn btn-danger btn-sm"
                                                onclick="hapusTransaksi('<?= $row['kode_transaksi'] ?>')">Delete
                                            </button>

                                        </td>
                                    </tr>

                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted p-4">Belum ada transaksi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- footer section -->
        <footer class="container-fluid footer_section">
            <div class="container">
                <div class="col-md-11 col-lg-8 mx-auto">
                    <p>&copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth</p>
                </div>
            </div>
        </footer>
        <!-- footer section -->
    </main>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/admin.js"></script>

    <script>
        // display year
        document.getElementById('displayYear').textContent = new Date().getFullYear();

        // Hapus Transaksi
        function hapusTransaksi(kode) {
            Swal.fire({
                title: "Hapus Transaksi?",
                text: "Transaksi dengan kode " + kode + " akan dihapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                confirmButtonColor: "#7b2cbf"
            }).then((res) => {
                if (res.isConfirmed) {
                    window.location = "admin_order.php?delete=" + kode;
                }
            });
        }

        <?php if (isset($_GET['hapus']) && $_GET['hapus'] == 'success'): ?>
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "Transaksi berhasil dihapus.",
                confirmButtonText: "Ok",
                confirmButtonColor: "#7b2cbf"
            }).then(() => {
                // Hapus parameter ?hapus=success dari URL tanpa reload
                if (window.history.replaceState) {
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }
            });
        <?php endif; ?>
    </script>

</body>

</html>