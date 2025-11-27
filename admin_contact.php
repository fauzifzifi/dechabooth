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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pesan | Admin</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

    <!-- font awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles -->
    <link href="css/admin.css" rel="stylesheet" />

    <!-- responsive style -->
    <link href="css/responsive.css" rel="stylesheet" />
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
                <li><a href="admin_trigger.php"><i class="bi bi-clock-history me-2"></i><span>Riwayat
                            Stok</span></a>
                </li>
                <li class="active"><a href="admin_contact.php"><i class="bi bi-envelope-paper me-2"></i><span>Riwayat
                            Pesan</span></a></li>
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
            <!-- Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">Riwayat Pesan Pengguna</h1>
                <p class="dashboard-subtitle">Semua pesan dari pengguna akan ditampilkan di sini</p>
            </div>

            <!-- Controls -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari nama, email, nomor telepon, tanggal, pesan...">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="product_section card mb-4 container-fluid mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered" id="contactTable">
                        <thead class="text-center">
                            <tr>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            <?php
                            $get = mysqli_query($koneksi, "SELECT * FROM contact_us ORDER BY tanggal DESC");
                            $count = mysqli_num_rows($get);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($get)) {
                                    $pesanPendek = strlen($row['pesan']) > 40 ? substr($row['pesan'], 0, 40) . "..." : $row['pesan'];

                                    echo "
                                <tr>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['telepon']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$pesanPendek}</td>
                                    <td>{$row['tanggal']}</td>
                                    <td>
                                        <button class='btn btn-secondary btn-sm viewDetail'
                                            data-nama='{$row['nama']}'
                                            data-telepon='{$row['telepon']}'
                                            data-email='{$row['email']}'
                                            data-pesan='{$row['pesan']}'
                                            data-tanggal='{$row['tanggal']}'>
                                            <i class='bi bi-eye'></i> Lihat
                                        </button>
                                    </td>
                                </tr>
                            ";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='py-4 text-muted'>
                                <i class='bi bi-inbox fs-2 mb-2'></i><br>
                                Belum ada pesan dari pengguna
                              </td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Detail Pesan -->
            <div class="modal fade" id="detailModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">

                        <div class="modal-header">
                            <h4 class="modal-title"><i class="bi bi-envelope-open"></i> Detail Pesan</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <p><strong>Nama:</strong> <span id="detailNama"></span></p>
                            <p><strong>Telepon:</strong> <span id="detailTelepon"></span></p>
                            <p><strong>Email:</strong> <span id="detailEmail"></span></p>
                            <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
                            <p><strong>Pesan:</strong></p>
                            <p id="detailPesan" class="border p-2 rounded bg-light"></p>
                        </div>

                    </div>
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

    <!-- Scripts -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/admin.js"></script>
    <script>
        // SEARCH
        $('#searchInput').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#contactTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // MODAL DETAIL
        $(".viewDetail").click(function () {
            $("#detailNama").text($(this).data("nama"));
            $("#detailTelepon").text($(this).data("telepon"));
            $("#detailEmail").text($(this).data("email"));
            $("#detailPesan").text($(this).data("pesan"));
            $("#detailTanggal").text($(this).data("tanggal"));

            $("#detailModal").modal("show");
        });

        // display year
        document.getElementById('displayYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>