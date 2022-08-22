<?php
session_start();
require_once("./config/db.php");
require_once("./config/function.php");

if (!$_SESSION['username']) {
    die(json_encode(array(
        'status' => false, 
        'message' => 'Session kamu berakhir, Silahkan login ulang.'
    )));
}

if (isset($_POST)) {
    /// Validasi post name yang kosong
    $postNames = array(
        "jabatanID",
        "jabatanNama",
    );

    foreach ($postNames as $postname) {
        /// JIka ada postname yang panjang lenghtnya 0
        if (!strlen($_POST[$postname])) {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Silahkan isi semua form dengan baik dan benar'
            )));
        }
    }

    /// Validasi jabatanID
    $jabatanID = $_POST['jabatanID'];
    if (is_numeric($jabatanID) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Jabatan ID Tidak Valid!.'
        )));
    }

    $sql = "SELECT * FROM `jabatan` WHERE `jabatan_id` = '$jabatanID'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Jabatan ID tidak terdaftar.'
        )));
    }

    /// Validasi jabatanNama
    $jabatanNama = $_POST['jabatanNama'];
    if (validasi_jabatan($jabatanNama) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nama Jabatan tidak boleh lebih dari 50 karakter!.'
        )));
    }

    $sql = "SELECT * FROM `jabatan` WHERE `jabatan_nama` = '$jabatanNama' AND `jabatan_id` <> '$jabatanID'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nama Jabatan sudah terdaftar.'
        )));
    }

    $sql = "UPDATE `jabatan` SET `jabatan_nama` = '$jabatanNama' WHERE `jabatan`.`jabatan_id` = '$jabatanID';";
    if($koneksi->query($sql) === TRUE)
    {
        /// Sukses
        die(json_encode(array(
            'status' => true, 
            'message' => 'Data Jabatan berhasil di Update.'
        )));
    }else{
        /// Terjadi Kesalahan MySQL
        die(json_encode(array(
            'status' => false, 
            'message' => 'Query Gagal : '.$koneksi->error.''
        )));
    }
}