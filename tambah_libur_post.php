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
        "keteranganLibur",
        "liburDari",
        "liburSampai",
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
    $keteranganLibur = $_POST['keteranganLibur'];
    $liburDari = $_POST['liburDari'];
    $liburSampai = $_POST['liburSampai'];

    if($liburDari > $liburSampai)
    {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Libur mulai harus lebih besar dari libur selesai.'
        )));
    }

    $sql = "SELECT `libur_dari`, `libur_sampai` FROM `libur` ORDER BY `libur_id` DESC LIMIT 1";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $libur_dari = $row['libur_dari'];
            $libur_sampai = $row['libur_sampai'];
        }
        $startdate = new DateTime($libur_dari);
        $enddate = new DateTime($libur_sampai);
        $now = new DateTime($liburDari);
        $now2 = new DateTime($liburSampai);

        if($libur_dari == $liburDari)
        {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Libur dari tanggal '.$liburDari.' sampai '.$liburSampai.' tersebut sudah terdaftar.'
            )));
        }

        if($libur_sampai == $liburSampai)
        {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Libur dari tanggal '.$liburDari.' sampai '.$liburSampai.' tersebut sudah terdaftar.'
            )));
        }
        
        if(($startdate <= $now && $now <= $enddate) || ($startdate <= $now2 && $now2 <= $enddate)) {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Libur dari tanggal '.$liburDari.' sampai '.$liburSampai.' tersebut sudah terdaftar.'
            )));
        }
    }

    $sql = "INSERT INTO `libur` VALUES (NULL, '$keteranganLibur', '$liburDari', '$liburSampai');";
    if($koneksi->query($sql) === TRUE)
    {
        /// Sukses
        die(json_encode(array(
            'status' => true, 
            'message' => 'Data Libur berhasil di tambahkan.'
        )));
    }else{
        /// Terjadi Kesalahan MySQL
        die(json_encode(array(
            'status' => false, 
            'message' => 'Query Gagal : '.$koneksi->error.''
        )));
    }
}