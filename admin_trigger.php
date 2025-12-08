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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok | Admin</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

    <!-- Custom Admin Layout -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="az-sidebar" id="azSidebar" aria-label="Sidebar Admin">
        <button class="az-sidebar-close" id="azSidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="az-sidebar-header">
            <div class="az-brand">
                <img src="images/logo.png" class="az-brand-logo" alt="Decha Booth Logo">
                <div class="az-brand-text">Decha Booth</div>
            </div>
        </div>

        <nav class="az-nav">
            <ul>
                <li><a href="admin_menu.php"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a>
                </li>
                <li><a href="manage_menu.php"><i class="bi bi-box me-2"></i><span>Kelola Menu</span></a></li>
                <li class="active"><a href="admin_trigger.php"><i class="bi bi-clock-history me-2"></i><span>Riwayat
                            Stok</span></a>
                </li>
                <li><a href="admin_contact.php"><i class="bi bi-envelope me-2"></i><span>Ulasan Pelanggan</span>
                        </span></a></li>
                <li><a href="admin_order.php"><i class="bi bi-receipt-cutoff me-2"></i><span>Riwayat Order</span></a>
                </li>
                <li><a class="az-btn-logout" href="logout.php"><i
                            class="bi bi-box-arrow-right me-2"></i><span>Logout</span></a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- OVERLAY MOBILE -->
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

    <!-- MAIN CONTENT -->
    <main class="az-main-content" id="azMainContent">
        <div class="container-fluid mt-3 main-wrapper">
            <!-- HEADER -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Riwayat Perubahan Stok</h1>
                <p class="dashboard-subtitle">Pantau semua perubahan stok produk dengan detail lengkap</p>
            </div>

            <!-- SEARCH + FILTER -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0 form-group">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari menu, tanggal, jenis perubahan...">
                    </div>
                    <div class="col-md-4">
                        <select id="filterChange" class="form-control">
                            <option value="">Semua Perubahan</option>
                            <option value="penjualan">Perubahan Penjualan</option>
                            <option value="admin">Perubahan Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered" id="logTable">
                        <thead class="text-center">
                            <tr>
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
                            $log = mysqli_query($koneksi, "SELECT * FROM log_stok ORDER BY tanggal DESC");
                            $rowCount = mysqli_num_rows($log);

                            if ($rowCount > 0) {
                                while ($row = mysqli_fetch_assoc($log)) {
                                    $badgeClass = $row['perubahan'] == 'penjualan' ? 'badge-penjualan' : 'badge-admin';
                                    $perubahanText = $row['perubahan'] == 'penjualan' ? 'Penjualan' : 'Admin';
                                    echo "<tr>
                                        <td>{$row['nama_menu']}</td>
                                        <td>{$row['stok_lama']}</td>
                                        <td><strong>{$row['stok_baru']}</strong></td>
                                        <td><span class='badge-perubahan $badgeClass'>$perubahanText</span></td>
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

    <!-- JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- admin.js (your custom logic) -->
    <script src="js/admin.js"></script>

    <!-- Search & Filter -->
    <script>
        $('#searchInput').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#logTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#filterChange').on('change', function () {
            const filter = $(this).val().toLowerCase();
            $('#logTable tbody tr').filter(function () {
                const perubahan = $(this).find('td:nth-child(5)').text().toLowerCase();
                $(this).toggle(filter === "" || perubahan.includes(filter));
            });
        });

        // display year
        document.getElementById('displayYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>