<?php
require_once("./config/db.php");
require_once("./config/function.php");

if(isset($_GET['tanggal']) && isset($_GET['jabatan_id'])){
    if($_GET['jabatan_id'] == NULL)
    {
        $mode = 0;
        $jabatan_id = $_GET['jabatan_id'];
    }else{
        $mode = 1;
        $jabatan_id = $_GET['jabatan_id'];
    }
}else{
    header("location:./");
}

$data_tanggal = explode('-', $_GET['tanggal']);

$tahun = intval($data_tanggal[0]);
$bulan = intval($data_tanggal[1]);
$tanggal = intval($data_tanggal[2]);

$jumlah_tanggal_pada_bulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tanggal);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rekap</title>
    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/css/rekap.css" rel="stylesheet">
</head>
<div class="container-fluid">
    <h1 class="text-center">REKAP BULAN KE-<?php echo $bulan; ?></h1>
    <table id="employee_data" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th class="nama">Nama</th>
                <?php
                for ($i = 1; $i <= $jumlah_tanggal_pada_bulan; $i++) {
            ?>
                <th scope="row"><?php echo $i ?></th>
                <?php
                }
            ?>
                <th>Jumlah</th>
            </tr>
        </thead>
        <button type="button" id="export_button" class="btn btn-success btn-sm">Export</button>
        <?php
        $no = 1;
        if($mode == 1)
        {
            $sql = "SELECT * FROM `karyawan` WHERE `jabatan_id` = '$jabatan_id' ORDER BY `karyawan_id` ASC";
        }else{
            $sql = "SELECT * FROM `karyawan` ORDER BY `karyawan_id` ASC";
        }
		$query = $koneksi->query($sql);
		while ($data = $query->fetch_array()) {
			$data_result[] = array(
				'karyawan_id' => $data['karyawan_id'],
                'karyawan_nama' => $data['karyawan_nama'],
                'jabatan_id' => $data['jabatan_id'],
			);
		}
		?>

        <?php
		foreach ($data_result as $row) {
            $karyawan_id = $row['karyawan_id'];
            $jabatan_id = $row['jabatan_id'];
		?>
        <tr>
            <td style="text-align: center;"><?php echo $no ?></td>
            <td><?php echo $row['karyawan_nama'] ?></td>


            <?php
			$data_absen = $koneksi->query("SELECT `rekap_tanggal` FROM `rekap` WHERE MONTH(`rekap_tanggal`)='$bulan' GROUP BY `rekap_tanggal`");
            $sql = "SELECT *, COUNT(karyawan_id) jumlah FROM `rekap` WHERE MONTH(`rekap_tanggal`) ='$bulan' AND karyawan_id='$row[karyawan_id]'";
			$jumlah = $koneksi->query($sql);
            $jumlah_kehadiran = $jumlah->fetch_array();
            $libur = false;
			for ($i = 1; $i <= $jumlah_tanggal_pada_bulan; $i++) {
                $full_tanggal = "$tahun-$bulan-$i";
                $sql = "SELECT * FROM `rekap` WHERE `rekap_tanggal` = '$full_tanggal' AND `karyawan_id` = '$row[karyawan_id]' GROUP BY `karyawan_id`";
				$kehadiran = $koneksi->query($sql);
                $data_kehadiran = $kehadiran->fetch_array();
				if (intval(substr($data_kehadiran['rekap_tanggal'], 8)) == $i) {
                    $keterangan = $data_kehadiran['rekap_keterangan'];

                    $sql = "SELECT * FROM `libur` WHERE '$full_tanggal' between `libur_dari` and `libur_sampai`";
                    $result = $koneksi->query($sql);

                    $sql2 = "SELECT * FROM `izin` WHERE '$full_tanggal' AND `karyawan_id` between `izin_dari` and `izin_sampai`";
                    $result2 = $koneksi->query($sql2);

                    $time = strtotime($full_tanggal);
                    $hari = hari_indonesia(date('D', $time));

                    $sql3 = "SELECT * FROM `jadwal` WHERE `jabatan_id` = '$jabatan_id' AND `jadwal_hari` = '$hari' AND `jadwal_masuk` = '00:00:00' AND `jadwal_pulang` = '00:00:00'";
                    $result3 = $koneksi->query($sql3);

                    if ($result->num_rows > 0) {
                        echo "<td class='yellow'>L</td>";
                    } else if ($result2->num_rows > 0) {
                        echo "<td class='yellow'>C</td>";
                    } else if($result3->num_rows > 0) {
                        echo "<td class='yellow'>L</td>";
                    } else {
                        if ($keterangan == 'Hadir Masuk') {
                            echo "<td class='orange'>H.M</td>";
                        }else if($keterangan == 'Hadir Pulang') {
                            echo "<td class='green'>H.P</td>";
                        }else if($keterangan == 'Hadir Terlambat') {
                            echo "<td class='red'>H.T</td>";
                        }
                    }
				} else {
					echo "<td class='null'>-</td>";
				}
			}
			echo "<td class='null'>" . $jumlah_kehadiran['jumlah'] . "</td>";
			echo "</tr>";
			$no++;
		}
			?>
    </table>
</div>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>

    function html_table_to_excel(type)
    {
        var data = document.getElementById('employee_data');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'file.' + type);
    }

    const export_button = document.getElementById('export_button');

    export_button.addEventListener('click', () =>  {
        html_table_to_excel('xlsx');
    });

</script>