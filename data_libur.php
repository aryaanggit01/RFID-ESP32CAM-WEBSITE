<?php
$page = "Data Libur";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Data Libur</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Libur</li>
            </ol>
            <!-- START MESSAGE -->
            <?php
            if (isset($_GET['msg']) && isset($_SERVER['HTTP_REFERER'])) {
                if ($_GET['msg'] == 1 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Berhasil Menghapus Data Libur!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                } else if ($_GET['msg'] == 2 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Gagal Menghapus Data Libur!</strong>
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
                        Data Libur
                    </div>
                    <div>
                        <a href="./tambah_libur.php">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Tambah Data Libur
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Keterangan Libur</th>
                                    <th>Libur Dari</th>
                                    <th>Libur Sampai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Keterangan Libur</th>
                                    <th>Libur Dari</th>
                                    <th>Libur Sampai</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                            $sql = "SELECT * FROM `libur`";
                            $result = $koneksi->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $libur_id = $row['libur_id'];
                                $libur_keterangan = $row['libur_keterangan'];
                                $libur_dari = $row['libur_dari'];
                                $libur_sampai = $row['libur_sampai'];
                            ?>
                                <tr>
                                    <td><?php echo $libur_keterangan; ?></td>
                                    <td><?php echo $libur_dari; ?></td>
                                    <td><?php echo $libur_sampai; ?></td>
                                    <td>
                                        <a href="hapus_libur.php?libur_id=<?php echo $libur_id; ?>" class="btn btn-danger"
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