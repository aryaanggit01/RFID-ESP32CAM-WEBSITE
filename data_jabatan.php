<?php
$page = "Data Jabatan";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Data Jabatan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Jabatan</li>
            </ol>
            <!-- START MESSAGE -->
            <?php
            if (isset($_GET['msg']) && isset($_SERVER['HTTP_REFERER'])) {
                if ($_GET['msg'] == 1 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Berhasil Menghapus Data Jabatan!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                } else if ($_GET['msg'] == 2 && $_SERVER['HTTP_REFERER']) {
            ?>
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                <strong>Gagal Menghapus Data Jabatan!</strong>
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
                        Data Jabatan
                    </div>
                    <div>
                        <a href="./tambah_jabatan.php">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Tambah Data Jabatan
                            </button>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Jabatan</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                            $sql = "SELECT * FROM `jabatan` ORDER BY `jabatan`.`jabatan_id` ASC";
                            $result = $koneksi->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $jabatan_id = $row['jabatan_id'];
                                $jabatan_nama = $row['jabatan_nama'];
                            ?>
                                <tr>
                                    <td><?php echo $jabatan_id; ?></td>
                                    <td><?php echo $jabatan_nama; ?></td>
                                    <td>
                                        <a href="edit_jabatan.php?jabatan_id=<?php echo $jabatan_id; ?>"
                                            class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="hapus_jabatan.php?jabatan_id=<?php echo $jabatan_id; ?>"
                                            class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><i
                                                class="fas fa-trash"></i> Hapus</a>
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