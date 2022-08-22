<?php
$page = "Data Rekap";
require_once("./header.php");
if (isset($_GET["rekap_id"])) {
    $id = $_GET["rekap_id"];
    $sql = "SELECT * FROM `rekap` WHERE `rekap_id` = '$id'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        header('location:./data_rekap.php');
        exit();
    }
} else {
    header("location:./data_rekap.php");
    exit();
}

$sql = "SELECT `rekap`.`rekap_id`, `karyawan`.`karyawan_foto`, `karyawan`.`karyawan_nama`, `rekap`.`rekap_tanggal`, `rekap`.`rekap_masuk`, `rekap`.`rekap_keluar`, `rekap`.`rekap_photomasuk`, `rekap`.`rekap_photokeluar`, `rekap`.`rekap_keterangan` 
        FROM `rekap` INNER JOIN `karyawan` ON `rekap`.`karyawan_id` = `karyawan`.`karyawan_id` WHERE `rekap`.`rekap_id` = '$id'";
$result = $koneksi->query($sql);
while ($row = $result->fetch_assoc()) {
    $rekap_id = $row['rekap_id'];
    $karyawan_foto = $row['karyawan_foto'];
    $karyawan_nama = $row['karyawan_nama'];
    $rekap_tanggal = $row['rekap_tanggal'];
    $rekap_masuk = $row['rekap_masuk'];
    $rekap_keluar = $row['rekap_keluar'];
    $rekap_photomasuk = $row['rekap_photomasuk'];
    $rekap_photokeluar = $row['rekap_photokeluar'];
    $rekap_keterangan = $row['rekap_keterangan'];
}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Edit Data Rekap</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_jabatan.php">Data Rekap</a></li>
                <li class="breadcrumb-item active">Edit Data Rekap</li>
            </ol>
            <!-- START MESSAGE -->
            <div id="response">
                <?php
                if (isset($_GET['msg']) && isset($_SERVER['HTTP_REFERER'])) {
                    if ($_GET['msg'] == 1 && $_SERVER['HTTP_REFERER']) {
                ?>
                <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
                    <strong>Berhasil update data!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- END MESSAGE -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Data Rekap
                </div>
                <div class="card-body">
                    <form class="mb-5" action="./edit_rekap_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="jabatanNama">Jabatan Nama</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" id="rekapID" name="rekapID"
                                    value="<?php echo $rekap_id; ?>" autocomplete="off" required>
                                <input type="text" class="form-control" id="jabatanNama" name="jabatanNama"
                                    placeholder="Masukkan Nama Jabatan" value="<?php echo $karyawan_nama; ?>"
                                    autocomplete="off" minlength="2" maxlength="50" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="rekapTanggal">Rekap Tanggal</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="rekapTanggal" name="rekapTanggal"
                                    value="<?php echo $rekap_tanggal; ?>" autocomplete="off" minlength="2"
                                    maxlength="50" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="rekapMasuk">Rekap Masuk</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control" id="rekapMasuk" name="rekapMasuk"
                                    value="<?php echo $rekap_masuk; ?>" autocomplete="off" minlength="2" maxlength="50"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="rekapKeluar">Rekap Keluar</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control" id="rekapKeluar" name="rekapKeluar"
                                    value="<?php echo $rekap_keluar; ?>" autocomplete="off" minlength="2" maxlength="50"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="rekapKeluar">Rekap Status</label>
                            <div class="col-sm-8">
                                <select class="custom-select" id="rekapStatus" name="rekapStatus" autocomplete="off"
                                    required>
                                    <option value="">- Pilih Rekap Status -</option>
                                    <option value="Hadir Masuk"
                                        <?php echo ($rekap_keterangan == 'Hadir Masuk') ? "selected" : "" ?>>
                                        Hadir Masuk</option>
                                    <option value="Hadir Pulang"
                                        <?php echo ($rekap_keterangan == 'Hadir Pulang') ? "selected" : "" ?>>
                                        Hadir Pulang</option>
                                    <option value="Hadir Terlambat"
                                        <?php echo ($rekap_keterangan == 'Hadir Terlambat') ? "selected" : "" ?>>
                                        Hadir Terlambat</option>
                                    <option value="Hadir Terlambat"
                                        <?php echo ($rekap_keterangan == 'Terlambat') ? "selected" : "" ?>>
                                        Terlambat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 ml-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php
    require_once("./footer.php");
    ?>
    <script>
    $(document).ready(function() {
        $("form#appsform").submit(function() {
            // Karena ada file tidak bisa pakai serialize
            // var postdata = $(this).serialize();
            var postdata = new FormData(this);
            var postaction = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: postaction,
                timeout: false,
                data: postdata,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.status) {
                        $("#response").html(
                            '<div class="alert alert-success alert-dismissible fade show text-center h4" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.message + '</div>');
                    } else {
                        $("#response").html(
                            '<div class="alert alert-danger alert-dismissible fade show text-center h4" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            response.message + '</div>');
                    }
                },
                error: function(_, _, errorMessage) {
                    $("#response").html(
                        '<div class="alert alert-danger alert-dismissible fade show text-center h4" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        errorMessage + '</div>');
                },
                beforeSend: function() {
                    $("#response").html(
                        '<div class="alert alert-warning alert-dismissible fade show text-center h4" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Loading...</div>'
                    );
                }
            });
            return false;
        });
    });
    </script>