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
        "karyawanId",
        "keteranganIzin",
        "izinDari",
        "izinSampai",
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
    $izinDari = $_POST['izinDari'];
    $izinSampai = $_POST['izinSampai'];
    $keteranganIzin = $_POST['keteranganIzin'];
    /// Validasi karyawanId
    $karyawanId = $_POST['karyawanId'];
    $sql = "SELECT `karyawan_id` FROM `karyawan` WHERE `karyawan_id` = '$karyawanId'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Karyawan tidak terdaftar.'
        )));
    }

    if($izinDari > $izinSampai)
    {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Izin mulai harus lebih besar dari izin selesai.'
        )));
    }

    $sql = "SELECT `izin_id`, `izin_dari`, `izin_sampai` FROM `izin` WHERE `karyawan_id` = '$karyawanId' ORDER BY `izin_id` DESC LIMIT 1";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $izin_dari = $row['izin_dari'];
            $izin_sampai = $row['izin_sampai'];
        }
        $startdate = new DateTime($izin_dari);
        $enddate = new DateTime($izin_sampai);
        $now = new DateTime($izinDari);
        $now2 = new DateTime($izinSampai);

        if($izin_dari == $izinDari)
        {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Izin dari tanggal '.$izinDari.' sampai '.$izinSampai.' untuk karyawan tersebut sudah terdaftar.'
            )));
        }

        if($izin_sampai == $izinSampai)
        {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Izin dari tanggal '.$izinDari.' sampai '.$izinSampai.' untuk karyawan tersebut sudah terdaftar.'
            )));
        }
        
        if(($startdate <= $now && $now <= $enddate) || ($startdate <= $now2 && $now2 <= $enddate)) {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Izin dari tanggal '.$izinDari.' sampai '.$izinSampai.' untuk karyawan tersebut sudah terdaftar.'
            )));
        }
    }

    $sql = "INSERT INTO `izin` (`izin_id`, `karyawan_id`, `izin_nama`, `izin_dari`, `izin_sampai`) VALUES (NULL, '$karyawanId', '$keteranganIzin', '$izinDari', '$izinSampai');";
    if($koneksi->query($sql) === TRUE)
    {
        /// Sukses
        die(json_encode(array(
            'status' => true, 
            'message' => 'Data Izin berhasil di tambahkan.'
        )));
    }else{
        /// Terjadi Kesalahan MySQL
        die(json_encode(array(
            'status' => false, 
            'message' => 'Query Gagal : '.$koneksi->error.''
        )));
    }
}