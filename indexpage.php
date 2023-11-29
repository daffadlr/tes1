<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pameran Karya Seni</title>
  <style>
    body {
      background-image: url('abu.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      font-family: 'Times New Roman', Times, serif;
    }

    a {
      text-decoration: none;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #444;
      color: #fff;
      padding: 10px;
    }

    header h1 {
      margin-right: 20px;
      color: #fff;
      margin-left: 20px;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    nav li {
      display: inline-block;
      margin-right: 10px;
    }

    .user-options {
      display: flex;
      gap: 10px;
    }

    .user-options a {
      color: #fff;
    }

    .center-content {
      text-align: center;
      margin-top: 20px;
    }

    .center-content img {
      width: 300px;
      height: auto;
      margin: 10px;
    }

    .center-content p {
      font-size: 18px;
      line-height: 1.6;
      border: 2px solid #444; /* Menambah border 2px solid dengan warna sesuai kebutuhan */
      padding: 10px; /* Menambah padding agar isi paragraf terlihat lebih baik */
    }
  </style>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="logo"></div>
    <h1>Art Exhibition</h1>
    <nav id="indexpage">
      <ul>
        <li><a href="lihatkarya.php">Lihat Karya</a></li>
        <li><a href="update.php">Tambah Karya</a></li>
        <li><a href="beli.php">Beli Karya</a></li>
        <li><a href="delete.php">Hapus Karya</a></li>
        <li><a href="register.php">Register</a></li>
      </ul>
      <div class="user-options">
        <a href="login.php">Login</a>
        <a href="logout.php">Logout</a>
      </div>
    </nav>
  </header>

  <div class="center-content">
    <img src="fotoseni.jpg" alt="Seni Foto">
    <img src="senifoto.jpg" alt="Foto Seni">
    <p>Ini adalah beberapa contoh karya seni yang memukau. Jelajahi berbagai karya seni dari seniman-seniman berbakat di sini.</p>
  </div>
</body>
</html>

