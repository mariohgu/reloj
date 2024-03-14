<?php
//Activamos el almacenamiento en el buffer
if (strlen(session_id()) < 1) {
    ob_start();
    session_start();
}

if (!isset($_SESSION["nombre"])) {
    header("Location: login.html");
} else {
    require 'header.php';

    if ($_SESSION['ventas'] == 1) {
        ?>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Registro</h6>
                            </div>
                            <!-- /.card-header -->
                            <!-- centro -->
                            <div class="card-body">
                                <div class="table-responsive" id="listadoregistros">
                                    <table id="tbllistado" class="table table-bordered table-striped">
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Personal</th>
                                            <th>Coordenadas</th>
                                            <th>Imagen</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Personal</th>
                                            <th>Coordenadas</th>
                                            <th>Imagen</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-body" id="formularioMostrar">
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label>Personal(*):</label>
                                                    <input type="hidden" name="idingreso" id="idingreso">
                                                    <select name="idpersonalMostrar" id="idpersonalMostrar"
                                                        class="form-control selectpicker" disabled></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label>Fecha(*):</label>
                                                    <input type="text" class="form-control" name="fecha_horaMostrar"
                                                        id="fecha_horaMostrar" disabled>
                                                </div>
                                            </div>

                                            <!-- Campos ocultos, si es necesario mostrarlos, remover el style="visibility:hidden" -->
                                            <div class="col-lg-5 col-md-5 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label>Coordenadas(*):</label>
                                                    <input type="text" class="form-control" name="latitudMostrar"
                                                        id="coordenadasMostrar" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="imagen">Evidencia</label>
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                                <img src="" width="300px" height="300px" id="imagenmostrar" alt="imagen">
                                            </div>


                                        </div>


                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fas fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </form>
                                </div>

                                <!--Fin centro -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
            </section> <!-- /.content -->

        </div> <!-- /.content-wrapper -->
        <!--Fin-Contenido-->

        <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/registro.js"></script>
    <?php
}
ob_end_flush();
?>