<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // --- VALIDASI INPUT ---
    if (empty($username) && empty($password)) {
        $_SESSION['sweet_alert'] = [
            "title" => "Form kosong!",
            "text" => "Username dan Password tidak boleh kosong.",
            "icon" => "warning",
            "confirmButtonText" => "OK",
            "confirmButtonColor" => "#7b2cbf"
        ];
        header('Location: admin_login.php');
        exit;
    }

    if (empty($username) || empty($password)) {
        $_SESSION['sweet_alert'] = [
            "title" => "Input belum lengkap!",
            "text" => "Harap isi semua kolom sebelum login.",
            "icon" => "warning",
            "confirmButtonText" => "OK",
            "confirmButtonColor" => "#7b2cbf"
        ];
        header('Location: admin_login.php');
        exit;
    }

    // --- QUERY DATABASE ---
    $stmt = $koneksi->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // --- VERIFIKASI PASSWORD ---
    if ($admin && password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $username;

        // Alert login berhasil + redirect
        $_SESSION['sweet_alert'] = [
            "title" => "Login Berhasil!",
            "text" => "Selamat datang kembali, Admin.",
            "icon" => "success",
            "redirect" => "admin_menu.php",
            "confirmButtonText" => "OK",
            "confirmButtonColor" => "#7b2cbf"
        ];

        header('Location: admin_login.php');
        exit;

    } else {

        $_SESSION['sweet_alert'] = [
            "title" => "Login Gagal!",
            "text" => "Username atau password salah.",
            "icon" => "error",
            "confirmButtonText" => "OK",
            "confirmButtonColor" => "#7b2cbf"
        ];

        header('Location: admin_login.php');
        exit;
    }

} else {
    header('Location: admin_login.php');
    exit;
}
?>