<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
include 'koneksi.php';

// Proses Tambah/Edit Menu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $harga = (int) $_POST['harga'];
    $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $stok = (int) $_POST['stok'];
    $gambar = $_POST['gambar_lama'];

    // Upload gambar baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, $allowed_ext)) {
            $gambar = uniqid() . "." . $file_ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'images/' . $gambar);
        } else {
            die("Format gambar tidak didukung. Harus jpg, jpeg, png, atau gif.");
        }
    }

    if (isset($_POST['id_menu']) && $_POST['id_menu']) {  // Edit
        $id_menu = (int) $_POST['id_menu'];
        $sql = "UPDATE menu SET nama_menu='$nama_menu', harga=$harga, gambar='$gambar', jenis='$jenis', stok=$stok WHERE id_menu=$id_menu";
        if (mysqli_query($koneksi, $sql)) {
            $_SESSION['success'] = "Menu berhasil diedit!";
        } else {
            $_SESSION['error'] = "Gagal mengedit menu!";
        }
    } else {  // Tambah
        $sql = "INSERT INTO menu (nama_menu, harga, gambar, jenis, stok) VALUES ('$nama_menu', $harga, '$gambar', '$jenis', $stok)";
        if (mysqli_query($koneksi, $sql)) {
            $_SESSION['success'] = "Menu berhasil ditambahkan!";
        } else {
            $_SESSION['error'] = "Gagal menambahkan menu!";
        }
    }
    header('Location: manage_menu.php');
    exit;
}

// Proses Hapus
if (isset($_GET['delete'])) {
    $id_menu = (int) $_GET['delete'];
    if (mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu=$id_menu")) {
        $_SESSION['success'] = "Menu berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus menu!";
    }
    header('Location: manage_menu.php');
    exit;
}

// Ambil data untuk edit jika ada parameter ?edit=id_menu
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_menu = (int) $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu=$id_menu");
    $edit_data = mysqli_fetch_assoc($result);
}

// Ambil semua data menu
$menus = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY jenis, nama_menu");

// Cek notifikasi dari session
$success_message = '';
$error_message = '';
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <title>Manage Menu</title>

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
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .dashboard-title {
            color: #9c27b0;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .dashboard-subtitle {
            color: #666;
            font-size: 1.1rem;
        }


        .btn {
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: bold;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(75, 0, 130, 0.4);
        }

        .btn-primary {
            background: #6f1089d0;
            color: white;
        }

        .btn-secondary {
            background: #DDA0DD;
            color: #6f1089d0;
        }

        .btn-danger {
            background: #8B0000;
            color: white;
        }

        .btn-warning {
            background: #FFD700;
            color: white;
        }

        .btn-warning:hover {
            background: #e0a800;
            color: white;
        }

        .form-group label {
            font-weight: bold;
            color: #6f1089d0;
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

        /* Styling khusus untuk input file agar tombol "Choose File" lebih kecil dan sesuai dengan kotak */
        input[type="file"] {
            padding: 5px;
        }

        input[type="file"]::-webkit-file-upload-button {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 5px;
            background: #DDA0DD;
            color: #6f1089d0;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: #6f1089d0;
            color: white;
        }

        input[type="file"]::-moz-file-upload-button {
            font-size: 12px;
            padding: 4px 8px;
            border-radius: 5px;
            background: #DDA0DD;
            color: #6f1089d0;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="file"]::-moz-file-upload-button:hover {
            background: #6f1089d0;
            color: white;
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

        .table img {
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(75, 0, 130, 0.2);
        }

        .btn-sm {
            border-radius: 15px;
            margin: 2px;
        }

        /* Notifikasi */
        .alert {
            border-radius: 10px;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            background: #28a745;
            color: #fff;
            border: none;
        }

        .alert-danger {
            background: #dc3545;
            color: #fff;
            border: none;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
                            <li class="nav-item active">
                                <a class="nav-link" href="manage_menu.php">
                                    <i class="bi bi-box me-2"></i>
                                    Kelola Menu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="admin_trigger.php">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Riwayat Stok
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
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

    <div class="dashboard-header">
        <h1 class="dashboard-title">Manajemen Menu</h1>
        <p class="dashboard-subtitle">Kelola seluruh menu dengan cepat dan terstruktur</p>
    </div>

    <!-- Form Tambah/Edit -->
    <section class="menu_section layout_padding">
        <div class="container container-fluid">
            <div class="container-fluid">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_menu" value="<?php echo $edit_data ? $edit_data['id_menu'] : ''; ?>">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" required
                            value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_menu']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required
                            value="<?php echo $edit_data ? $edit_data['harga'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="jenis" class="form-control" required>
                            <option value="makanan" <?php echo ($edit_data && $edit_data['jenis'] == 'makanan') ? 'selected' : ''; ?>>Makanan</option>
                            <option value="minuman" <?php echo ($edit_data && $edit_data['jenis'] == 'minuman') ? 'selected' : ''; ?>>Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required
                            value="<?php echo $edit_data ? $edit_data['stok'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                        <input type="hidden" name="gambar_lama"
                            value="<?php echo $edit_data ? $edit_data['gambar'] : ''; ?>">
                        <?php if ($edit_data && $edit_data['gambar']) { ?>
                            <img src="images/<?php echo $edit_data['gambar']; ?>" alt="Gambar Lama" width="100"
                                class="mt-2" />
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-secondary"><?php echo $edit_data ? 'Update' : 'Tambah'; ?>
                        Item</button>
                    <a href="manage_menu.php" class="btn btn-secondary">Reset</a>
                </form>
            </div>
        </div>
    </section>

    <!-- Notifikasi Sukses atau Error -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success fade show" role="alert" id="success-alert">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger fade show" role="alert" id="error-alert">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>


    <!-- Tabel Daftar Menu -->
    <div class="menu_section layout_padding">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Menu</th>
                        <th>Nama Menu</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($menus)) { ?>
                        <tr>
                            <td><?php echo $row['id_menu']; ?></td>
                            <td><?php echo htmlspecialchars($row['nama_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                            <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['stok']; ?></td>
                            <td>
                                <?php if ($row['gambar']) { ?>
                                    <img src="images/<?php echo $row['gambar']; ?>" alt="gambar" width="50" />
                                <?php } ?>
                            </td>
                            <td>
                                <a href="manage_menu.php?edit=<?php echo $row['id_menu']; ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="manage_menu.php?delete=<?php echo $row['id_menu']; ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus menu ini?')">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
        // Hilangkan notifikasi sukses otomatis setelah 3 detik
        setTimeout(function () {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        // Hilangkan notifikasi error otomatis setelah 3 detik
        setTimeout(function () {
            $('#error-alert').fadeOut('slow');
        }, 3000);
    </script>
</body>

</html>