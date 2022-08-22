<?php
$page = "Dashboard";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Rekap Absen <small>Hari Ini</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Masuk</th>
                                    <th>Pulang</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                            $sql = "SELECT `rekap`.`rekap_id`, `rekap`.`rekap_tanggal`, `jabatan`.`jabatan_nama`, `karyawan`.`jabatan_id`, `karyawan`.`karyawan_nama`, `rekap`.`rekap_masuk`, `rekap`.`rekap_keluar`, `rekap`.`rekap_keterangan` 
                            FROM `rekap`
                            INNER JOIN `karyawan` ON `rekap`.`karyawan_id` = `karyawan`.`karyawan_id`
                            INNER JOIN `jabatan` ON `karyawan`.`jabatan_id` = `jabatan`.`jabatan_id`
                            WHERE `rekap_tanggal` = CURRENT_DATE";
                            $result = $koneksi->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $rekap_id = $row['rekap_id'];
                                $tanggal = $row['rekap_tanggal'];
                                $nama = $row['karyawan_nama'];
                                $jabatan = $row['jabatan_nama'];
                                $masuk = $row['rekap_masuk'];
                                $pulang = $row['rekap_keluar'];
                                $status = $row['rekap_keterangan'];
                            ?>
                                <tr>
                                    <td><?php echo $tanggal ?></td>
                                    <td><?php echo $nama ?></td>
                                    <td><?php echo $jabatan ?></td>
                                    <td><?php echo $masuk ?></td>
                                    <td><?php echo $pulang ?></td>
                                    <td><?php echo $status ?></td>
                                    <td>
                                        <a href="edit_rekap.php?rekap_id=<?php echo $rekap_id; ?>"
                                            class="btn btn-primary"><i class="fas fa-edit"> </i> Lihat atau Edit</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
require_once("./footer.php");
?>