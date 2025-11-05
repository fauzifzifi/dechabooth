<?php
session_start();
include 'koneksi.php';  // Sertakan koneksi database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Username dan password harus diisi.';
        header('Location: admin_login.php');
        exit;
    }

    // Query database
    $stmt = $koneksi->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Verifikasi password
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $username;
        header('Location: admin_menu.php');  // Redirect ke halaman admin menu
        exit;
    } else {
        $_SESSION['error'] = 'Username atau password salah.';
        header('Location: admin_login.php');
        exit;
    }
} else {
    header('Location: admin_login.php');
    exit;
}
?>