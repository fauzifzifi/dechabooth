<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <title>Decha Booth</title>

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
  <!-- allert js -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sub_page">

  <div class="">

    <div class="hero_area">
      <!-- header section -->
      <header class="header_section">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.php">
              <i class="bi bi-shop-window"></i>
              Decha Booth
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
              <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse " id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                <li class="nav-item active"><a class="nav-link" href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Suggestion</a></li>
              </ul>
              <div class="quote_btn-container">
                <a href="#" id="cartButton" class="cart-icon">
                  <i class="bi bi-cart4"></i>
                  <span class="cart-count" id="cartCount">0</span>
                </a>
                <a href="admin_login.php"><i class="fa fa-user" aria-hidden="true"></i></a>
              </div>
            </div>
        </div>
        </nav>
    </div>
    </header>
  </div>

  <!-- ===== CART OVERLAY ===== -->
  <div id="cartOverlay" class="cart-overlay"></div>

  <!-- ===== CART PANEL ===== -->
  <div id="cartPanel" class="cart-panel">

    <!-- Header -->
    <div class="cart-header">
      <h3>
        <i class="bi bi-cart4"></i>
        Keranjang Belanja
      </h3>
      <button id="closeCart">×</button>
    </div>

    <!-- Isi Keranjang -->
    <div class="cart-items" id="cartItems">
      <p id="emptyCartMessage">Keranjang masih kosong</p>
    </div>

    <!-- Form Checkout (HANYA DI SINI) -->
    <div class="cart-footer">
      <input type="text" id="buyerName" placeholder="Masukkan nama Anda" class="cart-input">

      <h4>Total: Rp<span id="cartTotal">0</span></h4>

      <button id="checkoutBtn" class="btn-checkout">
        Checkout via WhatsApp
      </button>

      <button id="clearCartBtn" class="btn-clear">
        Hapus Semua
      </button>
    </div>
  </div>


  <!-- ====== MAKANAN SECTION ====== -->
  <section class="menu_section">
    <div class="container">
      <div class="heading_container">
        <h2>Makanan & Cemilan</h2>
      </div>
      <div class="menu_container">
        <?php
        $makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis='makanan'");
        while ($row = mysqli_fetch_assoc($makanan)) { ?>
          <div class="box">
            <div class="img-box">
              <img src="images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
            </div>
            <div class="detail-box">
              <h6><?php echo $row['nama_menu']; ?></h6>
              <h5>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>

              <!-- Tombol ganti (sudah ditambahkan data-id) -->
              <div class="quantity-controls" data-id="<?php echo $row['id_menu']; ?>"
                data-name="<?php echo $row['nama_menu']; ?>" data-price="<?php echo $row['harga']; ?>"
                data-stok="<?php echo $row['stok']; ?>">

                <button class="minus">−</button>
                <span class="quantity-number">0</span>
                <button class="plus">+</button>
              </div>

            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

  <!-- ====== MINUMAN SECTION ====== -->
  <section class="menu_section">
    <div class="container">
      <div class="heading_container">
        <h2>Minuman</h2>
      </div>
      <div class="menu_container">
        <?php
        $minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE jenis='minuman'");
        while ($row = mysqli_fetch_assoc($minuman)) { ?>
          <div class="box">
            <div class="img-box">
              <img src="images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_menu']; ?>">
            </div>
            <div class="detail-box">
              <h6><?php echo $row['nama_menu']; ?></h6>
              <h5>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></h5>

              <!-- Tombol ganti (sudah ditambahkan data-id) -->
              <div class="quantity-controls" data-id="<?php echo $row['id_menu']; ?>"
                data-name="<?php echo $row['nama_menu']; ?>" data-price="<?php echo $row['harga']; ?>"
                data-stok="<?php echo $row['stok']; ?>">

                <button class="minus">−</button>
                <span class="quantity-number">0</span>
                <button class="plus">+</button>
              </div>

            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>


  <!-- info section -->
  <section class="info_section layout_padding2">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-lg-3">
          <div class="info_links">
            <h4>
              Decha Booth
            </h4>
            <div class="info_links_menu">
              <a href="index.php">
                Home
              </a>
              <a href="about.html">
                About
              </a>
              <a href="menu.php">
                Menu
              </a>
              <a href="contact.php">
                Suggestion
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="info_detail">
            <h4>
              Company
            </h4>
            <p class="mb-0">
              Decha Booth hadir untuk pelajar! Kami menyajikan berbagai makanan
              dan minuman kekinian dengan rasa lezat dan harga bersahabat.
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="info_detail">
            <h4>
              Operating Hours
            </h4>
            <p class="mb-0">
              Buka setiap hari Senin s/d Sabtu
            </p>
            <p class="mb-0">
              Jam 07.00 s/d 16.00
            </p>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="info_contact">
            <h4>
              Contact Us
            </h4>
            <a href="https://maps.app.goo.gl/wChnMDa6as9zeXYLA?g_st=aw" target="_blank">
              <span>
                <i class="fa fa-map-marker"></i>
                Lokasi
              </span>
            </a>
            <a href="https://wa.me/+6282336881878" target="_blank">
              <span>
                <i class="fa fa-whatsapp"></i>
                WhatsApp +6282336881878
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end info_section -->


  <!-- end info_section -->

  <footer class="container-fluid footer_section">
    <div class="container">
      <div class="col-md-11 col-lg-8 mx-auto">
        <p>&copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth</p>
      </div>
    </div>
  </footer>
  </div>

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- slick slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- cart js -->
  <script src="js/cart.js"></script>


</body>

</html>