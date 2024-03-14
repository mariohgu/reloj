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
                                <h6 class="m-0 font-weight-bold text-primary">Servicio</h6>
                                <button class="btn btn-success" id="btnagregar" onclick="mostrarForm(true)">
                                    <i class="fas fa-plus-circle"></i> Agregar
                                </button>
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
                                            <th>Latitud</th>
                                            <th>Imagen</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <th>Opciones</th>
                                            <th>Fecha</th>
                                            <th>Personal</th>
                                            <th>Latitud</th>
                                            <th>Imagen</th>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-body" id="formularioMostrar">
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label>Cliente(*):</label>
                                                    <select name="idclienteMostrar" id="idclienteMostrar"
                                                        class="form-control selectpicker" disabled></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label>Fecha(*):</label>
                                                    <input type="date" class="form-control" name="fecha_horaMostrar"
                                                        id="fecha_horaMostrar" disabled>
                                                </div>
                                            </div>

                                            <!-- Campos ocultos, si es necesario mostrarlos, remover el style="visibility:hidden" -->
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Tipo Comprobante(*):</label>
                                                    <select name="tipo_comprobanteMostrar" id="tipo_comprobanteMostrar"
                                                        class="form-control selectpicker" disabled>
                                                        <option value="">--Seleccione--</option>
                                                        <option value="Ticket">Ticket</option>
                                                        <option value="Factura">Factura</option>
                                                        <option value="Boleta">Boleta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Serie(*):</label>
                                                    <input type="text" class="form-control" name="serie_comprobanteMostrar"
                                                        id="serie_comprobanteMostrar" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Número(*):</label>
                                                    <input type="text" class="form-control" name="num_comprobanteMostrar"
                                                        id="num_comprobanteMostrar" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Impuesto(*):</label>
                                                    <input type="text" class="form-control" name="impuestoMostrar"
                                                        id="impuestoMostrar" disabled>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label>Medio de Pago(*):</label>
                                                    <select id="idmedioMostrar" name="idmedioMostrar"
                                                        class="form-control selectpicker" disabled></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <table id="detallesMostrar" class="table table-bordered table-hover">
                                                    <thead class="thead-light">
                                                        <th>Servicio</th>
                                                        <th>Personal</th>
                                                        <th>Cantidad</th>
                                                        <th>Concepto</th>
                                                        <th>Precio</th>
                                                        <th>Subtotal</th>
                                                        <th>Actualizar</th>
                                                    </thead>
                                                    <tfoot>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tfoot>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fas fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body" id="formularioregistros">
                                    <form name="formulario" id="formulario" method="POST">
                                        <input type="hidden" name="csrf_token" id="csrf_token"
                                            value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label>Cliente(*):</label>
                                                    <input type="hidden" name="idservicio" id="idservicio">
                                                    <select id="idcliente" name="idcliente" class="form-control selectpicker"
                                                        data-live-search="true" required></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label>Fecha(*):</label>
                                                    <input type="date" class="form-control" name="fecha_hora" id="fecha_hora"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Tipo Comprobante(*):</label>
                                                    <select name="tipo_comprobante" id="tipo_comprobante"
                                                        class="form-control selectpicker">
                                                        <option value="Ticket" selected>Ticket</option>
                                                        <option value="Factura">Factura</option>
                                                        <option value="Boleta">Boleta</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Serie:</label>
                                                    <input type="text" class="form-control" name="serie_comprobante"
                                                        id="serie_comprobante" maxlength="7" placeholder="Serie"
                                                        autocomplete="off" readonly="readonly">

                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Número:</label>
                                                    <input type="text" class="form-control" name="num_comprobante"
                                                        id="num_comprobante" maxlength="10" placeholder="Número">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Impuesto:</label>
                                                    <input type="text" class="form-control" name="impuesto" id="impuesto">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group">
                                                    <label>Medio de Pago(*):</label>
                                                    <select id="idmedio" name="idmedio" class="form-control selectpicker"
                                                        data-live-search="true" required></select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <a data-toggle="modal" href="#myModal">
                                                        <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span
                                                                class="fas fa-plus"></span> Agregar Servicios</button>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                                <div class="table-responsive">
                                                    <table id="detalles" class="table table-bordered table-hover">
                                                        <thead class="thead-light">
                                                            <th>Opciones</th>
                                                            <th>Servicio</th>
                                                            <th>Personal</th>
                                                            <th>Concepto</th>
                                                            <th>Precio</th>
                                                            <th>Descuento</th>
                                                            <th>Subtotal</th>
                                                            <th>Actualizar</th>
                                                        </thead>
                                                        <tfoot>
                                                            <th>TOTAL</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>
                                                                <h4 id="total">S/. 0.00</h4><input type="hidden"
                                                                    name="total_servicio" id="total_servicio">
                                                            </th>
                                                        </tfoot>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                        class="fas fa-save"></i> Guardar</button>

                                                <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()"
                                                    type="button"><i class="fas fa-arrow-circle-left"></i> Cancelar</button>
                                            </div>
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

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document"> <!-- Ajustado para Bootstrap 4 -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Seleccione un Artículo</h5>
                        <!-- H5 para un título más acorde con Bootstrap 4 -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <!-- Actualizado para Bootstrap 4 -->
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive"> <!-- Añadido para mejorar la responsividad -->
                            <table id="tblitems" class="table table-bordered table-hover">
                                <!-- Actualizado a clases de Bootstrap 4 -->
                                <thead class="thead-light"> <!-- Clase para encabezados de tabla en Bootstrap 4 -->
                                    <tr> <!-- Añadido para correcta estructuración -->
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr> <!-- Añadido para correcta estructuración -->
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <!-- Actualizado para Bootstrap 4 -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin modal -->

        <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script type="text/javascript" src="scripts/servicio.js"></script>
    <?php
}
ob_end_flush();
?>