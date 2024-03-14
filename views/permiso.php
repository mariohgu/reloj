<?php
//Activamos el alamacenamiento en el buffer
if (strlen(session_id()) < 1) {
    ob_start();
    session_start();
}

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {

    require 'header.php';

    if ($_SESSION["acceso"] == 1) {
        ?>
        <div class="content-wrapper">
            <section class="content-header">

            </section>
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Permiso</h6>
                                <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)">
                                    <i class="fas fa-plus-circle"></i> Agregar
                                </button>
                            </div>

                            <div class="card-body" id="listadoRegistros">
                                <div class="table-responsive">
                                    <table id="tblListado" class="table table-bordered table-striped">
                                        <thead>
                                            <th>Nombre</th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <th>Nombre</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>

    <script src="scripts/permiso.js"></script>
    <?php
}

ob_end_flush();

?>