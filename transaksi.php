<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["beli"])) {
        $id_karya_seni = $_POST["karya_id"];
        $harga = $_POST["harga"];
        $id_user = $_SESSION['id_user'];

        $host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "artwork";

        $koneksi = new mysqli($host, $db_username, $db_password, $db_name);

        if ($koneksi->connect_error) {
            die("Koneksi database gagal: " . $koneksi->connect_error);
        }

        $sql = "INSERT INTO transaksi (tanggal_transaksi, harga, id_karya_seni, id_user) VALUES (NOW(), ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("dii", $harga, $id_karya_seni, $id_user);


        if ($stmt->execute()) {
            // Jika transaksi berhasil, tampilkan pesan pemberitahuan
            echo "<div class='alert alert-success'>Transaksi berhasil!</div>";
          } else {
            echo "<div class='alert alert-danger'>Transaksi gagal!</div>";
          }      

        $stmt->close();
        $koneksi->close();
    }
}

// Ambil data karya dari database
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
    <title>Transaksi Pembelian Karya Seni</title>
</head>
<body>
    <h1>Transaksi Pembelian Karya Seni</h1>

    <div class="menu">
        <a href="indexpage.php">Beranda</a>
        <a href="lihatkarya.php">Lihat Karya</a>
        <a href="update.php">Update Karya</a>
    </div>

    <div class="transaction-form">
        <h2>Pilih Karya Seni</h2>
        <form method="POST" action="transaksi.php">
    <select name="karya_id" id="karya-select">
        <?php foreach ($artworks as $artwork) : ?>
            <option value="<?php echo $artwork['id_karya_seni']; ?>" data-harga="<?php echo $artwork['harga']; ?>">
                <?php echo $artwork['judul'] . ' - ' . $artwork['seniman'] . ' - Rp' . number_format($artwork['harga'], 0, ',', '.'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="harga" id="harga" value="">
    <input type="number" name="harga" id="harga" placeholder="Harga Karya">
    <button type="submit" name="beli">Beli Karya</button>
</form>
    </div>
</body>
</html>

