<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Order | Admin</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/admin.css" rel="stylesheet" />

</head>

<body>

    <!-- SIDEBAR -->
    <aside class="az-sidebar" id="azSidebar" aria-label="Sidebar Admin">
        <button class="az-sidebar-close" id="azSidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="az-sidebar-header">
            <div class="az-brand">
                <img src="images/logo.png" class="az-brand-logo" alt="Logo">
                <div class="az-brand-text">Decha Booth</div>
            </div>
        </div>

        <nav class="az-nav">
            <ul>
                <li><a href="admin_menu.php"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a></li>
                <li><a href="manage_menu.php"><i class="bi bi-box me-2"></i><span>Kelola Menu</span></a></li>
                <li><a href="admin_trigger.php"><i class="bi bi-clock-history me-2"></i><span>Riwayat Stok</span></a>
                </li>

                <li><a href="admin_contact.php"><i class="bi bi-envelope-paper me-2"></i><span>Riwayat Pesan</span></a>
                </li>

                <!-- MENU BARU DI SINI -->
                <li class="active"><a href="admin_order.php"><i class="bi bi-receipt-cutoff me-2"></i><span>Riwayat
                            Order</span></a></li>
                <li><a class="az-btn-logout" href="logout.php"><i
                            class="bi bi-box-arrow-right me-2"></i><span>Logout</span></a></li>
            </ul>
        </nav>
    </aside>

    <div class="az-sidebar-overlay" id="azSidebarOverlay"></div>

    <!-- NAVBAR MOBILE -->
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

    <main class="az-main-content">
        <div class="container-fluid mt-3">
            <h3 class="mb-4 fw-bold" align="center">Riwayat Orderan Pelanggan</h3>

            <!-- TABLE -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered" id="logTable">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nama Menu</th>
                                <th>Stok Lama</th>
                                <th>Stok Baru</th>
                                <th>Perubahan</th>
                                <th>Qty</th>
                                <th>Harga (Rp)</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            // Ambil riwayat order
                            $orders = mysqli_query($koneksi, "SELECT * FROM transaksi_jual ORDER BY tanggal_jual DESC");
                            $rowCount = mysqli_num_rows($orders);
                            if ($rowCount) {
                                while ($row = mysqli_fetch_assoc($orders)) {
                                    echo "<tr>
                                        <td>{$row['nama_menu']}</td>
                                        <td>{$row['stok_lama']}</td>
                                        <td><strong>{$row['stok_baru']}</strong></td>
                                        <td>{$row['qty']}</td>
                                        <td>" . number_format($row['harga'], 0, ',', '.') . "</td>
                                        <td>{$row['tanggal']}</td>
                                    </tr>";
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada riwayat perubahan stok</p>
                                </td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/admin.js"></script>

</body>

</html>