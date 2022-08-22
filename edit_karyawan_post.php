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
    
    /// VALIDASI FOTO
    $updateKaryawanFoto = false;
    $karyawanFoto = $_FILES['karyawanFoto'];
    if($karyawanFoto['size'] != 0)
    {
        $updateKaryawanFoto = true;
    }

    /// Validasi post name yang kosong
    $postNames = array(
        "karyawanID", 
        "karyawanRfid", 
        "karyawanNik", 
        "karyawanNama", 
        "karyawanJabatan", 
        "karyawanJK", 
        "karyawanTgl", 
        "karyawanNohp", 
        "karyawanAlamat"
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

    $karyawanID = $_POST['karyawanID'];
    /// Validasi RFID
    $karyawanRFID = $_POST['karyawanRfid'];
    if (validasi_rfid($karyawanRFID) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'RFID Tidak Valid! RFID terdiri dari 10 angka.'
        )));
    }

    $sql = "SELECT `karyawan_rfid` FROM `karyawan` WHERE `karyawan_rfid` = '$karyawanRFID' AND `karyawan_id` <> '$karyawanID'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'RFID sudah terdaftar.'
        )));
    }

    /// Validasi NIK
    $karyawanNIK = $_POST['karyawanNik'];
    if (validasi_nik($karyawanNIK) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'NIK Tidak Valid! NIK terdiri dari 16 angka.'
        )));
    }

    $sql = "SELECT `karyawan_nik` FROM `karyawan` WHERE `karyawan_nik` = '$karyawanNIK' AND `karyawan_id` <> '$karyawanID'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'NIK sudah terdaftar.'
        )));
    }

    /// Validasi NAMA
    $karyawanNama = $_POST['karyawanNama'];
    if (validasi_nama($karyawanNama) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nama minimal 2 karakter dan tidak boleh lebih dari 50 karakter.'
        )));
    }

    /// Validasi Jabatan
    $karyawanJabatan = $_POST['karyawanJabatan'];
    $sql = "SELECT * FROM `jabatan` WHERE `jabatan_id` = '$karyawanJabatan'";
    $result = $koneksi->query($sql);
    if ($result->num_rows <= 0) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Form Jabatan tidak valid.'
        )));
    }

    /// Validasi Jenis Kelamin
    $karyawanJenisKelamin = $_POST['karyawanJK'];
    if (validasi_jk($karyawanJenisKelamin) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Form Jenis Kelamin tidak valid.'
        )));
    }

    /// Validasi Tanggal Lahir
    $karyawanTanggalLahir = $_POST['karyawanTgl'];
    if (validasi_tanggal($karyawanTanggalLahir) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Form Tanggal Lahir tidak valid.'
        )));
    }

    /// Validasi No HP
    $karyawanNohp = $_POST['karyawanNohp'];
    if (validasi_nohp($karyawanNohp) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nomor HP tidak valid.'
        )));
    }

    /// Validasi Alamat
    $karyawanAlamat = $_POST['karyawanAlamat'];
    if (validasi_alamat($karyawanAlamat) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Alamat tidak boleh lebih dari 500 karakter.'
        )));
    }

    /// VALIDASI FOTO
    if ($updateKaryawanFoto) {
        $targetDir = "./image/";
        $response = validasi_foto($karyawanFoto, $targetDir);
        if ($response == FALSE) {
            die(json_encode(array(
                'status' => false, 
                'message' => 'Foto Karyawan tidak valid! Maksimal ukuran 10 MB dan ekstensi PNG/JPG/JPEG.'
            )));
        }
        $sql = "UPDATE `karyawan` 
                SET `jabatan_id` = '$karyawanJabatan', `karyawan_rfid` = '$karyawanRFID', `karyawan_nama` = '$karyawanNama', `karyawan_nik` = '$karyawanNIK', `karyawan_jeniskelamin` = '$karyawanJenisKelamin', `karyawan_lahir` = '$karyawanTanggalLahir', `karyawan_nomorhp` = '$karyawanNohp', `karyawan_alamat` = '$karyawanAlamat', `karyawan_foto` = '$response'
                WHERE `karyawan`.`karyawan_id` = '$karyawanID';";
    }else{
        $sql = "UPDATE `karyawan` 
                SET `jabatan_id` = '$karyawanJabatan', `karyawan_rfid` = '$karyawanRFID', `karyawan_nama` = '$karyawanNama', `karyawan_nik` = '$karyawanNIK', `karyawan_jeniskelamin` = '$karyawanJenisKelamin', `karyawan_lahir` = '$karyawanTanggalLahir', `karyawan_nomorhp` = '$karyawanNohp', `karyawan_alamat` = '$karyawanAlamat'
                WHERE `karyawan`.`karyawan_id` = '$karyawanID';";
    }
    if($koneksi->query($sql) === TRUE)
    {
        /// Sukses
        die(json_encode(array(
            'status' => true, 
            'message' => 'Data Karyawan berhasil di Update.'
        )));
    }else{
        /// Terjadi Kesalahan MySQL
        die(json_encode(array(
            'status' => false, 
            'message' => 'Query Gagal : '.$koneksi->error.''
        )));
    }
}