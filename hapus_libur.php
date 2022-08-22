<?php
session_start();
require_once("./config/db.php");
require_once("./config/function.php");

if (!$_SESSION['username']) {
    header('Location: ./auth/login.php');
    exit();
}

if (isset($_GET["libur_id"])) {
    $id = $_GET["libur_id"];
    $sql = "SELECT * FROM `libur` WHERE `libur_id` = '$id'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        header('location:./data_libur.php');
        exit();
    }

    $sql = "DELETE FROM `libur` WHERE `libur_id` = $id";

    if ($koneksi->query($sql) === TRUE) {
        header('location:./data_libur.php?msg=1');
        exit();
    } else {
        header('location:./data_libur.php?msg=2');
        exit();
    }
} else {
    header("location:./data_libur.php");
    exit();
}