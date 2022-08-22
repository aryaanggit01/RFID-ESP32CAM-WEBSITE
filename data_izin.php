<?php
$page = "Data Izin";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Data Izin</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Izin</li>
            </ol>
            <!-- START MESSAGE -->
            <?php
            if (isset($_GET['msg']) && isset($_SERVER['HTTP_REFERER'])) {
                if ($_GET['msg'] == 1 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Berhasil Menghapus Data Izin!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                } else if ($_GET['msg'] == 2 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Gagal Menghapus Data Izin!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                }
            }
            ?>
            <!-- END MESSAGE -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table mr-1"></i>
                        Data Izin
                    </div>
                    <div>
                        <a href="./tambah_izin.php">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Tambah Data Izin
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Karyawan NIK</th>
                                    <th>Karyawan Nama</th>
                                    <th>Karyawan Jabatan</th>
                                    <th>Keterangan Izin</th>
                                    <th>Mulai Izin</th>
                                    <th>Sampai Izin</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Karyawan NIK</th>
                                    <th>Karyawan Nama</th>
                                    <th>Karyawan Jabatan</th>
                                    <th>Keterangan Izin</th>
                                    <th>Mulai Izin</th>
                                    <th>Sampai Izin</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            <?php
                            $sql = "SELECT `izin`.`izin_id`, `karyawan`.`karyawan_nama`, `karyawan`.`karyawan_nik`, `jabatan`.`jabatan_nama`, `izin`.`izin_nama`, `izin`.`izin_dari`, `izin`.`izin_sampai` 
                                    FROM `izin` 
                                    INNER JOIN `karyawan` ON `izin`.`karyawan_id` = `karyawan`.`karyawan_id`
                                    INNER JOIN `jabatan` ON `karyawan`.`jabatan_id` = `jabatan`.`jabatan_id`
                                    ORDER BY `izin_id` DESC";
                            $result = $koneksi->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $izin_id = $row['izin_id'];
                                $karyawan_nama = $row['karyawan_nama'];
                                $karyawan_nik = $row['karyawan_nik'];
                                $jabatan_nama = $row['jabatan_nama'];
                                $izin_nama = $row['izin_nama'];
                                $izin_dari = $row['izin_dari'];
                                $izin_sampai = $row['izin_sampai'];
                            ?>
                                <tr>
                                    <td><?php echo $karyawan_nik; ?></td>
                                    <td><?php echo $karyawan_nama; ?></td>
                                    <td><?php echo $jabatan_nama; ?></td>
                                    <td><?php echo $izin_nama; ?></td>
                                    <td><?php echo format_hari_tanggal($izin_dari); ?></td>
                                    <td><?php echo format_hari_tanggal($izin_sampai); ?></td>
                                    <td>
                                        <a href="hapus_izin.php?izin_id=<?php echo $izin_id; ?>" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-trash"></i>
                                            Hapus</a>
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