<?php

date_default_timezone_set('America/Lima');

// Implementa encabezados de seguridad HTTP
// header("X-Content-Type-Options: nosniff");
// header("X-Frame-Options: SAMEORIGIN");

// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://apis.google.com https://cdn.datatables.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://fonts.gstatic.com https://fonts.gstatic.com https://cdn.jsdelivr.net/npm/sweetalert2@11 scripts/; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://cdn.datatables.net https://cdnjs.cloudflare.com https://fonts.googleapis.com http://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css data:; font-src 'self' data: https://fonts.gstatic.com; ");

// header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
// header("X-XSS-Protection: 1; mode=block");
// header("Referrer-Policy: no-referrer-when-downgrade");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Marcacion de personal</title>
    <link rel="icon" href="https://valverdeherrera.com/wp-content/uploads/2020/09/LOGO_VALVERDE_HERRERA-150x150.ico"
        sizes="32x32">

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">
                                            Marcacion de registro
                                        </h1>
                                    </div>
                                    <form id="formulario" method="post">
                                        <div class="form-group has-feedback">
                                            <label>Personal(*):</label>
                                            <select name="idpersona" id="idpersona" class="form-control"
                                                data-live-search="true"></select>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label>Ubicacion(*):</label>
                                            <input type="text" class="form-control" name="latitud" id="latitud" required
                                                blocked readonly>
                                            <input type="text" class="form-control" name="longitud" id="longitud"
                                                requiered readonly>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label>Evidencia(*):</label>
                                            <!-- <input type="file" accept="image/*" capture="camera" id="foto" name="foto"> -->
                                            <video id="video" width="350" height="300" playsinline autoplay></video>
                                            <canvas id="foto" width="300" height="300" hidden>
                                                <img src="" class="photo" alt="photo" id="imagen" name="imagen" />
                                            </canvas>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <div id="mensaje" class="alert alert-danger"></div>
                                                <button class="btn btn-primary btn-user btn-block" type="submit">
                                                    Registrar
                                                </button>
                                            </div>
                                        </div>
                                        <hr />
                                    </form>
                                    <hr />
                                    <div class="text-center">
                                        <a class="small" href="login.html">Ingreso</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../assets/js/notificaciones.js"></script> -->

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="scripts/marcacion.js"></script>
</body>

</html>