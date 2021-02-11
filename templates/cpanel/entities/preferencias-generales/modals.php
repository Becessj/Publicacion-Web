<?php
    // Comprueba si el archivo fue cargado directamente desde el navegador
    if ($_SERVER['SCRIPT_FILENAME'] === __FILE__) {
        // Error al cargar el archivo
        echo utf8_decode('No tiene permitido ver el contenido de este documento.');
        exit;
    }
?>

            <!-- Cuadro de diálogo Entidad -->
            <div class="modal fade" id="entidad" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Entidad</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="entities/preferencias-generales/update.php" id="form-entidad" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="facultad" class="control-label">Nombre Municipalidad</label>
                                    <?php
                                        // Lista de facultades
                                        HtmlGen::select(array(
                                            'class' => 'selectpicker form-control',
                                            'data-live-search' => 'true',
                                            'id' => 'municipalidades',
                                            'title' => 'Seleccione una municipalidad',
                                            'required' => ''
                                        ), function () use ($municipalidades) {
                                            // Corrige el nivel de indentación
                                            HtmlGen::set_indent_level(10);

                                            // Contenido de la lista
                                            foreach ($municipalidades as $municipalidad) {
                                                HtmlGen::option(array_merge(array('value' => $municipalidad['id']), ($municipalidad['id'] == $municipalidad_seleccionada) ? array('selected' => '') : array()), $municipalidad['municipalidad']);
                                            }
                                        });

                                        // Restablece el nivel de indentación
                                        HtmlGen::set_indent_level(0);
                                    ?>
                                    <p class="help-block with-errors"></p>
                                </div>


                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="self.close()">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-submit" data-target="#form-entidad">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            


           
            <div class="modal fade" id="apariencia" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Apariencia</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="entities/preferencias-generales/update.php" id="form-apariencia" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="tema" class="control-label">Color de énfasis</label>
                                    <input type="hidden" name="tema" value="<?php echo $preferencias_generales['Tema']; ?>" />
                                    <?php
                                        // Paleta de colores
                                        HtmlGen::div(array('class' => 'row'), function () use ($temas, $preferencias_generales) {
                                            // Corrige el niovel de indentación
                                            HtmlGen::set_indent_level(10);

                                            foreach ($temas as $tema) {
                                                HtmlGen::div(array('class' => 'col-xs-2'), function () use ($tema, $preferencias_generales) {
                                                    HtmlGen::a('', '#', array(
                                                        'class' => 'colorpicker' . ($tema['Id'] == $configuracion['Tema'] ? ' checked' : ''),
                                                        'style' => 'background: linear-gradient(135deg, #' . $tema['ColorPrincipal'] . ' 50%, #' . $tema['ColorAlternativo'] . ' 50%);',
                                                        'data-id' => $tema['Id']
                                                    ));
                                                });
                                            }
                                        });

                                        // Restablece el nivel de indentación
                                        HtmlGen::set_indent_level(0);
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label for="imagen-fondo" class="control-label">Imagen de fondo</label>
                                    <div class="file-input-group">
                                        <input type="file" class="hidden invisible" name="imagen-fondo" accept="image/jpeg, image/png, image/bmp" />
                                        <?php
                                            // Construye la ruta de la imagen de fondo
                                            $file = join_paths(STORAGE_PATH, 'entidad', 'background.jpg');
                                        ?>

                                        <button type="button" class="btn btn-default btn-file">Seleccionar una imagen</button>
                                    </div>
                                    <p class="help-block"></p>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" data-reset-background <?php echo file_exists($file) ? '' : 'disabled '; ?>/> Restablecer el fondo predeterminado
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="imagen-fondo-alt" class="control-label">Imagen de fondo alternativa</label>
                                    <div class="file-input-group">
                                        <input type="file" class="hidden invisible" name="imagen-fondo-alt" accept="image/jpeg, image/png, image/bmp" />
                                        <?php
                                            // Construye la ruta de la imagen de fondo
                                            $file = join_paths(STORAGE_PATH, 'entidad', 'background-alt.jpg');
                                        ?>

                                        <button type="button" class="btn btn-default btn-file">Seleccionar una imagen</button>
                                    </div>
                                    <p class="help-block"></p>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" data-reset-background-alt <?php echo file_exists($file) ? '' : 'disabled '; ?>/> Restablecer el fondo alternativo predeterminado
                                    </label>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" onclick="close();">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-submit" data-target="#form-apariencia">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
