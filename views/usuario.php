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
                                <h6 class="m-0 font-weight-bold text-primary">Usuario</h6>
                                <button id="btnAgregar" class="btn btn-success" onclick="mostrarForm(true)">
                                    <i class="fas fa-plus-circle"></i> Agregar
                                </button>
                            </div>

                            <div class="card-body" id="listadoRegistros">
                                <div class="table-responsive">
                                    <table id="tblListado" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Número Doc</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Login</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Datos dinámicos aquí -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nombre</th>
                                                <th>Número Doc</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Login</th>
                                                <th>Foto</th>
                                                <th>Estado</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="card-body" id="formularioRegistros">
                                <form name="formulario" id="formulario" method="POST" class="needs-validation" novalidate>
                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                        value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre">Nombre(*)</label>
                                            <input type="hidden" name="idusuario" id="idusuario">
                                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100"
                                                placeholder="Nombre" style="text-transform:capitalize" required>
                                            <div class="invalid-feedback">Por favor ingrese el nombre.</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tipo_documento">Tipo Documento(*)</label>
                                            <select class="form-control selectpicker" id="tipo_documento" name="tipo_documento"
                                                required data-live-search="true">
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="CEDULA">CEDULA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="num_documento">Número Documento(*)</label>
                                            <input type="number" class="form-control" id="num_documento" name="num_documento"
                                                maxlength="10" placeholder="Número documento" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="fecha_nac">Fecha de nacimiento:</label>
                                            <input type="date" class="form-control" name="fecha_nac" id="fecha_nac"
                                                placeholder="Fecha de nacimiento" autocomplete="off">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="direccion">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion"
                                                maxlength="120" placeholder="Dirección">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="telefono">Teléfono</label>
                                            <input type="number" class="form-control" id="telefono" name="telefono"
                                                maxlength="10" placeholder="Teléfono">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" maxlength="50"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cargo">Cargo</label>
                                            <input type="text" class="form-control" id="cargo" name="cargo" maxlength="20"
                                                placeholder="Cargo">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="login">Login(*)</label>
                                            <input type="text" class="form-control" id="login" name="login" maxlength="20"
                                                placeholder="Login" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="clave">Clave(*)</label>
                                            <input type="password" class="form-control" id="clave" name="clave" maxlength="20"
                                                placeholder="Clave" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="imagen">Imagen</label>
                                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                                            <input type="hidden" name="imagenactual" id="imagenactual">
                                            <img src="" width="150px" height="150px" id="imagenmuestra" alt="imagen">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="permisos">Permisos:</label><br>
                                        <ul id="permisos" style="list-style: none;"></ul>
                                    </div>
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                        Guardar</button>
                                    <button class="btn btn-danger" type="button" onclick="cancelarForm()"><i
                                            class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

    <script src="scripts/usuario.js"></script>
    <?php
}

ob_end_flush();

?>