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
        "rekapID",
        "rekapStatus",
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

    $rekapID = $_POST['rekapID'];
    $rekapStatus = $_POST['rekapStatus'];
    if($rekapStatus != "Hadir Masuk" && $rekapStatus != "Hadir Pulang" && $rekapStatus != "Hadir Terlambat" && $rekapStatus != "Alpa")
    {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Rekap Status tidak valid'
        )));
    }

    $sql = "UPDATE `rekap` SET `rekap_keterangan` = '$rekapStatus' WHERE `rekap`.`rekap_id` = '$rekapID';";
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