<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Login Admin | Decha Booth</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet" />

  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

  <style>
    /* (Style CSS tetap sama seperti yang Anda berikan) */
    * {
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
      font-family: "Poppins", sans-serif;
      background: url("images/login_bg.png") no-repeat center center fixed;
      background-size: cover;
      color: #333;
    }

    .login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      width: 100%;
      flex-direction: column;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.25);
      padding: 35px 40px;
      width: 100%;
      max-width: 380px;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-box h2 {
      font-weight: 700;
      font-size: 22px;
      margin-bottom: 25px;
      color: #6a11cb;
    }

    .btn-primary {
      background-color: #6a11cb;
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #5810b4;
    }

    .back-home {
      position: absolute;
      top: 20px;
      left: 20px;
      display: flex;
      align-items: center;
      color: white;
      text-decoration: none;
      font-weight: 500;
      font-size: 16px;
      transition: 0.3s;
    }

    .back-home:hover {
      color: #ddd;
      text-decoration: none;
    }

    .back-home i {
      font-size: 24px;
      margin-right: 8px;
    }

    footer {
      position: absolute;
      bottom: 10px;
      left: 0;
      width: 100%;
      text-align: center;
      font-size: 14px;
      color: #fff;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body>
  <!-- Tombol kembali ke home -->
  <a href="index.php" class="back-home">
    <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke Home
  </a>

  <!-- Login Box -->
  <div class="login-wrapper">
    <div class="login-box">
      <div class="text-center mb-3">
        <img src="images/logo.png" alt="Logo Decha Booth" style="width: 80px; margin-bottom: 10px" />
        <h2><i class="bi bi-person-lock"></i> Admin Login</h2>
      </div>

      <!-- Tampilkan pesan error jika ada -->
      <?php
      session_start();
      if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);  // Hapus setelah ditampilkan
      }
      ?>

      <form action="admin_login_process.php" method="POST">
        <div class="form-group mb-3 text-start">
          <label for="username"><i class="bi bi-person-fill"></i> Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username"
            required />
        </div>
        <div class="form-group mb-4 text-start">
          <label for="password"><i class="bi bi-lock-fill"></i> Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password"
            required />
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">
          <i class="bi bi-box-arrow-in-right"></i> Login
        </button>
      </form>

      <p class="text-center mt-3 mb-0 text-muted" style="font-size: 14px">
        Hanya untuk <strong>Admin Decha Booth</strong>
      </p>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; <span id="displayYear"></span> All Rights Reserved By Decha Booth
  </footer>

  <!-- JS -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>