<?php
// Konfigurasi database
$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "artwork";

// Buat koneksi ke database
$koneksi = new mysqli($host, $db_username, $db_password, $db_name);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
if(isset($_POST["register"])){
    // Validasi data
    if (empty($_POST['username'])) {
        echo "Username tidak boleh kosong.";
        exit();
    }
    
    if (empty($_POST['email'])) {
        echo "Email tidak boleh kosong.";
        exit();
    }
    
    if (empty($_POST['password'])) {
        echo "Password tidak boleh kosong.";
        exit();
    }
    
    // Cek apakah email sudah terdaftar
    $sql_check = "SELECT * FROM user WHERE email = '{$_POST['email']}'";
    $result = $koneksi->query($sql_check);
    
    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar.";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Simpan data ke database
    $sql = "INSERT INTO user (username, email, password) VALUES ('{$_POST['username']}', '{$_POST['email']}', '{$hashed_password}')";
    
    if ($koneksi->query($sql) === TRUE) {
        // Registrasi berhasil
        header("Location: login.php"); // Redirect ke halaman login
        exit();
    } else {
        // Registrasi gagal
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
    
    // Tutup koneksi ke database
    $koneksi->close();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <style>
        body {
            background-image: url('artexhibition.jpg');
            background-size: cover; /* Untuk menyesuaikan gambar dengan ukuran halaman */
            background-attachment: fixed; /* Untuk mengunci gambar latar belakang */
        }
    </style>
</head>
<body>
    <center>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="register" value="Registrasi">
    </center>
    </form>
</body>
</html>



