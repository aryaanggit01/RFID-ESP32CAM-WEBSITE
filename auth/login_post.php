<?php
session_start();
require_once("../config/db.php");
if(!$_POST['username'] || !$_POST['password']){
    header('location:./login.php?msg=1');
    exit();
}else{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM `admin` WHERE `admin_username` = '$username' AND `admin_password` = '$password'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        // Berhasil Login
        $_SESSION['username'] = $username;
        header('location:../index.php');
        exit();
    }else if ($result->num_rows < 1) {
        // Username/Password Salah
        header('location:./login.php?msg=2');
        exit();
    }else{
        // Terjadi Kesalahan
        header('location:./login.php?msg=3');
        exit();
    }
}
?>