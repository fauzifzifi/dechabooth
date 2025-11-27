<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kirim_pesan'])) {
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
  $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon']);
  $email = mysqli_real_escape_string($koneksi, $_POST['email']);
  $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);


  $query_contact = "INSERT INTO contact_us (nama, telepon, email, pesan)
                      VALUES ('$nama', '$telepon', '$email', '$pesan')";

  $insertContact = mysqli_query($koneksi, $query_contact);

  if ($insertContact) {
    // NOTIFIKASI SUKSES UNTUK SWEETALERT
    $_SESSION['msg'] = "Pesan kamu berhasil dikirim!";
    $_SESSION['msg_type'] = "success";

    header("Location: contact.php");
    exit;
  } else {
    $_SESSION['msg'] = "Gagal simpan contact_us: " . mysqli_error($koneksi);
    $_SESSION['msg_type'] = "error";
    header("Location: contact.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Decha Booth</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!--slick slider stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- slick slider -->
  <link rel="stylesheet" href="css/slick-theme.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />

  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <!-- alert js -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="sub_page">

  <!-- alert contact us -->
  <?php if (isset($_SESSION['msg'])): ?>
    <script>
      Swal.fire({
        icon: "<?php echo ($_SESSION['msg_type'] === 'success') ? 'success' : 'error'; ?>",
        title: "<?php echo ($_SESSION['msg_type'] === 'success') ? 'Berhasil!' : 'Gagal!'; ?>",
        text: "<?php echo $_SESSION['msg']; ?>",
        iconColor: "<?php echo ($_SESSION['msg_type'] === 'success') ? '#7ed957' : '#ff4d4d'; ?>",
        confirmButtonText: "OK",
        confirmButtonColor: "#7b2cbf"
      }).then(() => {
        document.getElementById("contactForm").reset();
      });
    </script>
    <?php
    unset($_SESSION['msg']);
    unset($_SESSION['msg_type']);
  endif; ?>
  <!-- end alert contcact us -->

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <i class="bi bi-shop-window"></i>
            Decha Booth
          </a>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html"> About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="menu.php">Menu
                </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </ul>
            <div class="quote_btn-container">
              <a href="#" id="cartButton" class="cart-icon">
                <i class="bi bi-cart4"></i>
                <span class="cart-count" id="cartCount">0</span>
              </a>
              <a href="admin_login.php">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
  </div>
  <!-- end header section -->

  <!-- panel keranjang -->
  <div id="cartPanel" class="cart-panel">
    <div class="cart-header">
      <h3>Keranjang Belanja</h3>
      <button id="closeCart" class="close-btn">×</button>
    </div>

    <div id="cartItems" class="cart-items"></div>

    <div class="cart-footer">
      <p>Total: Rp<span id="cartTotal">0</span></p>

      <button id="checkoutBtn" class="btn-checkout">Checkout via WhatsApp</button>
      <button id="clearCartBtn" class="btn-clear">Hapus Semua</button>
    </div>
  </div>

  <!-- Tambahkan ini ⬇️ -->
  <div id="cartOverlay" class="cart-overlay"></div>

  <!-- panel keranjang -->

  <!-- contact section -->
  <section class="contact_section layout_padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-5 col-lg-4 offset-md-1">
          <div class="form_container">
            <div class="heading_container">
              <h2>
                Contact Us
              </h2>
            </div>
            <form method="POST" action="" id="contactForm">
              <div>
                <input type="text" name="nama" id="nama" placeholder="Nama" />
              </div>
              <div>
                <input type="text" name="telepon" id="telepon" placeholder="Nomor Telepon" />
              </div>
              <div>
                <input type="email" name="email" id="email" placeholder="Email" />
              </div>
              <div>
                <textarea name="pesan" id="pesan" placeholder="Pesan"></textarea>
              </div>
              <div class="d-flex">
                <button type="submit" name="kirim_pesan">KIRIM</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container">
            <div class="map">
              <div id="googleMap"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->


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
                Contact us
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
                <i class="fa fa-phone"></i>
                WhatsApp +6282336881878
              </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end info_section -->

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

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- slick slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->
  <!-- cart js -->
  <script src="js/cart.js"></script>
</body>

</html>