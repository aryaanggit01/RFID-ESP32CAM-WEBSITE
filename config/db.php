<?php
// error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
$host     = "localhost";
$username = "root";
$password = "";
$database = "ta_absensi";

// Membuat $hostname
$koneksi = new mysqli($host, $username, $password, $database);

// Cek Koneksi
if ($koneksi->connect_error) {
    die("Koneksi Gagal : " . $koneksi->connect_error);
}
?>