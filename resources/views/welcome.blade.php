<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <title>MCC Vitality Tracker</title>
    <link href="{{asset ('img/logo.png')}}" rel="icon">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 text-center">
                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="errorModalLabel"><i class="fa-solid fa-circle-exclamation"></i> Oppss</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="col-12">
                                    <h4><b>{{ session('error') }}</b></h4>
                                </div>
                            </div>
                            <div class="modal-footer bg-danger">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-6 offset-xl-3 my-5">
                <div class="card bg-dark bg-opacity-25">
                    <div class="card-body m-xl-4">
                        <div class="text-center">
                            <img src="{{ asset('img/logo.png') }}"class="logo">
                            <h2 class="fw-bold text-danger">MABALACAT CITY COLLEGE</h2>
                        </div>
                        <hr>
                        <p class="text-muted">Scan the QR Code in your ID to Login:</p>
                        <div class="w-100 border" id="qr-box">
                            <video id="scanner" height="100%" width="100%"></video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });

            scanner.addListener('scan', function (content) {
                window.location.href = '/login/' + content;
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
            @if(session('error'))
                $('#errorModal').modal('show');
                // Close modal after 3 seconds
                setTimeout(function() {
                    $('#errorModal').modal('hide');
                }, 3000);
            @endif
        });
    </script>
</body>
</html>
