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

    if ($_SESSION["ventas"] == 1) {
        ?>
        <div class="content-wrapper">
            <section class="content-header">
                <!-- Aquí puedes poner migas de pan o encabezado de la sección si lo necesitas -->
            </section>
            <section class="content container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4"> <!-- Agregado shadow mb-4 para sombra y margen -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Personal</h6>
                                <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)">
                                    <i class="fas fa-plus-circle"></i> Agregar
                                </button>
                            </div>

                            <div class="card-body" id="listadoRegistros">
                                <div class="table-responsive">
                                    <table id="tblListado" class="table table-bordered table-striped">
                                        <thead>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <th>Opciones</th>
                                            <th>Nombre</th>
                                            <th>Documento</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body" id="formularioRegistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                        value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label>Nombre:</label>
                                            <input type="hidden" name="idpersona" id="idpersona">
                                            <input type="hidden" name="tipo_persona" id="tipo_persona" value="Personal">
                                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100"
                                                placeholder="Nombre del cliente" autocomplete="off"
                                                style="text-transform:capitalize" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Tipo Documento:</label>
                                            <select class="form-control selectpicker" id="tipo_documento" name="tipo_documento"
                                                required data-live-search="true">
                                                <option value="">--Seleccione--</option>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="CEDULA">CEDULA</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="num_documento">Número Documento:</label>
                                            <input type="text" class="form-control" name="num_documento" id="num_documento"
                                                maxlength="20" placeholder="Documento" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fecha_nac">Fecha de nacimiento:</label>
                                            <input type="date" class="form-control" name="fecha_nac" id="fecha_nac"
                                                placeholder="Fecha de nacimiento" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Código interno:</label>
                                            <input type="number" class="form-control" name="codigo_interno" id="codigo_interno"
                                                placeholder="Código Interno" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Dirección:</label>
                                            <input type="text" class="form-control" name="direccion" id="direccion"
                                                maxlength="70" placeholder="Dirección" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Teléfono:</label>
                                            <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20"
                                                placeholder="Teléfono" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" name="email" id="email" maxlength="50"
                                                placeholder="Email" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fas fa-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarForm()" type="button"><i
                                                    class="fas fa-times-circle"></i> Cancelar</button>
                                        </div>
                                    </div>
                                </form>
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

    <script src="scripts/personal.js"></script>
    <?php
}

ob_end_flush();
?>