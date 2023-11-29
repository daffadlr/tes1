<?php
session_start();

$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "artwork";

$koneksi = new mysqli($host, $db_username, $db_password, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_karya_seni"]) && isset($_POST["judul"]) && isset($_POST["seniman"]) && isset($_POST["harga"])) {
        $id_karya_seni = $_POST["id_karya_seni"];
        $judul = $_POST["judul"];
        $seniman = $_POST["seniman"];
        $harga = $_POST["harga"];

        // Perbarui data karya seni dalam database
        $sql = "UPDATE karya_seni SET judul = ?, seniman = ?, harga = ? WHERE id_karya_seni = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssdi", $judul, $seniman, $harga, $id_karya_seni);
        $stmt->execute();
    }
}

// Hapus karya jika admin telah mengonfirmasi
if (isset($_GET["confirmDelete"]) && $_GET["confirmDelete"] === "true") {
    if (isset($_GET["id_karya_seni"]) && is_numeric($_GET["id_karya_seni"])) {
        $id_karya_seni = $_GET["id_karya_seni"];
        $sql = "DELETE FROM karya_seni WHERE id_karya_seni = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $id_karya_seni);
        $stmt->execute();
    }
}

// Mendapatkan data karya seni
$sql = "SELECT id_karya_seni, judul, seniman, image_123, harga FROM karya_seni"; // Tambahkan kolom harga ke dalam query
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
    <title>Lihat Karya</title>
    <style>
        .menu-edit {
            background: #444;
            color: #fff;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none; /* Tambahkan styling tautan */
            cursor: pointer;
        }

        .menu-delete {
            background: #ff0000;
            color: #fff;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none; /* Tambahkan styling tautan */
            cursor: pointer;
        }
        
        /* Sembunyikan form penyuntingan secara default */
        .edit-form {
            display: none;
        }

        /* Tampilkan form penyuntingan saat tombol Edit diklik */
        .artwork:hover .edit-form {
            display: block;
        }
        .artwork-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .artwork {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            position: relative;
        }

        .artwork img {
            max-width: 100%;
            height: auto;
        }

        .menu-container {
            display: flex;
            justify-content: space-between;
        }

        /* Menambahkan gaya untuk menu delete dan menu edit */
        .menu-delete,
        .menu-edit {
            background: #444;
            color: #fff;
            padding: 5px 5px;
            margin: 5px;
            text-decoration: none; /* Menambahkan styling tautan */
        }
    </style>
</head>
<body>
    <header>
        <div class="logo"></div>
        <h1>Art Exhibition</h1>
        <nav id="indexpage">
            <ul>
                <li class="active"><a href="indexpage.php">Beranda</a></li>
                <li><a href="lihatkarya.php">Lihat Karya</a></li>
                <li><a href="update.php">Tambah Karya</a></li>
                <li><a href="beli.php">Beli Karya</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <div class="user-options">
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            </div>
        </nav>
    </header>

    <div class="artwork-gallery">
        <?php $count = 1; foreach ($artworks as $artwork) : ?>
            <div class="artwork">
                <p><strong>#<?php echo $count; ?></strong></p>
                <img src="<?php echo $artwork['image_123']; ?>" alt="<?php echo $artwork['judul']; ?>">
                <p><strong>Judul:</strong> <?php echo $artwork['judul']; ?></p>
                <p><strong>Seniman:</strong> <?php echo $artwork['seniman']; ?></p>
                <p><strong>Harga:</strong> Rp<?php echo number_format($artwork['harga'], 0, ',', '.'); ?></p>
                <div class="menu-container">
                    <?php
                        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                            echo '<a class="menu-delete" href="admin.php?id_karya_seni=' . $artwork['id_karya_seni'] . '">Delete</a>';
                        }
                    ?>
                    <a class="menu-edit">Edit</a>
                </div>

                <!-- Formulir penyuntingan (sembunyikan awalnya) -->
                <form id="edit-form-<?php echo $count; ?>" class="edit-form" method="POST">
                    <input type="hidden" name="id_karya_seni" value="<?php echo $artwork['id_karya_seni']; ?>">
                    <label for="judul-<?php echo $count; ?>">Judul:</label>
                    <input type="text" id="judul-<?php echo $count; ?>" name="judul" value="<?php echo $artwork['judul']; ?>">
                    <label for="seniman-<?php echo $count; ?>">Seniman:</label>
                    <input type="text" id="seniman-<?php echo $count; ?>" name="seniman" value="<?php echo $artwork['seniman']; ?>">
                    <label for="harga-<?php echo $count; ?>">Harga:</label>
                    <input type="number" id="harga-<?php echo $count; ?>" name="harga" value="<?php echo $artwork['harga']; ?>">
                    <button type="submit">Simpan</button>
                </form>
            </div>
        <?php $count++; endforeach; ?>
    </div>
</body>
</html>
