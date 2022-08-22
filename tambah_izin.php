<?php
$page = "Data Izin";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Tambah Data Izin</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_izin.php">Data Izin</a></li>
                <li class="breadcrumb-item active">Tambah Data Izin</li>
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
                    <i class="fas fa-plus-square mr-1"></i>
                    Tambah Data Izin
                </div>
                <div class="card-body">
                    <form class="mb-5" action="./tambah_izin_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanId">Karyawan Nama</label>
                            <div class="col-sm-8">
                                <select class="custom-select" id="karyawanId" name="karyawanId"
                                    autocomplete="off" required>
                                    <?php
                                        $sql = "SELECT `karyawan`.`karyawan_id`, `karyawan`.`karyawan_nama`, `karyawan`.`karyawan_nik` FROM `karyawan`";
                                        $result = $koneksi->query($sql);

                                        if ($result->num_rows > 0) {
                                            echo '<option value="">- Pilih Karyawan -</option>';
                                            while ($row = $result->fetch_assoc()) {
                                                $karyawanID = $row['karyawan_id'];
                                                $karyawanNama = $row['karyawan_nama'];
                                                $karyawanNIK = $row['karyawan_nik'];
                                                echo '<option value="' . $karyawanID . '">' . $karyawanNama . ' - ' . $karyawanNIK . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">- Karyawan Tidak Ditemukan -</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="keteranganIzin">Keterangan Izin</label>
                            <div class="col-sm-8">
                                <select class="custom-select" id="keteranganIzin" name="keteranganIzin" autocomplete="off"
                                    required>
                                    <option value="">- Pilih Keterangan Izin -</option>
                                    <option value="Sakit">Cuti Sakit</option>
                                    <option value="Cuti Hamil">Cuti Hamil</option>
                                    <option value="Cuti Tahunan">Cuti Tahunan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="izinDari">Dari Tanggal</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="izinDari" name="izinDari"
                                    placeholder="Masukkan Nama Jabatan" autocomplete="off" minlength="2" maxlength="50"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="izinSampai">Sampai Tanggal</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="izinSampai" name="izinSampai"
                                    placeholder="Masukkan Nama Jabatan" autocomplete="off" minlength="2" maxlength="50"
                                    required>
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
                        $("#appsform")[0].reset();
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