<?php
// Data pengguna Anda
$users = [
    [
        'username' => 'Daffa Haris',
        'email' => 'asdfghjkl@gmail.com',
        'password' => 'daffaslytheryn250',
        'is_admin' => true, // Pengguna ini adalah admin
    ],
    // Tambahkan data pengguna lain di sini jika diperlukan
];

// Data karya seni (contoh data)
$artworks = [
    [
        'id' => 1,
        'judul' => 'Karya Seni 1',
        'deskripsi' => 'Deskripsi Karya Seni 1',
    ],
    [
        'id' => 2,
        'judul' => 'Karya Seni 2',
        'deskripsi' => 'Deskripsi Karya Seni 2',
    ],
    // Tambahkan data karya seni lain di sini jika diperlukan
];

// Fungsi untuk memeriksa autentikasi pengguna
function authenticateUser($username, $password) {
    global $users;
    
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            return $user;
        }
    }
    
    return null;
}

// Proses autentikasi (biasanya dari input pengguna)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $authenticatedUser = authenticateUser($username, $password);

    if ($authenticatedUser && $authenticatedUser['is_admin']) {
        // Autentikasi berhasil sebagai admin
        if (isset($_GET["id_karya"]) && is_numeric($_GET["id_karya"])) {
            $id_karya = $_GET["id_karya"];
            
            // Hapus karya dari halaman beli.php
            $beli_page_url = "beli.php";
            if (file_get_contents($beli_page_url)) {
                $beli_page_content = file_get_contents($beli_page_url);
                $beli_page_content = str_replace("id_karya_seni=" . $id_karya, "", $beli_page_content);
                file_put_contents($beli_page_url, $beli_page_content);
            }

            // Hapus karya dari halaman lihatkarya.php
            $lihatkarya_page_url = "lihatkarya.php";
            if (file_get_contents($lihatkarya_page_url)) {
                $lihatkarya_page_content = file_get_contents($lihatkarya_page_url);
                $lihatkarya_page_content = str_replace("id_karya_seni=" . $id_karya, "", $lihatkarya_page_content);
                file_put_contents($lihatkarya_page_url, $lihatkarya_page_content);
            }

            // Hapus karya dari database
            foreach ($artworks as $key => $artwork) {
                if ($artwork['id'] == $id_karya) {
                    unset($artworks[$key]);
                    break;
                }
            }

            echo "Karya dengan ID $id_karya telah dihapus.";
        }
    } else {
        // Autentikasi berhasil, tapi bukan admin
        echo "Anda berhasil login, tetapi Anda bukan admin.";
    }
} else {
    // Redirect ke halaman beli.php jika tidak ada data POST
    header('Location: beli.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Halaman Admin</h1>
    <p>Selamat datang, <?php echo $authenticatedUser['username']; ?> (Admin)</p>

    <h2>Karya Seni</h2>
    <ul>
        <?php foreach ($artworks as $artwork) : ?>
            <li>
                <?php echo $artwork['judul']; ?>
                <a href="?id_karya=<?php echo $artwork['id']; ?>">Hapus</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Logout</a>
</body>
</html>




