<?php
// Lakukan autentikasi pengguna di sini jika diperlukan

// Data pengguna Anda
$users = [
    [
        'username' => 'Daffa Haris',
        'email' => 'zxcvbnm@gmail.com',
        'password' => 'daffaslytheryn250',
        'is_admin' => true, // Pengguna ini adalah admin
    ],
    // Tambahkan data pengguna lain di sini jika diperlukan
];

$authenticatedUser = null;

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
    // Autentikasi HTTP Basic
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $authenticatedUser = $user;
            break;
        }
    }
}

if (!$authenticatedUser) {
    header('WWW-Authenticate: Basic realm="Admin Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Autentikasi diperlukan.';
    exit;
}

if ($authenticatedUser['is_admin']) {
    if (isset($_GET["id_karya_seni"]) && is_numeric($_GET["id_karya_seni"])) {
        $id_karya_seni = $_GET["id_karya_seni"];
        
        // Lakukan koneksi ke database
        $host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "artwork";
        
        $koneksi = new mysqli($host, $db_username, $db_password, $db_name);
        
        if ($koneksi->connect_error) {
            die("Koneksi database gagal: " . $koneksi->connect_error);
        }
        
        // Lakukan penghapusan karya dari database
        $sql = "DELETE FROM karya_seni WHERE id_karya_seni = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id_karya_seni);
        
        if ($stmt->execute()) {
            // Penghapusan berhasil
            header('Location: indexpage.php'); // Redirect ke halaman admin setelah penghapusan
        } else {
            echo "Gagal menghapus karya.";
        }
        
        // Tutup koneksi database
        $koneksi->close();
    }
}

// Ambil data karya seni dari database
$artworks = [];

if ($authenticatedUser['is_admin']) {
    // Lakukan koneksi ke database untuk mengambil daftar karya seni
    $host = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "artwork";
    
    $koneksi = new mysqli($host, $db_username, $db_password, $db_name);
    
    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $koneksi->connect_error);
    }
    
    $sql = "SELECT id_karya_seni, judul, seniman, harga FROM karya_seni";
    $result = $koneksi->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $artworks[] = $row;
        }
    }
    
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Gantilah dengan file CSS Anda sendiri -->
    <title>Delete Artwork</title>
</head>
<body>
    <h1>Delete Artwork</h1>
    <div class="content">
        <?php
        if ($authenticatedUser['is_admin']) {
            if (count($artworks) > 0) {
                echo "<h2>Daftar Karya Seni</h2>";
                echo "<ul>";
                foreach ($artworks as $artwork) {
                    echo "<li>";
                    echo $artwork['judul'];
                    echo " <a href='?id_karya_seni=" . $artwork['id_karya_seni'] . "'>Delete</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "Tidak ada karya seni yang tersedia.";
            }
        } else {
            echo "Anda bukan admin. Autentikasi berhasil, tetapi Anda tidak memiliki izin untuk menghapus.";
        }
        ?>
    </div>
</body>
</html>
