<?php
    session_start();

    // Carga la biblioteca criptográfica
    //require_once(join_paths(LIBRARIES_PATH, 'AES', 'AES.php'));

    function join_paths() {
        // Recopila todos los parámetros de entrada
        $paths = func_get_args();

        // Recorre los parámetros recopilados
        foreach ($paths as $key => $path) {
            // Verifica si el parámetro es una cadena
            if (is_string($path)) {
                // Normaliza la cadena a una cadena de ruta
                $path = rtrim(preg_replace('/(\s*[\\\\\/]\s*)+/', DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);

                // Verifica que la cadena normalizada no sea vacía
                if (!empty($path)) {
                    // Remplaza al parámetro con el valor normalizado
                    $paths[$key] = $path;
                }
                else {
                    // Si el valor normalizado del parámetro es vacío, lo ignora
                    unset($paths[$key]);
                }
            }
            else {
                // Si el parámetro no es una cadena, lo ignora
                unset($paths[$key]);
            }
        }

        // Devuelve la ruta construida
        return implode(DIRECTORY_SEPARATOR, $paths);
    }

    function absolute_url($postfix = '') {
        if (is_string($postfix)) {
            // Colección de nombres de páginas raiz comunes        
            $default_pages = array(
                'index.php', 'index.htm', 'index.html', 'index.phtml', 
                'default.php', 'default.htm', 'default.html', 'default.phtml'
            );

            // Devuelve la URL absouluta para el postfijo de entrada
            return BASE_URL . (in_array(basename($postfix), $default_pages) ? dirname($postfix) : ($postfix == '' ? '' : '/' . $postfix));
        }
    }

    function exists_result_message() {
        return isset($_SESSION['RESULT_MESSAGE']);
    }

    function set_result_message($message) {
        $_SESSION['RESULT_MESSAGE'] = $message;
    }

    function get_result_message() {
        return $_SESSION['RESULT_MESSAGE'];
    }

    function unset_result_message() {
        unset($_SESSION['RESULT_MESSAGE']);
    }

    function hex_to_rgba($color, $opacity = FALSE) {
        $default = 'rgb(55, 55, 55)';

        // Devuelve el color por defecto si ninguno es provisto
        if (empty($color)) {
            return $default;
        }
        else {
            // Serializa el color si está prefijado con un "#"
            $color = ltrim($color, '#');

            // Verifica si el color cuenta con 6 o 3 caracteres y obtiene sus valores
            if (strlen($color) == 6) {
                $hex = str_split($color, 2);
            }
            elseif (strlen($color) == 3) {
                $hex = str_split($color);
            }
            else {
                return $default;
            }

            // Converte cada uno de los componentes hexadecimales a decimales
            $dec = array_map('hexdec', $hex);

            // Verifica si se estableció un valor para la opacidad
            if ($opacity !== FALSE and is_numeric($opacity)) {
                // Valida el valor establecido
                $opacity = abs($opacity);

                if ($opacity > 1) {
                    $opacity = 1.0;
                }

                // Agrega el componente de opacidad al color
                array_push($dec, $opacity);

                // Construye la cadena que representa al color con formato RGBA
                $output = 'rgba(' . implode(', ', $dec) . ')';
            }
            else {
                // Construye la cadena que representa al color con formato RGB
                $output = 'rgb(' . implode(', ', $dec) . ')';
            }

            // Devuelve la cadena formateada
            return $output;
        }
    }

    function formatted_filesize ($filename) {
        if (file_exists($filename)) {
            $units = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB');
            $size = filesize($filename);
            for ($i = 0; $size >= 1024 and $i < count($units) - 1; $size /= 1024, $i++);
            return preg_replace('/\.?0*$/', '', number_format($size, 2)) . ' ' . $units[$i] . (($size != 1 and $i == 0) ? 's' : '');
        }
        else {
            return '0 bytes';
        }
    }

    function formatted_datetime ($str_datetime, $verbose = FALSE) {
        // Arreglos de días y meses localizados
        $days = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $months = array(
            1 => 'Enero', 
            2 => 'Febrero', 
            3 => 'Marzo', 
            4 => 'Abril', 
            5 => 'Mayo', 
            6 => 'Junio', 
            7 => 'Julio', 
            8 => 'Agosto', 
            9 => 'Septiembre', 
            10 => 'Octubre', 
            11 => 'Noviembre', 
            12 => 'Diciembre'
        );

        // Crea instancias de ayer y hoy
        $today = new DateTime();
        $yesterday = new DateTime('-1 day');
        $datetime = new DateTime($str_datetime);

        // Comprueba si se usará el formato largo
        if ($verbose) {
            // Compara la fecha de entrada con las de ayer y hoy
            if ($datetime->format('Y-m-d') == $today->format('Y-m-d')) {
                return 'Hoy a la' . (intval($datetime->format('g')) == 1 ? ' ' : 's ') . $datetime->format('g:i a');
            }
            elseif ($datetime->format('Y-m-d') == $yesterday->format('Y-m-d')) {
                return 'Ayer a la' . (intval($datetime->format('g')) == 1 ? ' ' : 's ') . $datetime->format('g:i a');
            }
            else {
                return $days[intval($datetime->format('w'))] . ', ' . $datetime->format('j') . ' de ' . $months[intval($datetime->format('n'))] . ' de ' . $datetime->format('Y') . ' a la' . (intval($datetime->format('g')) == 1 ? ' ' : 's ') . $datetime->format('g:i a');
            }
        }
        else {
            return $datetime->format('d/m/Y');
        }
    }

    function transform_plain_text($text) {
        // Particiona el texto
        $slices = explode(PHP_EOL, $text);

        // Convierte a cada partición en parrafo
        foreach ($slices as $key => $value) {
            // Comprueba si el contenido de la partición no está en blanco
            if (trim($value)) {
                // Transforma la partición en un parrafo HTML
                $slices[$key] = '<p>' . $value . '</p>';
            }
            else {
                unset($slices[$key]);
            }
        }

        // Devuelve el texto transformado
        return implode('', $slices);
    }

    function prettyPrint ($json) {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen($json);

        for ($i = 0; $i < $json_length; $i++) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if ($ends_line_level !== NULL) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ($in_escape) {
                $in_escape = false;
            }
            else if ($char === '"') {
                $in_quotes = !$in_quotes;
            }
            else if (!$in_quotes) {
                switch ($char) {
                    case '}': case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;

                    case '{': case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ": case "\t": case "\n": case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            }
            else if ($char === '\\') {
                $in_escape = true;
            }
            if ($new_line_level !== NULL) {
                $result .= "\n" . str_repeat( "\t", $new_line_level);
            }
            $result .= $char . $post;
        }

        return $result;
    }

    // Función de contigencia para versiones de PHP anteriores a la 5.4.0
    if (!function_exists('http_response_code'))
    {
        function http_response_code ($newcode = NULL)
        {
            static $code = 200;

            if ($newcode !== NULL)
            {
                header('X-PHP-Response-Code: ' . $newcode, true, $newcode);
                if (!headers_sent())
                    $code = $newcode;
            }

            return $code;
        }
    }
?>