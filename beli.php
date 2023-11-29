<?php
// Ambil data karya dari database
$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "artwork";

$koneksi = new mysqli($host, $db_username, $db_password, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$sql = "SELECT id_karya_seni, judul, seniman, image_123, harga FROM karya_seni";
$result = $koneksi->query($sql);

$artworks = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $artworks[] = $row;
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Beli Karya Seni</title>
</head>
<body>
    <center>
    <h1>Beli Karya Seni</h1>
    </center>

    <div class="menu">
        <a href="indexpage.php">Beranda</a>
        <a href="lihatkarya.php">Lihat Karya</a>
        <a href="update.php">Update Karya</a>
    </div>

    <div class="purchase-artwork">
        <center>
        <h2>Beli Karya Seni</h2>
        </center>
        <ul id="artwork-items">
        <?php foreach ($artworks as $artwork) : ?>
    <li class="artwork">
        <img src="<?php echo $artwork['image_123']; ?>" alt="<?php echo $artwork['judul']; ?>">
        <p><strong>Judul:</strong> <?php echo $artwork['judul']; ?></p>
        <p><strong>Seniman:</strong> <?php echo $artwork['seniman']; ?></p>
        <p><strong>Harga:</strong> Rp<?php echo number_format($artwork['harga'], 0, ',', '.'); ?></p>
        <button class="buy-button">
            <a href="transaksi.php?id=<?php echo $artwork['id_karya_seni']; ?>">Beli</a>
    </li>
<?php endforeach; ?>

        </ul>
    </div>
</body>
</html>








