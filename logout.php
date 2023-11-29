<?php
session_start(); // Mulai sesi

// Periksa apakah pengguna sudah login
if (isset($_SESSION['id_user'])) {
    // Hapus semua data sesi
    session_unset();
    // Hancurkan sesi
    session_destroy();
}

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: login.php");
exit();
?>
