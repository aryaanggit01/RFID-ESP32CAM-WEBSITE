<?php
$page = "Data Jadwal";
require_once("./header.php");
if (isset($_GET["jabatan_id"])) {
    $id = $_GET["jabatan_id"];
    $sql = "SELECT * FROM `jadwal` WHERE `jabatan_id` = '$id'";
    $result = $koneksi->query($sql);
    if ($result->num_rows < 1) {
        header('location:./data_jadwal.php');
        exit();
    }
} else {
    header("location:./data_jadwal.php");
    exit();
}
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Edit Data Jadwal</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="./data_jadwal.php">Data Jadwal</a></li>
                <li class="breadcrumb-item active">Edit Data Jadwal</li>
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
                    Edit Data Jadwal
                </div>
                <div class="card-body">
                    <!-- START -->
                    <form class="mb-5" action="./edit_jadwal_post.php" method="POST" id="appsform"
                        enctype="multipart/form-data">
                        <div class="form-group row table-responsive-md">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <input type="hidden" name="jabatan_id" value="<?php echo $id; ?>">
                                    <?php
                            $sql = "SELECT * FROM `jadwal` WHERE `jabatan_id` = '$id' ORDER BY `jadwal_id` ASC";
                            $result = $koneksi->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                $jadwal_id = $row['jadwal_id'];
                                $jabatan_id = $row['jabatan_id'];
                                $jadwal_hari = $row['jadwal_hari'];
                                $jadwal_masuk = $row['jadwal_masuk'];
                                $jadwal_pulang = $row['jadwal_pulang'];
                            ?>
                                    <tr>
                                        <th><?php echo $jadwal_hari ?></th>
                                        <td><input type="time" class="form-control bg-white"
                                                name="<?php echo strtolower($jadwal_hari) ?>[masuk]" step="1"
                                                value="<?php echo $jadwal_masuk ?>"></td>
                                        <td><input type="time" class="form-control bg-white"
                                                name="<?php echo strtolower($jadwal_hari) ?>[pulang]" step="1"
                                                value="<?php echo $jadwal_pulang ?>"></td>

                                    </tr>
                                    <?php
                            }
                            ?>
                                </tbody>
                            </table>
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