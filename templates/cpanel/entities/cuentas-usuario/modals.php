<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }
?>

            <!-- Cuadro de diálogo Crear cuenta -->
            <div class="modal fade" id="crear-cuenta" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Crear cuenta</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="entities/cuentas-usuario/create.php" id="form-crear-cuenta">
                                <div class="form-group">
                                    <label for="nombre-usuario" class="control-label">Dirección de correo electrónico</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nombre-usuario" maxlength="240" required />
                                        <div class="input-group-addon">@unsaac.edu.pe</div>
                                    </div>
                                    <p class="help-block with-errors"></p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-submit" data-target="#form-crear-cuenta">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cuadro de diálogo Restablecer contraseña -->
            <div class="modal fade" id="restablecer-contrasena" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Restablecer contraseña</h4>
                        </div>
                        <div class="modal-body">
                            <p>¿Desea restablecer la contraseña de esta cuenta de usuario?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-ok">Restablecer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cuadro de diálogo Eliminar cuenta -->
            <div class="modal fade" id="eliminar-cuenta" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar cuenta</h4>
                        </div>
                        <div class="modal-body">
                            <p>¿Desea eliminar esta cuenta de usuario?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-ok">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="eliminar-cuentas" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Eliminar cuentas de usuario</h4>
                        </div>
                        <div class="modal-body">
                            <p>¿Está seguro de que desea eliminar las cuentas de usuario seleccionadas?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-ok">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
