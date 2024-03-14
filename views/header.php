<?php

date_default_timezone_set('America/Lima');

//Esto es para php 8
$formatter = new IntlDateFormatter(
    'es_ES',
    IntlDateFormatter::FULL,
    IntlDateFormatter::SHORT,
    'America/Lima', // O la zona horaria que necesites
    IntlDateFormatter::GREGORIAN,
    "EEEE, d 'de' MMMM 'de' Y, HH:mm" // Patrón personalizado
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Marcacion de Personal - VH</title>

    <link rel="stylesheet" href="../assets/Ionicons/css/ionicons.min.css">

    <!--DATATABLES-->
    <link rel="stylesheet" href="../assets/css/jquery.datatables.min.css">
    <link rel="stylesheet" href="../assets/css/buttons.datatables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.css">

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;1,300;1,400&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css">

    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>


    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="../assets/css/sb-admin-2.min.css" />

    <!-- Incluir CSS de FullCalendar -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.5/main.min.css' rel='stylesheet' />

    <!-- Datetimepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <link rel="icon" href="../assets/img/favivh.ico" type="image/x-icon" sizes="32x32">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="reservas.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Marcacion - VH <sup>1.0</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <?php
            if ($_SESSION['ventas'] == 1) {
                echo '
            <li class="nav-item active">
                <a class="nav-link" href="registro.php">
                    <i class="fa fa-clock    "></i>
                    <span>Registro de Marcaciones</span></a>
            </li>

            ';
            }
            ?>


            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">GESTION</div>


            <!-- Gestion de Usuarios -->
            <?php
            if ($_SESSION['acceso'] == 1) {
                echo '
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fa fa-user"></i>
                    <span>Gestion de Usuarios</span>
                </a>
                <div id="collapseUsuarios" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="personal.php">Gestionar Personal</a>
                        <a class="collapse-item" href="usuario.php">Gestionar Usuario</a>
                        <a class="collapse-item" href="permiso.php">Ver Permiso</a>
                    </div>
                </div>
            </li>
            ';
            }
            ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            <?php

            ?>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
                    style="height: 40px;">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">


                            <div class="input-group-append">
                                <?php
                                echo $formatter->format(new DateTime());
                                ?>
                            </div>
                        </div>
                    </form>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">

                        </li>



                        <!-- Nav Item - Alerts -->

                        <!-- Alerta de Clientes con mas de 4 visitas -->

                        <li class="nav-item dropdown no-arrow mx-1">

                        </li>

                        <!-- Alerta de Cumpleaños -->
                        <li class="nav-item dropdown no-arrow mx-1">

                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $_SESSION['nombre']; ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="../Files/Usuarios/<?php echo $_SESSION['imagen']; ?>" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../ajax/usuario.php?op=salir" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Desconectarse
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->