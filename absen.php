<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home - Absensi</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    </script>
</head>

<style>
video {
    max-width: 100%;
    height: auto;
}
</style>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Absensi Yono Express Service</h3>
                                </div>
                                <div class="card-body">
                                    <div id="response"></div>
                                    <form action="./cam_save.php" method="POST" id="registerSubmit">
                                        <video class="embed-responsive-item" id="video" autoplay></video>
                                        <div id="txt"></div>
                                        <div class="form-group">
                                            <h6 class="text-center text-muted">Silahkan TAP Kartu Kamu</h6>
                                            <input class="form-control py-4" name="rfid" id="rfid" type="text"
                                                placeholder="TAP Kartu Kamu" maxlength="10" autocomplete="off"
                                                autofocus>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="./">Kembali ke Admin Panel</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <canvas style="display:none;"></canvas>
    <!-- END -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
    var video = document.getElementById('video');

    // Mendapatkan akses ke kamera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({
            video: true
        }).then(function(stream) {
            video.srcObject = stream;
            video.play();
        });
    }
    const canvas = document.createElement('canvas');

    // Trigger takePhoto
    $(document).ready(function() {
        $("form#registerSubmit").submit(function() {
            takePhoto();
            return false;
        });
    });

    function takePhoto() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        var dataUrl = canvas.toDataURL("image/png");
        console.log(dataUrl);
        var pdata = jQuery("#rfid").val();
        var purl = $('#registerSubmit').attr('action');
        $.ajax({
            type: "POST",
            url: purl,
            timeout: false,
            dataType: 'JSON',
            data: {
                rfid: pdata,
                imgBase64: dataUrl,
            },
            success: function(response) {
                if (response.status) {
                    $("#response").html(
                        '<div class="alert alert-success alert-dismissible fade show text-center h1" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        response.message + '</div>');
                } else {
                    $("#response").html(
                        '<div class="alert alert-danger alert-dismissible fade show text-center h1" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                        response.message + '</div>');
                }
                $("#rfid").val('');
            },
            error: function(_, _, errorMessage) {
                $("#response").html(
                    '<div class="alert alert-danger alert-dismissible fade show text-center h1" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    errorMessage + '</div>');
            },
            beforeSend: function() {
                $("#response").html(
                    '<div class="alert alert-warning alert-dismissible fade show text-center h4" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Loading...</div>'
                );
            }
        });
    }

    // Jam Waktu
    $(document).ready(function() {
        startTime();
        setInterval(startTime, 500);
    })

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML = `<h1 class="text-center">${h}:${m}:${s}</h1>`;
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // jika jam dibawah 10 maka ditambahkan angka 0 pada contoh : 9 menjadi 09
        return i;
    }
    </script>
</body>

</html>