<?php
$page = "Data Karyawan";
require_once("./header.php");
if (isset($_GET["karyawan_id"])) {
    $id = $_GET["karyawan_id"];
    $sql = "SELECT * FROM `karyawan` WHERE `karyawan_id` = '$id'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        header('location:./data_karyawan.php');
        exit();
    }
} else {
    header("location:./data_karyawan.php");
    exit();
}

$sql = "SELECT *
        FROM `karyawan`
        WHERE `karyawan`.`karyawan_id` = '$id'";
$result = $koneksi->query($sql);
while ($row = $result->fetch_assoc()) {
    $karyawan_id = $row['karyawan_id'];
    $karyawan_foto = $row['karyawan_foto'];
    $karyawan_rfid = $row['karyawan_rfid'];
    $karyawan_nama = $row['karyawan_nama'];
    $karyawan_nik = $row['karyawan_nik'];
    $karyawan_jeniskelamin = $row['karyawan_jeniskelamin'];
    $karyawan_lahir = $row['karyawan_lahir'];
    $karyawan_nomorhp = $row['karyawan_nomorhp'];
    $karyawan_alamat = $row['karyawan_alamat'];
    $karyawan_jabatan = $row['jabatan_id'];
}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Edit Data Karyawan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_karyawan.php">Data Karyawan</a></li>
                <li class="breadcrumb-item active">Edit Data Karyawan</li>
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
                    Edit Data Karyawan
                </div>
                <div class="card-body">
                    <form class="mb-5" action="./edit_karyawan_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanRfid">RFID UID</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" id="karyawanID" name="karyawanID"
                                    value="<?php echo $karyawan_id; ?>" autocomplete="off" required>
                                <input type="text" class="form-control" id="karyawanRfid" name="karyawanRfid"
                                    placeholder="Masukkan RFID UID" value="<?php echo $karyawan_rfid; ?>"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanNik">NIK</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="karyawanNik" name="karyawanNik"
                                    placeholder="Masukkan NIK" value="<?php echo $karyawan_nik; ?>" autocomplete="off"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanNama">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="karyawanNama" name="karyawanNama"
                                    placeholder="Masukkan Nama Lengkap" value="<?php echo $karyawan_nama; ?>"
                                    autocomplete="off" minlength="2" maxlength="50" required>
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
                                                if ($karyawan_jabatan == $jabatanId) {
                                                    echo '<option value="' . $jabatanId . '" selected>' . $jabatanNama . '</option>';
                                                } else {
                                                    echo '<option value="' . $jabatanId . '">' . $jabatanNama . '</option>';
                                                }
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
                                    <option value="M" <?php echo ($karyawan_jeniskelamin == 'M') ? "selected" : "" ?>>
                                        Pria</option>
                                    <option value="F" <?php echo ($karyawan_jeniskelamin == 'F') ? "selected" : "" ?>>
                                        Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanTgl">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="karyawanTgl" name="karyawanTgl"
                                    value="<?php echo $karyawan_lahir; ?>" autocomplete="off" required>
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
                                        placeholder="Masukkan Nomor Telepon" value="<?php echo $karyawan_nomorhp; ?>"
                                        autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanAlamat">Alamat Lengkap</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" id="karyawanAlamat" name="karyawanAlamat"
                                    placeholder="Masukkan Alamat Lengkap" minlength="4" maxlength="500"
                                    autocomplete="off" required><?php echo $karyawan_alamat; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="karyawanFoto">Foto Karyawan</label>
                            <div class="col-sm-7">
                                <img src="./image/<?php echo $karyawan_foto; ?>"
                                    style="width: 120px;float: left;margin-bottom: 10px;">
                                <input type="file" class="form-control-file" id="karyawanFoto" name="karyawanFoto"
                                    autocomplete="off" accept="image/*">
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
                        window.location =
                            "./edit_karyawan.php?karyawan_id=<?php echo $karyawan_id; ?>&msg=1";
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