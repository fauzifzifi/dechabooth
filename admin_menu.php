<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
include 'koneksi.php';

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu='$id'");

    if ($query) {
        echo "<script>alert('Menu berhasil dihapus!'); window.location='admin_menu.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus menu!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        .btn-primary {
            background-color: #9c27b0 !important; /* Ungu gelap untuk "Tambah Item Baru" */
            border-color: #9c27b0 !important;
            color: #fff !important;
            border-radius: 20px !important
        }
        .btn-primary:hover {
            background-color: #ba68c8 !important; /* Ungu muda saat hover */
            border-color: #ba68c8 !important;
        }
        .btn-danger {
            background-color: #ff0000cf !important; /* Ungu muda untuk "Logout" (lebih soft dari primary) */
            border-color: #ff0000cf !important;
            color: #fff !important;
            border-radius: 20px !important
        }
        .btn-danger:hover {
            background-color: #dc2f2fff !important; /* Ungu lebih gelap saat hover */
            border-color: #dc2f2fff !important;
        }
    </style>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <title>Admin Menu | Decha Booth</title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
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
</head>

<body class="sub_page">
    <div class="">
        <div class="hero_area">
            <!-- header section -->
            <header class="header_section">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container ">
                        <a class="navbar-brand" href="index.php">Decha Booth</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class=""> </span>
                        </button>

                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <li class="nav-item"><a class="nav-link" href="admin_trigger.php">trg</a></li>
                                <li class="nav-item active"><a class="nav-link" href="admin_menu.php">Menu Admin</a>
                                </li>
                            </ul>
                            <div class="quote_btn-container">
                                <a href="manage_menu.php" class="btn btn-primary">Tambah Item Baru</a>
                                <a href="logout.php" class="btn btn-danger">Logout</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>
        </div>

        <!-- ====== MAKANAN SECTION ====== -->
        <section class="chocolate_section">
            <div class="container">
                <div class="heading_container">
                    <h2>Makanan & Cemilan (Admin View)</h2>
                </div>
                <div class="chocolate_container">
                    <?php
                    $makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis='makanan'");
                    while ($row = mysqli_fetch_assoc($makanan)) {
                        ?>
                        <div class="box">
                            <div class="img-box">
                                <img src="images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
                            </div>
                            <div class="detail-box">
                                <h6><?php echo $row['nama_menu']; ?></h6>
                                <h5>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>
                                <p>Stok: <?php echo $row['stok']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- ====== MINUMAN SECTION ====== -->
        <section class="chocolate_section">
            <div class="container">
                <div class="heading_container">
                    <h2>Minuman (Admin View)</h2>
                </div>
                <div class="chocolate_container">
                    <?php
                    $minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis='minuman'");
                    while ($row = mysqli_fetch_assoc($minuman)) {
                        ?>
                        <div class="box">
                            <div class="img-box">
                                <img src="images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
                            </div>
                            <div class="detail-box">
                                <h6><?php echo $row['nama_menu']; ?></h6>
                                <h5>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>
                                <p>Stok: <?php echo $row['stok']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- info & footer -->
        <section class="info_section layout_padding2">
            <div class="container">
                <div class="row info_main_row">
                    <div class="col-md-6 col-lg-3">
                        <div class="info_links">
                            <h4>Menu Admin</h4>
                            <div class="info_links_menu">
                                <a href="index.php">Home</a>
                                <a href="about.html">About</a>
                                <a href="admin_menu.php">Menu Admin</a>
                                <a href="contact.php">Contact us</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="info_detail">
                            <h4>Company</h4>
                            <p class="mb-0">Decha Booth — Admin Panel untuk Mengelola Menu!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="container-fluid footer_section">
            <div class="container">
                <div class="col-md-11 col-lg-8 mx-auto">
                    <p>&copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>
