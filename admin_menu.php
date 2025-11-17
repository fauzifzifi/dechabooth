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
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <title>Admin Pages | Decha Booth</title>

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
</head>

<style>
  .stats-card {
    color: white;
    border-radius: 15px;
    transition: transform 0.3s ease;
    margin-bottom: 1rem;
  }

  .stats-card:hover {
    transform: translateY(-5px);
  }

  .table-actions .btn {
    margin: 2px;
  }

  .search-box {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 8px 15px;
  }

  .product_section {
    background: #ffffffe6;
    border-radius: 20px;
    /* Rounded corners */
    margin: 20px;
    padding: 10px;
    box-shadow: 0 8px 20px rgba(186, 104, 200, 0.3);
    /* Soft ungu shadow */
  }

  .table {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(221, 160, 221, 0.2);
  }

  .table img {
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(75, 0, 130, 0.2);
  }

  .table thead th {
    background: #6f1089d0;
    color: white;
    border: none;
    font-weight: bold;
  }
</style>


<body class="sub_page">
  <div class="">
    <div class="hero_area">
      <!-- header section -->
      <header class="header_section">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.php">
              <i class="bi bi-person-gear"></i>
              Admin Pages
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
              <span class=""> </span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
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

    <!-- Main Content -->
    <div class="container-fluid mt-3">
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
      <div class="product_section card mb-4">
        <div
          class="card-header bg-transparent d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
          <h5 class="card-title mb-2 mb-md-0">
            Daftar Menu
          </h5>
          <div class="input-group ms-md-2" style="max-width: 400px;">
            <input type="text" class="form-control search-box" placeholder="Cari menu..." id="searchInput">
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="productTable">
              <thead>
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
                  <tr>
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

    <!-- JavaScript -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
      // Search functionality
      document.getElementById('searchInput').addEventListener('input', function (e) {
        const value = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#productTable tbody tr');

        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(value) ? '' : 'none';
        });
      });

      // Mobile menu auto-close when clicking on link
      document.querySelectorAll('.nav-link-custom').forEach(link => {
        link.addEventListener('click', () => {
          const navbarCollapse = document.querySelector('.navbar-collapse');
          if (navbarCollapse.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(navbarCollapse);
            bsCollapse.hide();
          }
        });
      });
    </script>
</body>

</html>