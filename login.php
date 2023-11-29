<?php
// login.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang diinputkan oleh pengguna
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validasi data (misalnya, periksa apakah pengguna ada dalam database, dan kata sandi benar)
    $host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "artwork";

    $koneksi = new mysqli($host, $db_username, $db_password, $db_name);

    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }

    // Buat query SQL untuk memeriksa data pengguna
    $sql = "SELECT id_user, username, password FROM user WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verifikasi kata sandi
        if (password_verify($password, $row["password"])) {
            // Login berhasil
            session_start();
            $_SESSION["id_user"] = $row["id_user"];

            // Redirect ke halaman beranda
            header("Location: indexpage.php");
            exit();
        } else {
            echo "Kata Sandi Salah.";
        }
    } else {
        echo "Nama Pengguna tidak ditemukan.";
    }

    $stmt->close();
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <center>
    <form id="login-form" method="post">
        <input type="text" name="username" placeholder="Nama Pengguna">
        <input type="password" name="password" placeholder="Kata Sandi">
        <button type="submit">Masuk</button>
    </center>
    </form>
</body>
</html>

