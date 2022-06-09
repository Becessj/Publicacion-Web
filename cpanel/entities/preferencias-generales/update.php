<?php
    // Inicializa los recursos del sistema
    require_once('system.php');

    // Carga las bibliotecas necesarias
    require_once(join_paths(LIBRARIES_PATH, 'WideImage', 'WideImage.php'));

    // Comprueba si se ha iniciado swsión
    if (sesion_activa()) {
        // Comprueba si se cuentan con los parámetros requeridos
        if (isset($_POST['municipalidades'])) {
            // Verifica si se ha iniciado sesión como administrador
            if (true) {
                // Recupera los parámetros
                $municipalidades = $_POST['municipalidades'];
                // Cambia la escuela profesional
                $result = cambiarmunicipalidad($municipalidades);

                // Comprueba si la actualización fue exitosa
                if ($result) {
                    // Construye la ruta de la imagen de logotipo de la escuela profesional
                    $file = join_paths(STORAGE_PATH, 'entidad', 'logo.png');

                    // Comprueba si se cargó una imagen de logotipo
                    if (is_uploaded_file($_FILES['logo']['tmp_name']) && $_FILES['logo']['size'] <= UPLOAD_MAX_FILESIZE && $_FILES['logo']['type'] == 'image/png' && is_writable(join_paths(STORAGE_PATH, 'entidad'))) {
                        // Prepara la imagen de fondo
                        WideImage::loadFromUpload('logo')->resizeDown(200, 200, 'outside')->crop('center', 'center', 200, 200)->saveToFile($file);

                        // Elimina el archivo temporal
                        unlink($_FILES['logo']['tmp_name']);
                    }
                    elseif (!isset($_FILES['logo'])) {
                        // Elimina la imagen personalizada
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    
                    // Construye la ruta de la imagen de logotipo de la escuela profesional
                    $file = join_paths(STORAGE_PATH, 'entidad', 'header-logo.png');

                    // Comprueba si se cargó una imagen de logotipo
                    if (is_uploaded_file($_FILES['header-logo']['tmp_name']) && $_FILES['header-logo']['size'] <= UPLOAD_MAX_FILESIZE && $_FILES['header-logo']['type'] == 'image/png' && is_writable(join_paths(STORAGE_PATH, 'entidad'))) {
                        // Prepara la imagen de fondo
                        WideImage::loadFromUpload('header-logo')->resizeDown(360, 150, 'outside')->crop('center', 'center', 360, 150)->saveToFile($file);

                        // Elimina el archivo temporal
                        unlink($_FILES['header-logo']['tmp_name']);
                    }
                    elseif (!isset($_FILES['header-logo'])) {
                        // Elimina la imagen personalizada
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }

                    // Se guardaron los cambios
                    set_result_message(EDIT_SUCCESS);
                }
                else {
                    // No se guardaron los cambios
                    set_result_message(EDIT_FAILED);
                }
            }
            
        }
    }

    // Redirecciona al inicio
    header('Location: ../..');
?>