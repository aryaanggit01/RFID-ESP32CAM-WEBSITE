<?php
$page = "Data Jabatan";
require_once("./header.php");
if (isset($_GET["jabatan_id"])) {
    $id = $_GET["jabatan_id"];
    $sql = "SELECT * FROM `jabatan` WHERE `jabatan_id` = '$id'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        header('location:./data_jabatan.php');
        exit();
    }
} else {
    header("location:./data_jabatan.php");
    exit();
}

$sql = "SELECT * FROM `jabatan` WHERE `jabatan`.`jabatan_id` = '$id'";
$result = $koneksi->query($sql);
while ($row = $result->fetch_assoc()) {
    $jabatan_id = $row['jabatan_id'];
    $jabatan_nama = $row['jabatan_nama'];
}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Edit Data Jabatan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_jabatan.php">Data Jabatan</a></li>
                <li class="breadcrumb-item active">Edit Data Jabatan</li>
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
                    Edit Data Jabatan
                </div>
                <div class="card-body">
                    <form class="mb-5" action="./edit_jabatan_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="jabatanNama">Jabatan Nama</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" id="jabatanID" name="jabatanID"
                                    value="<?php echo $jabatan_id; ?>" autocomplete="off" required>
                                <input type="text" class="form-control" id="jabatanNama" name="jabatanNama"
                                    placeholder="Masukkan Nama Jabatan" value="<?php echo $jabatan_nama; ?>"
                                    autocomplete="off" minlength="2" maxlength="50" required>
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