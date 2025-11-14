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
    <title>Admin Dashboard | Riwayat Stok</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #9c27b0;
            --primary-light: #9c27b0;
            --primary-dark: #9c27b0;
            --secondary: #9d4edd;
            --accent: #c77dff;
            --light: #f8f7fc;
            --dark: #333333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3f0f8 0%, #e9e4f3 100%);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
            box-shadow: 0 4px 12px rgba(106, 13, 173, 0.2);
            padding: 0;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            color: white !important;
            text-decoration: none;
            padding: 15px 0;
        }

        .navbar-brand i {
            margin-right: 10px;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
            gap: 5px;
        }

        .nav-item {
            margin: 0;
        }

        .nav-link {
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: white !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-link i {
            margin-right: 8px;
            font-size: 1rem;
        }

        .navbar-toggler {
            border: none;
            background: transparent;
            color: white;
            font-size: 1.2rem;
            padding: 5px 10px;
            display: none;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px 0;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .dashboard-title {
            color: var(--primary);
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .dashboard-subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        /* Controls */
        .controls-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .search-box {
            border-radius: 10px;
            border: 1px solid #e1d8f0;
            padding: 12px 20px;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .search-box:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(106, 13, 173, 0.1);
        }

        .filter-dropdown {
            border-radius: 10px;
            border: 1px solid #e1d8f0;
            padding: 12px 20px;
            transition: all 0.3s;
            font-size: 1rem;
            height: auto;
            min-width: 200px;
        }

        .filter-dropdown:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(106, 13, 173, 0.1);
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .table thead {
            background: linear-gradient(to right, var(--primary), var(--primary-light));
        }

        .table thead th {
            border: none;
            padding: 16px 12px;
            font-weight: 600;
            color: white;
            text-align: center;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f9f7ff;
            transform: translateY(-1px);
        }

        .table tbody tr:nth-child(even) {
            background-color: #fcfbff;
        }

        .table td {
            padding: 14px 12px;
            text-align: center;
            vertical-align: middle;
            border-top: 1px solid #f0ebfa;
        }

        /* Badges */
        .badge-perubahan {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .badge-penjualan {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .badge-admin {
            background: #e3f2fd;
            color: #1565c0;
            border: 1px solid #bbdefb;
        }

        /* Footer */
        .footer {
            background: linear-gradient(to right, var(--primary-dark), var(--primary));
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-toggler {
                display: block;
            }

            .navbar-nav {
                flex-direction: column;
                width: 100%;
                display: none;
                gap: 5px;
                margin-top: 10px;
            }

            .navbar-nav.show {
                display: flex;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                justify-content: flex-start;
                border-radius: 5px;
            }

            .dashboard-title {
                font-size: 1.8rem;
            }

            .table-container {
                padding: 15px;
            }

            .table thead th,
            .table td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }

            .controls-section {
                padding: 20px;
            }

            .filter-dropdown {
                min-width: 100%;
                margin-top: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="navbar-container">
            <!-- Brand di kiri -->
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-store"></i> Decha Booth
            </a>

            <!-- Menu di kanan - Horizontal -->
            <button class="navbar-toggler" type="button" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="navbar-nav" id="navbarNav">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_trigger.php">
                        <i class="fas fa-history"></i> Riwayat Stok
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_menu.php">
                        <i class="fas fa-th-large"></i> Menu Admin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-container">
            <!-- Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Riwayat Perubahan Stok</h1>
                <p class="dashboard-subtitle">Pantau semua perubahan stok produk dengan detail lengkap</p>
            </div>

            <!-- Controls -->
            <div class="controls-section">
                <div class="row align-items-center">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <input type="text" id="searchInput" class="form-control search-box"
                            placeholder="Cari menu, tanggal, jenis perubahan...">
                    </div>
                    <div class="col-md-4">
                        <select id="filterChange" class="form-control filter-dropdown">
                            <option value="">Semua Perubahan</option>
                            <option value="penjualan">Perubahan Penjualan</option>
                            <option value="admin">Perubahan Admin</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover" id="logTable">
                        <thead>
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
                        <tbody>
                            <?php
                            $log = mysqli_query($koneksi, "SELECT * FROM log_stok ORDER BY tanggal DESC");
                            $rowCount = mysqli_num_rows($log);

                            if ($rowCount > 0) {
                                while ($row = mysqli_fetch_assoc($log)) {
                                    $badgeClass = $row['perubahan'] == 'penjualan' ? 'badge-penjualan' : 'badge-admin';
                                    $perubahanText = $row['perubahan'] == 'penjualan' ? 'Penjualan' : 'Admin';
                                    echo "<tr>
                                        <td><strong>#{$row['id']}</strong></td>
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
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Decha Booth. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle mobile menu
        document.getElementById('navbarToggle').addEventListener('click', function () {
            const navbarNav = document.getElementById('navbarNav');
            navbarNav.classList.toggle('show');
        });

        // Search functionality
        $('#searchInput').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#logTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Filter functionality
        $('#filterChange').on('change', function () {
            const filter = $(this).val().toLowerCase();
            $('#logTable tbody tr').filter(function () {
                const perubahan = $(this).find('td:nth-child(5)').text().toLowerCase();
                $(this).toggle(filter === "" || perubahan.includes(filter));
            });
        });
    </script>
</body>

</html>
