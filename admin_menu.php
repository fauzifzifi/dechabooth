<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header('Location: admin_login.php');
  exit;
}
include 'koneksi.php';

// Ambil statistik
$total_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM menu"))['total'];
$produk_tersedia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM menu WHERE stok > 0"))['total'];
$stok_sedikit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM menu WHERE stok < 10 AND stok > 0"))['total'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(DISTINCT jenis) as total FROM menu"))['total'];

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Dashboard | Admin</title>

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
        <li class="active"><a href="admin_menu.php"><i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span></a>
        </li>
        <li><a href="manage_menu.php"><i class="bi bi-box me-2"></i><span>Kelola Menu</span></a></li>
        <li><a href="admin_trigger.php"><i class="bi bi-clock-history me-2"></i><span>Riwayat Stok</span></a></li>
        <li><a href="admin_contact.php"><i class="bi bi-envelope-paper me-2"></i><span>Ulasan Pelanggan</span></a></li>
        <li><a href="admin_order.php"><i class="bi bi-receipt-cutoff me-2"></i><span>Riwayat Order</span></a></li>
        <li><a class="az-btn-logout" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i><span>Logout</span></a>
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
  <main class="az-main-content" id="azMainContent" role="main">
    <div class="container-fluid mt-3 main-wrapper">
      <!-- Stats Cards -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="card stats-card bg-primary">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-title mb-1">Total Produk</h6>
                  <h3 class="mb-0"><?php echo $total_produk; ?></h3>
                </div>
                <i class="bi bi-box display-6 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stats-card bg-success">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-title mb-1">Produk Tersedia</h6>
                  <h3 class="mb-0"><?php echo $produk_tersedia; ?></h3>
                </div>
                <i class="bi bi-check-circle display-6 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stats-card bg-warning">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-title mb-1">Stok Sedikit</h6>
                  <h3 class="mb-0"><?php echo $stok_sedikit; ?></h3>
                </div>
                <i class="bi bi-exclamation-triangle display-6 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card stats-card bg-info">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="card-title mb-1">Kategori</h6>
                  <h3 class="mb-0"><?php echo $total_kategori; ?></h3>
                </div>
                <i class="bi bi-tags display-6 opacity-75"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Table -->
      <div class="product_section card mb-4 container-fluid mt-3">
        <div class="card-header bg-transparent align-items-md-center">
          <div class="form-group">
            <input type="text" placeholder="Cari menu..." id="searchInput" class="form-control">
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="productTable">
              <thead class="text-center">
                <tr>
                  <th>Gambar</th>
                  <th>Nama Menu</th>
                  <th>Jenis</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $menus = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY jenis, nama_menu");
                while ($row = mysqli_fetch_assoc($menus)) {
                  $status_badge = $row['stok'] > 0 ? 'bg-success' : 'bg-danger';
                  $status_text = $row['stok'] > 0 ? 'Tersedia' : 'Habis';
                  $stok_badge = $row['stok'] < 10 ? 'bg-warning' : 'bg-secondary';
                  ?>
                  <tr class="text-center">
                    <td>
                      <?php if ($row['gambar']) { ?>
                        <img src="images/<?php echo $row['gambar']; ?>" alt="gambar" width="50" />
                      <?php } ?>
                    </td>
                    <td>
                      <div class="fw-bold"><?php echo htmlspecialchars($row['nama_menu']); ?></div>
                    </td>
                    <td class="text-light">
                      <span class="badge <?php echo $row['jenis'] == 'makanan' ? 'bg-primary' : 'bg-success'; ?>">
                        <?php echo ucfirst($row['jenis']); ?>
                      </span>
                    </td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td class="text-light">
                      <span class="badge <?php echo $stok_badge; ?>">
                        <?php echo $row['stok']; ?>
                      </span>
                    </td>
                    <td class="text-light">
                      <span class="badge <?php echo $status_badge; ?>">
                        <?php echo $status_text; ?>
                      </span>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- footer -->
    <footer class="container-fluid footer_section">
      <div class="container">
        <div class="col-md-11 col-lg-8 mx-auto">
          <p>&copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth</p>
        </div>
      </div>
    </footer>
  </main>

  <!-- SCRIPTS: load libraries BEFORE admin.js -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <!-- admin.js (your custom logic) -->
  <script src="js/admin.js"></script>

  <script>
    // search
    document.getElementById('searchInput').addEventListener('input', function (e) {
      const value = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('#productTable tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(value) ? '' : 'none';
      });
    });

    // display year
    document.getElementById('displayYear').textContent = new Date().getFullYear();
  </script>
</body>

</html>