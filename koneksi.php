<?php
$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "artwork";

$koneksi = new mysqli($host, $db_username, $db_password, $db_name);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}
?>
