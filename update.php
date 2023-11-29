<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        // Proses unggah karya
        $judul = $_POST["judul"];
        $seniman = $_POST["seniman"];
        $harga = $_POST["harga"];

        // Konversi format harga
        $harga = str_replace(",", "", $harga); // Menghapus koma jika ada
        $harga = str_replace("Rp", "", $harga); // Menghapus simbol Rp jika ada
        $harga = floatval($harga); // Konversi harga menjadi FLOAT

        $image = $_FILES["image_123"];

        // Validasi dan simpan gambar ke server
        if ($image["error"] === 0) {
            $upload_dir = "uploads/";
            $target_file = $upload_dir . basename($image["name"]);

            if (move_uploaded_file($image["tmp_name"], $target_file)) {
                $host = "localhost";
                $db_username = "root";
                $db_password = "";
                $db_name = "artwork";

                $koneksi = new mysqli($host, $db_username, $db_password, $db_name);

                if ($koneksi->connect_error) {
                    die("Koneksi database gagal: " . $koneksi->connect_error);
                }

                $sql = "INSERT INTO karya_seni (judul, seniman, harga, image_123) VALUES ('$judul', '$seniman', $harga, '$target_file')";

                if ($koneksi->query($sql) === TRUE) {
                    // Karya berhasil ditambahkan
                    header("Location: update.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $koneksi->error;
                }

                $koneksi->close();
            } else {
                echo "Gagal mengunggah gambar.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Update Karya Seni</title>
</head>
<body>
    <h1>Update Karya Seni</h1>

    <div class="add-artwork">
    <header>
    <div class="logo"></div>
    <nav id="indexpage">
      <ul>
        <li><a href="lihatkarya.php">Lihat Karya</a></li>
        <li><a href="update.php">Tambah Karya</a></li>
        <li><a href="beli.php">Beli Karya</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="delete.php">Hapus Karya</a></li>
      </ul>
      <div class="user-options">
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
      </div>
    </nav>
  </header>
        <center>
        <h2>Unggah Karya Seni</h2>
        </center>
        <form id="add-artwork-form" method="POST" enctype="multipart/form-data">
            <input type="text" name="judul" placeholder="Judul">
            <input type="text" name="seniman" placeholder="Seniman">
            <input type="text" name="harga" placeholder="Harga">
            <input type="file" name="image_123" accept="image/*">
            <button type="submit" name="add">Tambah</button>
        </form>
    </div>

    <!-- ... konten lainnya ... -->
</body>
</html>






