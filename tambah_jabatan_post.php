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

    /// Validasi jabatanNama
    $jabatanNama = $_POST['jabatanNama'];
    if (validasi_jabatan($jabatanNama) == FALSE) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nama Jabatan tidak boleh lebih dari 50 karakter!.'
        )));
    }

    $sql = "SELECT * FROM `jabatan` WHERE `jabatan_nama` = '$jabatanNama'";
    $result = $koneksi->query($sql);
    if ($result->num_rows > 0) {
        die(json_encode(array(
            'status' => false, 
            'message' => 'Nama Jabatan sudah terdaftar.'
        )));
    }

    $sql = "INSERT INTO `jabatan` (`jabatan_id`, `jabatan_nama`) VALUES (NULL, '$jabatanNama');";
    if($koneksi->query($sql) === TRUE)
    {
        $sql = "SELECT * FROM `jabatan` WHERE `jabatan_nama` = '$jabatanNama'";
        $result = $koneksi->query($sql);
        while($row = $result->fetch_assoc()) {
            $jabatan_id = $row['jabatan_id'];
        }
        
        $postNames = array(
            "senin",
            "selasa",
            "rabu",
            "kamis",
            "jumat",
            "sabtu",
            "minggu",
        );

        $sql = "";
        foreach ($postNames as $postname) {
            $hari = ucfirst($postname);
            $sql .= "INSERT INTO `jadwal` (`jadwal_id`, `jabatan_id`, `jadwal_hari`, `jadwal_masuk`, `jadwal_pulang`) VALUES (NULL, '$jabatan_id', '$hari', '00:00:00', '00:00:00');";
        }
        if($koneksi->multi_query($sql) === TRUE)
        {
            /// Sukses
            die(json_encode(array(
                'status' => true, 
                'message' => 'Data Jabatan berhasil di tambahkan.'
            )));
        }else{
            /// Terjadi Kesalahan MySQL
            die(json_encode(array(
                'status' => false, 
                'message' => 'Query Gagal : '.$koneksi->error.''
            )));
        }
    }else{
        /// Terjadi Kesalahan MySQL
        die(json_encode(array(
            'status' => false, 
            'message' => 'Query Gagal : '.$koneksi->error.''
        )));
    }
}