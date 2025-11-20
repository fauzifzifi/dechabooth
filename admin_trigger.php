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

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- slick slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" />
    <!-- fonts style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />
    <!-- font awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />

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
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        .btn {
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: bold;
            border: none;
            margin-top: 5px;
        }

        /* Main Content */
        .main-content {
            flex: 1;

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
            background: #ffffffe6;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(186, 104, 200, 0.3);
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #DDA0DD;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #6f1089d0;
            box-shadow: 0 0 10px rgba(75, 0, 130, 0.3);
        }

        .filter-dropdown {
            border-radius: 10px;
            border: 2px solid #DDA0DD;
            transition: border-color 0.3s ease;
            font-size: 1rem;
        }

        .filter-dropdown:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(106, 13, 173, 0.1);
        }

        /* Table */
        .table-container {
            background: #ffffffe6;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(186, 104, 200, 0.3);
            padding: 20px;
            margin-bottom: 20px;
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(221, 160, 221, 0.2);
        }

        .table thead th {
            background: #6f1089d0;
            color: white;
            border: none;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background: #F8F8FF;
        }

        .table tbody tr:hover {
            background: #E6E6FA;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        /* Badges */
        .badge-perubahan {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            align-items: center;
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

        /* Responsive */
        @media (max-width: 768px) {
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

<body class="sub_page">
    <div class="hero_area">
        <!-- header section -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand">
                        <i class="bi bi-person-gear"></i>
                        Admin Pages
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent">
                        <span class=""> </span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="admin_menu.php">
                                    <i class="bi bi-speedometer2 me-2"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_menu.php">
                                    <i class="bi bi-box me-2"></i>
                                    Kelola Menu
                                </a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="admin_trigger.php">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Riwayat Stok
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-danger" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
    </div>

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
                    <div class="col-md-8 mb-3 mb-md-0 form-group">
                        <input type="text" id="searchInput" class="form-control"
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
                    <table class="table table-bordered table-hover" id="logTable">
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

    <!-- footer section -->
    <footer class="container-fluid footer_section">
        <div class="container">
            <div class="col-md-11 col-lg-8 mx-auto">
                <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth
                </p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="js/custom.js"></script>
    <script>
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