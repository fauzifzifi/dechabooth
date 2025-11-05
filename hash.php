<?php
$password_plain = '12345';  // Ganti dengan password asli yang ingin di-hash
$hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);
echo $hashed_password;  // Ini akan menampilkan hash, seperti: $2y$10$abc123...
?>