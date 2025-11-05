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
    $jenis = $_POST['jenis'];
    $stok = (int) $_POST['stok'];
    $gambar = $_FILES['gambar']['name'] ? $_FILES['gambar']['name'] : $_POST['gambar_lama'];

    // Upload gambar jika ada
    if ($_FILES['gambar']['name']) {
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'images/' . $gambar);
    }

    if (isset($_POST['id']) && $_POST['id']) {  // Edit
        $id = (int) $_POST['id'];
        mysqli_query($koneksi, "UPDATE menu SET nama_menu='$nama_menu', harga=$harga, gambar='$gambar', jenis='$jenis', stok=$stok WHERE id=$id");
    } else {  // Tambah
        mysqli_query($koneksi, "INSERT INTO menu (nama_menu, harga, gambar, jenis, stok) VALUES ('$nama_menu', $harga, '$gambar', '$jenis', $stok)");
    }
    header('Location: manage_menu.php');
    exit;
}

// Proses Hapus
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM menu WHERE id=$id");
    header('Location: manage_menu.php');
    exit;
}

// Ambil data untuk edit jika ada parameter ?edit=id
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM menu WHERE id=$id");
    $edit_data = mysqli_fetch_assoc($result);
}

// Ambil semua data menu
$menus = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY jenis, nama_menu");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu | Admin</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Kelola Menu</h1>
        <a href="admin_menu.php" class="btn btn-secondary mb-3">Kembali ke Menu Admin</a>
        <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

        <!-- Form Tambah/Edit -->
        <form method="POST" enctype="multipart/form-data" class="mb-5">
            <input type="hidden" name="id" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control"
                    value="<?php echo $edit_data ? $edit_data['nama_menu'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control"
                    value="<?php echo $edit_data ? $edit_data['harga'] : ''; ?>" required>
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
                <input type="number" name="stok" class="form-control"
                    value="<?php echo $edit_data ? $edit_data['stok'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
                <input type="hidden" name="gambar_lama" value="<?php echo $edit_data ? $edit_data['gambar'] : ''; ?>">
                <?php if ($edit_data && $edit_data['gambar']) { ?>
                    <img src="images/<?php echo $edit_data['gambar']; ?>" width="100" alt="Gambar Lama">
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary"><?php echo $edit_data ? 'Update' : 'Tambah'; ?> Item</button>
            <a href="manage_menu.php" class="btn btn-secondary">Reset</a>
        </form>

        
        
        <!-- Tabel Menu -->

        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.js"></script>
</body>

</html>