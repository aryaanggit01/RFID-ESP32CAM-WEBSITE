<?php
  require_once("./config/db.php");

  $qry = "SELECT * FROM rfid_code where used=0 order by id desc limit 1";
  $query = mysqli_query($koneksi, $qry);
  $row = mysqli_fetch_array($query);
  if(!$query) {
    $rfid_code = '';
  } else {
    $rfid_code = $row['rfid_code'];
  }
  if (isset($_GET['do']) && $_GET['do'] == 'get_rfid_code') {
    echo $rfid_code;
  }
?>