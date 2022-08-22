<?php
$page = "Data Karyawan";
require_once("./header.php");
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Tambah Data Karyawan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_karyawan.php">Data Karyawan</a></li>
                <li class="breadcrumb-item active">Tambah Data Karyawan</li>
            </ol>
            <!-- START MESSAGE -->
            <div id="response"></div>
            <!-- END MESSAGE -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-plus-square mr-1"></i>
                    Tambah Data Karyawan
                </div>
                <div class="card-body">
                    <form class="mb-5" action="./tambah_karyawan_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanRfid">RFID UID</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="karyawanRfid" name="karyawanRfid"
                                    placeholder="Masukkan RFID UID" autocomplete="off" required readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanNik">NIK</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="karyawanNik" name="karyawanNik"
                                    placeholder="Masukkan NIK" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanNama">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="karyawanNama" name="karyawanNama"
                                    placeholder="Masukkan Nama Lengkap" autocomplete="off" minlength="2" maxlength="50"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanJabatan">Jabatan</label>
                            <div class="col-sm-8">
                                <select class="custom-select" id="karyawanJabatan" name="karyawanJabatan"
                                    autocomplete="off" required>
                                    <?php
                                        $sql = "SELECT * FROM `jabatan` ORDER BY `jabatan_id` ASC";
                                        $result = $koneksi->query($sql);

                                        if ($result->num_rows > 0) {
                                            echo '<option value="">- Pilih Jabatan -</option>';
                                            while ($row = $result->fetch_assoc()) {
                                                $jabatanId = $row['jabatan_id'];
                                                $jabatanNama = $row['jabatan_nama'];

                                                echo '<option value="' . $jabatanId . '">' . $jabatanNama . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">- Jabatan Tidak Ditemukan -</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanJK">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <select class="custom-select" id="karyawanJK" name="karyawanJK" autocomplete="off"
                                    required>
                                    <option value="">- Pilih Jenis Kelamin -</option>
                                    <option value="M">Pria</option>
                                    <option value="F">Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanTgl">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="karyawanTgl" name="karyawanTgl"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanNohp">Nomor Telepon <small
                                    style="color:red">Contoh : 62822xxxx4496</small></label>
                            <div class="col-sm-8">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+</div>
                                    </div>
                                    <input type="number" class="form-control" id="karyawanNohp" name="karyawanNohp"
                                        placeholder="Masukkan Nomor Telepon" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanAlamat">Alamat Lengkap</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="karyawanAlamat" name="karyawanAlamat"
                                    placeholder="Masukkan Alamat Lengkap" minlength="4" maxlength="500"
                                    autocomplete="off" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanFoto">Foto Karyawan</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control-file" id="karyawanFoto" name="karyawanFoto"
                                    autocomplete="off" accept="image/*" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8 ml-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" id="reset" class="btn btn-danger">Reset</button>
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
        $('#karyawanRfid').focus();
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
                        timerQuery();
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

    timerQuery();

    function executeQuery() {
    $.ajax({
        url: 'action.php?do=get_rfid_code',
        success: function(data) {
        if($(location).attr('search') !== '') {
        window.location.href = $(location).attr('pathname');
        }
        $("#karyawanRfid").val(data);
        $('#karyawanNik').focus();
        }
    });
    }

    function timerQuery() {
        var timeout = setInterval(function() {
        if (!$("#karyawanRfid").val()) {
            executeQuery();
        } else {
            clearInterval(timeout);
        }
        }, 2000);
    }

    $("#reset").click(function() {
        timerQuery();
    });

    });
    </script>