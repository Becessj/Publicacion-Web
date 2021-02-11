/// <reference path="jquery-2.1.0-vsdoc.js" />

$(window).load(function () {
    // Desvanece la pantalla de carga
    $('.loader-wrapper').fadeOut('slow', function () {
        $(this).remove();
    });
});

$(document).ready(function () {
    if (typeof (tinyMCE) != "undefined") {
        //Inicializa los editores de texto enriquecido
        tinymce.init({
            selector: '.tinymce',
            height: 320,
            plugins: 'print preview searchreplace autolink directionality codemirror visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools colorpicker textpattern help',
            toolbar1: 'undo redo | bold italic strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | formatselect removeformat | numlist bullist outdent indent | image link | code | searchreplace',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ],
            mobile: { theme: 'mobile' },
            language: 'es_MX',
            image_advtab: true,
            codemirror: { indentOnInit: true }
        });

        // Previene que el cuadro de diálogo de Bootstrap bloquee el foco
        $(document).on('focusin', function (e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });
    }

    // Renderiza los cuadros de información de herramienta
    $('[data-tooltip]').tooltip({
        trigger: 'hover'
    });

    // Captura la interacción con una casilla de auto-marcado
    $('[data-toggle="checkall"]').change(function () {
        // Cambia el estado de las casillas vinculadas
        $('[data-check-group="' + $(this).data('target') + '"]').prop('checked', $(this).prop('checked')).change();
    });

    // Captura la interacción con casillas vinculadas a una de auto-marcado
    $('[data-check-group]').change(function () {
        // Recupera la casilla de auto-marcado vinculada
        var $checker = $('[data-toggle="checkall"]').filter('[data-target="' + $(this).data('check-group') + '"]');
        // Recupera el grupo de casillas vinculas
        var $group = $('[data-check-group="' + $(this).data('check-group') + '"]');

        // Comprueba el estado actual de la casilla
        if ($(this).prop('checked')) {
            // Compara el número de casillas marcadas con el total
            if ($group.filter(':checked').length == $group.length) {
                // Si todas las casillas del grupo están marcadas, marca la casilla de auto-marcado
                $checker.prop('checked', true);
            }

            // Muestra las opciones disponibles para casillas marcadas
            $('[data-enabler="' + $(this).data('check-group') + '"]').removeClass('hidden');
            // Resalta la fila de la casilla seleccionada
            $(this).closest('tr').addClass('warning');
        }
        else {
            // Comrpueba si la casilla de auto-marcado aún está marcada
            if ($checker.prop('checked')) {
                // Si sigue marcada, la desmarca
                $checker.prop('checked', false);
            }

            // Comprueba si no quedan casillas marcadas
            if ($group.filter(':checked').length == 0) {
                // Si no hay casillas marcadas, oculta las opciones disponibles para casillas marcadas
                $('[data-enabler="' + $(this).data('check-group') + '"]').addClass('hidden');
            }

            // Quita el resalte de la fila de la casilla seleccionada
            $(this).closest('tr').removeClass('warning');
        }
    });

    // Captura el evento desenadenado al hacer clic sobre el botón que se comporta como entrada de archivos
    $('.btn-file').click(function () {
        // Captura el botón
        var $file = $(this);
        // Dispara un clic sobre el campo de archivo correspondiente
        $file.closest('.file-input-group').find('[type="file"]').click();
    });

    // Captura el evento desencadenado al hacer clic sobre un botón que se comporta como un botón de envío
    $('.btn-submit').click(function () {
        // Captura el botón de envío
        $submit = $(this);
        // Ejecuta el envío
        $($submit.data('target')).submit();
    });

    // Captura el evento desencadenado al enviar la solicitud para iniciar sesión
    $('.g-recaptcha').closest('form').submit(function (e) {
        if (grecaptcha.getResponse() == '') {
            // Interrumpe la acción por defecto
            e.preventDefault();

            // Muestra un mensaje de error
            $('#modal-captcha').modal('show');
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Solicitar restablecimiento de contraseña
    $('#solicitar-restablemiento-contrasena').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-solicitar-restablemiento-contrasena');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Solicitar restablecimento de contraseña
    $('#form-solicitar-restablemiento-contrasena').submit(function (e) {
        // Captura los campos
        var $nombreUsuario = $(this).find('[name="nombre-usuario"]');

        if ($nombreUsuario[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Solicitar restablecimiento de contraseña
    $('#solicitar-restablemiento-contrasena').on('hidden.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-solicitar-restablemiento-contrasena');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción restablecer contraseña
    $('[data-target="#restablecer-contrasena"]').click(function () {
        $('#restablecer-contrasena').find('.btn-ok').attr('data-href', 'entities/cuentas-usuario/reset.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Restablecer contraseña
    $('#restablecer-contrasena').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#restablecer-contrasena').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Restablecer contraseña
    $('#restablecer-contrasena').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Crear cuenta
    $('#crear-cuenta').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-crear-cuenta');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Crear Cuenta
    $('#form-crear-cuenta').submit(function () {
        // Captura los campos
        var $nombreUsuario = $(this).find('[name="nombre-usuario"]');

        if ($nombreUsuario[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Crear cuenta
    $('#crear-cuenta').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-crear-cuenta');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar cuenta
    $('[data-target="#eliminar-cuenta"]').click(function () {
        $('#eliminar-cuenta').find('.btn-ok').attr('data-href', 'entities/cuentas-usuario/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar cuenta
    $('#eliminar-cuenta').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-cuenta').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar cuenta
    $('#eliminar-cuenta').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar cuentas
    $('#btn-eliminar-cuentas').click(function () {
        var select = [];

        $('[data-check-group="cuentas"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-cuentas').find('.btn-ok').attr('data-href', 'entities/cuentas-usuario/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar cuentas
    $('#eliminar-cuentas').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-cuentas').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar cuentas
    $('#eliminar-cuentas').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al cambiar de facultad
    $('#facultad').change(function () {
        // Captura al selector de escuelas profesionales
        var $select = $('#form-entidad').find('[name="escuela-profesional"]');
        // Limpia la lista de escuelas profesionales
        $select.empty();
        // Crea un objeto que se usara como elemento de la lista
        var $option

        // Recupera las escuelas profesionales correspondientes a la facultad seleccionada
        for (var i = 0; i < escuelasProfesionales.length; i++) {
            if (escuelasProfesionales[i]['Facultad'] == Number($(this).val())) {
                $option = $('<option />', { 'value': escuelasProfesionales[i]['Id'] });
                $option.text(escuelasProfesionales[i]['Nombre']);
                $select.append($option);
            }
        }

        // Actualiza la lista de escuelas profesionales
        $select.selectpicker('refresh');
    });

    // Captura el evento desencadenado al cambiar de escuela profesional
    $('#escuela-profesional').change(function () {
        // Captura el selector de escuelas profesionales
        var $select = $('#form-entidad').find('[name="escuela-profesional"]');

        $select.closest('.form-group').removeClass('has-error');
        $select.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
        $select.closest('.form-group').find('.help-block').empty();
    });

    // Captura el evento desencadenado al cambiar el campo Logotipo de escuela profesional
    $('#form-entidad').find('[name="logo"]').change(function () {
        // Captura el campo de selección de archivos
        var $logo = $(this);

        if ($logo[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $logo.closest('.form-group').removeClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $logo.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el event desencadenado al interactuar con la casilla para restablecer el logotipo predeterminado
    $('#form-entidad').find('[data-reset-logo]').change(function () {
        // Captura el campo de selección de archivos
        var $logo = $('#form-entidad').find('[name="logo"]');

        // Cambia el estado de disponibilidad del selector de archivos
        $logo.prop('disabled', $(this).prop('checked'));
        $logo.closest('.file-input-group').find('.btn-file').prop('disabled', $(this).prop('checked'));
    });

    // Captura el evento desencadenado al cambiar el campo Logotipo de cabecera
    $('#form-entidad').find('[name="header-logo"]').change(function () {
        // Captura el campo de selección de archivos
        var $headerLogo = $(this);

        if ($headerLogo[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($headerLogo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($headerLogo[0].files[0].size < 4194304) {
                    $headerLogo.closest('.form-group').removeClass('has-error');
                    $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $headerLogo.closest('.form-group').find('.help-block').text($headerLogo[0].files[0].name);
                }
                else {
                    $headerLogo.closest('.form-group').addClass('has-error');
                    $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $headerLogo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $headerLogo.closest('.form-group').addClass('has-error');
                $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $headerLogo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $headerLogo.closest('.form-group').removeClass('has-error');
            $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $headerLogo.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el event desencadenado al interactuar con la casilla para restablecer el logotipo de cabecera predeterminado
    $('#form-entidad').find('[data-reset-header-logo]').change(function () {
        // Captura el campo de selección de archivos
        var $headerLogo = $('#form-entidad').find('[name="header-logo"]');

        // Cambia el estado de disponibilidad del selector de archivos
        $headerLogo.prop('disabled', $(this).prop('checked'));
        $headerLogo.closest('.file-input-group').find('.btn-file').prop('disabled', $(this).prop('checked'));
    });

    // Captura el evento desencadenado al enviar los datos del formulario Entidad
    $('#form-entidad').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $escuelaProfesional = $('[name="escuela-profesional"]');
        var $logo = $(this).find('[name="logo"]');
        var $headerLogo = $(this).find('[name="header-logo"]');

        // Valida el campo Escuela Profesional
        if ($escuelaProfesional[0].checkValidity()) {
            // Quita el estado de error del campo
            $escuelaProfesional.closest('.form-group').removeClass('has-error');
            $escuelaProfesional.closest('.form-group').find('.help-block').empty();
        }
        else {
            $escuelaProfesional.closest('.form-group').addClass('has-error');
            $escuelaProfesional.closest('.form-group').find('.help-block').text('Seleccione una escuela profesional');
            isValid = false;
        }

        // Valida el campo Logotipo de escuela profesional
        if ($logo[0].files.length > 0 && !$(this).find('[data-reset-logo]').prop('checked')) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $logo.closest('.form-group').removeClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $logo.closest('.form-group').find('.help-block').empty();
        }

        // Valida el campo Logotipo de cabecera
        if ($headerLogo[0].files.length > 0 && !$(this).find('[data-reset-header-logo]').prop('checked')) {
            // Valida el tipo de archivo
            if ($headerLogo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($headerLogo[0].files[0].size < 4194304) {
                    $headerLogo.closest('.form-group').removeClass('has-error');
                    $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $headerLogo.closest('.form-group').find('.help-block').text($headerLogo[0].files[0].name);
                }
                else {
                    $headerLogo.closest('.form-group').addClass('has-error');
                    $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $headerLogo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $headerLogo.closest('.form-group').addClass('has-error');
                $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $headerLogo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $headerLogo.closest('.form-group').removeClass('has-error');
            $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $headerLogo.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Entidad
    $('#entidad').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-entidad');
        // Captura los campos
        var $selectFacultad = $('#facultad');
        var $selectEscuela = $form.find('[name="escuela-profesional"]');
        var $logo = $form.find('[name="logo"]');
        var $headerLogo = $form.find('[name="header-logo"]');
        // Restablece el formulario
        $form[0].reset();
        // Restablece la facultad
        $selectFacultad.selectpicker('val', $selectFacultad.find('[selected]').attr('value'));
        $selectFacultad.change();
        // Actualiza la lista de escuelas profesionales
        $selectEscuela.selectpicker('refresh');
        // Restablece la escuela profesional
        $selectEscuela.selectpicker('val', $selectEscuela.find('[value="' + preferenciasGenerales['EscuelaProfesional'] + '"]').attr('value'));
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece los selectores de archivos
        $logo.prop('disabled', false);
        $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default').prop('disabled', false);
        $headerLogo.prop('disabled', false);
        $headerLogo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default').prop('disabled', false);
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Seguimiento
    $('#seguimiento').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-seguimiento');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Seguimiento
    $('#form-seguimiento').submit(function () {
        var $codigoSeguimiento = $(this).find('[name="codigo-seguimiento"]');

        // Valida los campos
        if ($codigoSeguimiento[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desenadenado al cerrar el cuadro de diálogo Seguimiento
    $('#seguimiento').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-seguimiento');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al seleccionar un color
    $('.colorpicker').click(function (e) {
        // Interrumpe la acción por defecto
        e.preventDefault();
        // Desmarca cualquier otro  color
        $('.colorpicker').filter('.checked').removeClass('checked');
        // Cambia el valor del campo Tema
        $('[name="tema"]').val($(this).data('id'));
        // Marca el color seleccionado
        $(this).addClass('checked');
    });

    // Captura el evento desencadenado al cambiar el campo Imagen de fondo
    $('#form-apariencia').find('[name="imagen-fondo"]').change(function () {
        // Captura el campo de selección de archivos
        var $imagenFondo = $(this);

        if ($imagenFondo[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($imagenFondo[0].files[0].type == 'image/jpeg' || $imagenFondo[0].files[0].type == 'image/png' || $imagenFondo[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($imagenFondo[0].files[0].size < 4194304) {
                    $imagenFondo.closest('.form-group').removeClass('has-error');
                    $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $imagenFondo.closest('.form-group').find('.help-block').text($imagenFondo[0].files[0].name);
                }
                else {
                    $imagenFondo.closest('.form-group').addClass('has-error');
                    $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $imagenFondo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $imagenFondo.closest('.form-group').addClass('has-error');
                $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $imagenFondo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $imagenFondo.closest('.form-group').removeClass('has-error');
            $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $imagenFondo.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el event desencadenado al interactuar con la casilla para restablecer el fondo predeterminado
    $('#form-apariencia').find('[data-reset-background]').change(function () {
        // Captura el campo de selección de archivos
        var $background = $('#form-apariencia').find('[name="imagen-fondo"]');

        // Cambia el estado de disponibilidad del selector de archivos
        $background.prop('disabled', $(this).prop('checked'));
        $background.closest('.file-input-group').find('.btn-file').prop('disabled', $(this).prop('checked'));
    });

    // Captura el evento desencadenado al cambiar el campo Imagen de fondo alternativa
    $('#form-apariencia').find('[name="imagen-fondo-alt"]').change(function () {
        // Captura el campo de selección de archivos
        var $imagenFondoAlt = $(this);

        if ($imagenFondoAlt[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($imagenFondoAlt[0].files[0].type == 'image/jpeg' || $imagenFondoAlt[0].files[0].type == 'image/png' || $imagenFondoAlt[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($imagenFondoAlt[0].files[0].size < 4194304) {
                    $imagenFondoAlt.closest('.form-group').removeClass('has-error');
                    $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $imagenFondoAlt.closest('.form-group').find('.help-block').text($imagenFondoAlt[0].files[0].name);
                }
                else {
                    $imagenFondoAlt.closest('.form-group').addClass('has-error');
                    $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $imagenFondoAlt.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $imagenFondoAlt.closest('.form-group').addClass('has-error');
                $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $imagenFondoAlt.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $imagenFondoAlt.closest('.form-group').removeClass('has-error');
            $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $imagenFondoAlt.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el event desencadenado al interactuar con la casilla para restablecer el fondo predeterminado
    $('#form-apariencia').find('[data-reset-background-alt]').change(function () {
        // Captura el campo de selección de archivos
        var $backgroundAlt = $('#form-apariencia').find('[name="imagen-fondo-alt"]');

        // Cambia el estado de disponibilidad del selector de archivos
        $backgroundAlt.prop('disabled', $(this).prop('checked'));
        $backgroundAlt.closest('.file-input-group').find('.btn-file').prop('disabled', $(this).prop('checked'));
    });

    // Captura el evento desencadenado al enviar los datos del formulario Apariencia
    $('#form-apariencia').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $imagenFondo = $(this).find('[name="imagen-fondo"]');
        var $imagenFondoAlt = $(this).find('[name="imagen-fondo-alt"]');

        // Valida el campo Imagen de fondo
        if ($imagenFondo[0].files.length > 0 && !$(this).find('[data-reset-background]').prop('checked')) {
            // Valida el tipo de archivo
            if ($imagenFondo[0].files[0].type == 'image/jpeg' || $imagenFondo[0].files[0].type == 'image/png' || $imagenFondo[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($imagenFondo[0].files[0].size < 4194304) {
                    $imagenFondo.closest('.form-group').removeClass('has-error');
                    $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $imagenFondo.closest('.form-group').find('.help-block').text($imagenFondo[0].files[0].name);
                }
                else {
                    $imagenFondo.closest('.form-group').addClass('has-error');
                    $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $imagenFondo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $imagenFondo.closest('.form-group').addClass('has-error');
                $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $imagenFondo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $imagenFondo.closest('.form-group').removeClass('has-error');
            $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $imagenFondo.closest('.form-group').find('.help-block').empty();
        }

        // Valida el campo Imagen de fondo alternativa
        if ($imagenFondoAlt[0].files.length > 0 && !$(this).find('[data-reset-background-alt]').prop('checked')) {
            // Valida el tipo de archivo
            if ($imagenFondoAlt[0].files[0].type == 'image/jpeg' || $imagenFondoAlt[0].files[0].type == 'image/png' || $imagenFondoAlt[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($imagenFondoAlt[0].files[0].size < 4194304) {
                    $imagenFondoAlt.closest('.form-group').removeClass('has-error');
                    $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $imagenFondoAlt.closest('.form-group').find('.help-block').text($imagenFondoAlt[0].files[0].name);
                }
                else {
                    $imagenFondoAlt.closest('.form-group').addClass('has-error');
                    $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $imagenFondoAlt.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $imagenFondoAlt.closest('.form-group').addClass('has-error');
                $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $imagenFondoAlt.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $imagenFondoAlt.closest('.form-group').removeClass('has-error');
            $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $imagenFondoAlt.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Apariencia
    $('#apariencia').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-apariencia');
        // Captura los campos
        var $tema = $form.find('[name="tema"]');
        var $imagenFondo = $form.find('[name="imagen-fondo"]');
        var $imagenFondoAlt = $form.find('[name="imagen-fondo-alt"]');
        // Desmarca todos los colores
        $('.colorpicker').removeClass('checked');
        // Restablece el formulario
        $form[0].reset();
        $tema.val(preferenciasGenerales['Tema']);
        // Marca el color del tema
        $form.find('.colorpicker').filter('[data-id="' + $tema.val() + '"]').addClass('checked');
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece los selectores de archivos
        $imagenFondo.prop('disabled', false);
        $imagenFondo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default').prop('disabled', false);
        $imagenFondoAlt.prop('disabled', false);
        $imagenFondoAlt.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default').prop('disabled', false);
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Reseña histórica
    $('#resena-historica').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[0].setContent(resenaHistorica['Contenido']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Reseña histórica
    $('#form-resena-historica').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[0].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Misión
    $('#mision').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[0].setContent(nosotros['Mision']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Misión
    $('#form-mision').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[0].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Visión
    $('#vision').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[1].setContent(nosotros['Vision']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Visión
    $('#form-vision').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[1].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Organización
    $('#organizacion').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[2].setContent(nosotros['Organizacion']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Organización
    $('#form-organizacion').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[2].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Perfil
    $('#perfil-profesional').on('show.bs.modal', function () {
        // Rellena el formulario con los datos corespondientes
        tinymce.editors[3].setContent(nosotros['PerfilProfesional']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Perfil profesional
    $('#form-perfil-profesional').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[3].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Campo ocupacional
    $('#campo-ocupacional').on('show.bs.modal', function () {
        // Rellena el formulario con los datos corespondientes
        tinymce.editors[4].setContent(nosotros['CampoOcupacional']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Campo ocupacional
    $('#form-campo-ocupacional').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[4].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Grados y Títulos
    $('#grados-titulos').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-grados-titulos');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Grados y Títulos
    $('#form-grados-titulos').submit(function () {
        var $gradoAcademico = $(this).find('[name="grado-academico"]');
        var $tituloProfesional = $(this).find('[name="titulo-profesional"]');

        // Valida los campos
        if ($gradoAcademico[0].checkValidity() && $tituloProfesional[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desenadenado al cerrar el cuadro de diálogo Grados y Títulos
    $('#grados-titulos').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-grados-titulos');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Objetivos curriculares
    $('#objetivos-curriculares').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[0].setContent(planEstudios['ObjetivosCurriculares']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Objetivos curriculares
    $('#form-objetivos-curriculares').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[0].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Objetivo general
    $('#objetivo-general').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[1].setContent(planEstudios['ObjetivoGeneral']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Objetivo general
    $('#form-objetivo-general').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[1].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Objetivos específicos
    $('#objetivos-especificos').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[2].setContent(planEstudios['ObjetivosEspecificos']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Objetivos específicos
    $('#form-objetivos-especificos').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[2].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Objetivos de formación básica
    $('#objetivos-formacion-basica').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[3].setContent(planEstudios['ObjetivosFormacionBasica']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Objetivos de formación básica
    $('#form-objetivos-formacion-basica').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[3].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Objetivos de formación profesional
    $('#objetivos-formacion-profesional').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[4].setContent(planEstudios['ObjetivosFormacionProfesional']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Objetivos de formación profesional
    $('#form-objetivos-formacion-profesional').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[4].setMode('readonly');
    });

    // Captura el evento desencadenado al cambaiar el número de resolución
    $('#form-resolucion').find('[name="numero-resolucion"]').on('input', function () {
        // Captura el control
        var $numeroResolucion = $(this);
        // Valida el campo
        var isValid = $numeroResolucion[0].checkValidity();

        if (isValid) {
            $numeroResolucion.closest('.form-group').removeClass('has-error');
            $numeroResolucion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $numeroResolucion.closest('.form-group').addClass('has-error');
            $numeroResolucion.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Documento de resolución
    $('#form-resolucion').find('[name="documento"]').change(function () {
        // Captura el campo de selección de archivos
        var $documento = $(this);

        if ($documento[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($documento[0].files[0].type == 'application/pdf') {
                // Válida el tamaño del archivo
                if ($documento[0].files[0].size < 4194304) {
                    $documento.closest('.form-group').removeClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $documento.closest('.form-group').addClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $documento.closest('.form-group').find('.help-block').text('Selecciona un archivo');
        }
    });

    // Captura el event desencadenado al interactuar con la casilla para eliminar la resolución
    $('#form-resolucion').find('[data-delete-file]').change(function () {
        // Captura los campos
        var $documento = $('#form-resolucion').find('[name="documento"]');
        var $numeroResolucion = $('#form-resolucion').find('[name="numero-resolucion"]');

        // Cambia el estado de disponibilidad del selector de archivos
        $documento.prop('disabled', $(this).prop('checked'));
        $documento.closest('.file-input-group').find('.btn-file').prop('disabled', $(this).prop('checked'));

        // Cambia el estado de disponibilidad del campo Número de resolución
        if ($(this).prop('checked')) {
            $numeroResolucion.prop('disabled', true);
            $numeroResolucion.after(
                $('<input />', {
                    'type': 'hidden',
                    'name': 'numero-resolucion'
                })
            );
        }
        else {
            $('[type="hidden"]').filter('[name="numero-resolucion"]').remove();
            $numeroResolucion.prop('disabled', false);
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Resolución
    $('#form-resolucion').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $numeroResolucion = $(this).find('[name="numero-resolucion"]');
        var $documento = $(this).find('[name="documento"]');

        // Valida el campo Número de resolución
        if ($numeroResolucion[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $numeroResolucion.closest('.form-group').removeClass('has-error');
            $numeroResolucion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $numeroResolucion.closest('.form-group').addClass('has-error');
            $numeroResolucion.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Documento de resolución
        if (!$(this).find('[data-delete-file]').prop('checked')) {
            // Verifica si se seleccionó un archivo
            if ($documento[0].files.length > 0) {
                // Valida el tipo de archivo
                if ($documento[0].files[0].type == 'application/pdf') {
                    // Válida el tamaño del archivo
                    if ($documento[0].files[0].size < 4194304) {
                        $documento.closest('.form-group').removeClass('has-error');
                        $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                        $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                    }
                    else {
                        $documento.closest('.form-group').addClass('has-error');
                        $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                        $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                        isValid = false;
                    }
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                    isValid = false;
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('Selecciona un archivo');
                isValid = false;
            }
        }
        else {
            $documento.closest('.form-group').removeClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $documento.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Resolución
    $('#resolucion').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-resolucion');
        // Captura el campo Documento
        var $documento = $form.find('[name="documento"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Documento
        $documento.prop('disabled', false);
        $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Áreas curriculares de formación profesional
    $('#areas-curriculares').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[5].setContent(planEstudios['AreasCurriculares']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Áreas curriculares de formación profesional
    $('#form-areas-curriculares').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[5].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Plan de estudios general
    $('#plan-estudios-general').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[6].setContent(planEstudios['PlanEstudiosGeneral']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Plan de estudios general
    $('#form-plan-estudios-general').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[6].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Plan de estudios específico y de especialidad
    $('#plan-estudios-especifico-especialidad').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[7].setContent(planEstudios['PlanEstudiosEspecificoEspecialidad']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Plan de estudios específico y de especialidad
    $('#form-plan-estudios-especifico-especialidad').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[7].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Plan de estudios semestralizado
    $('#plan-estudios-semestralizado').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[8].setContent(planEstudios['PlanEstudiosSemestralizado']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Plan de estudios semestralizado
    $('#form-plan-estudios-semestralizado').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[8].setMode('readonly');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Malla curricular
    $('#malla-curricular').on('show.bs.modal', function () {
        // Rellena el formulario con los datos correspondientes
        tinymce.editors[9].setContent(planEstudios['MallaCurricular']);
    });

    // Captura el evento desencadenado al enviar los datos del formulario Malla curricular
    $('#form-malla-curricular').submit(function () {
        $(this).find('input, select').prop('readonly', true);
        $(this).find('button').prop('disabled', true);
        $(this).closest('.modal').find('button').prop('disabled', true);
        tinymce.editors[9].setMode('readonly');
    });

    // Captura el evento desencadenado al cambaiar el nombre del docente en el formulario Registrar docente
    $('#form-registrar-docente').find('[name="nombre"]').on('input', function () {
        // Captura el control
        var $nombre = $(this);
        // Valida el campo
        var isValid = $nombre[0].checkValidity();

        if (isValid) {
            $nombre.closest('.form-group').removeClass('has-error');
            $nombre.closest('.form-group').find('.help-block').empty();
        }
        else {
            $nombre.closest('.form-group').addClass('has-error');
            $nombre.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el grado académico del docente en el formulario Registrar docente
    $('#form-registrar-docente').find('[name="grado-academico"]').on('input', function () {
        // Captura el control
        $gradoAcademico = $(this);
        // Valida el campo
        var isValid = $gradoAcademico[0].checkValidity();

        if (isValid) {
            $gradoAcademico.closest('.form-group').removeClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $gradoAcademico.closest('.form-group').addClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar la categoría y el régimen del docente en el formulario Registrar doente
    $('#form-registrar-docente').find('[name="categoria-regimen"]').change(function () {
        // Captura el control
        var $categoriaRegimen = $(this);
        // Valida el campo
        var isValid = $categoriaRegimen[0].checkValidity();

        if (isValid) {
            $categoriaRegimen.closest('.form-group').removeClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').empty();
        }
        else {
            $categoriaRegimen.closest('.form-group').addClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').text('Selecciona una opción');
        }
    });

    // Captura el evento desencadenado al cambaiar el correo electrónico del docente en el formulario Registrar docente
    $('#form-registrar-docente').find('[name="correo-electronico"]').on('input', function () {
        // Captura el control
        var $correoElectronico = $(this);
        // Valida el campo
        var isValid = $correoElectronico[0].checkValidity();

        if (isValid) {
            $correoElectronico.closest('.form-group').removeClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $correoElectronico.closest('.form-group').addClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambaiar la URL de la hoja de vida del docente en el formulario Registrar docente
    $('#form-registrar-docente').find('[name="hoja-vida"]').on('input', function () {
        // Captura el control
        var $hojaVida = $(this);
        // Valida el campo
        var isValid = $hojaVida[0].checkValidity();

        if (isValid) {
            $hojaVida.closest('.form-group').removeClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').empty();
        }
        else {
            $hojaVida.closest('.form-group').addClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').text('Introduzca un URL válida');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Foto del formulario Registrar docente
    $('#form-registrar-docente').find('[name="foto"]').change(function () {
        // Captura el campo de selección de archivos
        var $foto = $(this);

        if ($foto[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $foto.closest('.form-group').removeClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $foto.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Registrar docente
    $('#form-registrar-docente').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $nombre = $(this).find('[name="nombre"]');
        var $gradoAcademico = $(this).find('[name="grado-academico"]');
        var $categoriaRegimen = $(this).find('[name="categoria-regimen"]');
        var $correoElectronico = $(this).find('[name="correo-electronico"]');
        var $hojaVida = $(this).find('[name="hoja-vida"]');
        var $foto = $(this).find('[name="foto"]');

        // Valida el campo Nombre
        if ($nombre[0].checkValidity()) {
            // Quita el estado de error del campo
            $nombre.closest('.form-group').removeClass('has-error');
            $nombre.closest('.form-group').find('.help-block').empty();
        }
        else {
            $nombre.closest('.form-group').addClass('has-error');
            $nombre.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Grado académico
        if ($gradoAcademico[0].checkValidity()) {
            // Quita el estado de error del campo
            $gradoAcademico.closest('.form-group').removeClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $gradoAcademico.closest('.form-group').addClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Categoría y régimen
        if ($categoriaRegimen[0].checkValidity()) {
            // Quita el estado de error del campo
            $categoriaRegimen.closest('.form-group').removeClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').empty();
        }
        else {
            $categoriaRegimen.closest('.form-group').addClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').text('Selecciona una opción');
            isValid = false;
        }

        // Valida el campo Correo electrónico
        if ($correoElectronico[0].checkValidity()) {
            // Quita el estado de error del campo
            $correoElectronico.closest('.form-group').removeClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $correoElectronico.closest('.form-group').addClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Hoja de vida
        if ($hojaVida[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $hojaVida.closest('.form-group').removeClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').empty();
        }
        else {
            $hojaVida.closest('.form-group').addClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').text('Introduzca una URL válida');
            isValid = false;
        }

        // Valida el campo Foto
        if ($foto[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe superar los 4MB');
                    isValid = false;
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $foto.closest('.form-group').removeClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $foto.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Registrar docente
    $('#registrar-docente').on('hidden.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-registrar-docente');
        // Restablece el formulario
        $form[0].reset();
        $form.find('[name="categoria-regimen"]').selectpicker('refresh');
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        $form.find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Editar docente
    $('[data-target="#editar-docente"]').click(function () {
        // Captura el Id del elemento seleccionado
        var id = $(this).data('id');
        // Recupera el indice del elemento seleccionado
        var index = indexOfPropertyValue(docentes, 'Id', id);
        // Rellena el formulario con los datos correspondientes al elemento seleccionado
        $('#form-editar-docente').find('[name="id"]').val(docentes[index]['Id']);
        $('#form-editar-docente').find('[name="nombre"]').val(docentes[index]['Nombre']);
        $('#form-editar-docente').find('[name="grado-academico"]').val(docentes[index]['GradoAcademico']);
        $('#form-editar-docente').find('[name="categoria-regimen"]').selectpicker('val', docentes[index]['CategoriaRegimen']);
        $('#form-editar-docente').find('[name="correo-electronico"]').val(docentes[index]['CorreoElectronico']);
        $('#form-editar-docente').find('[name="hoja-vida"]').val(docentes[index]['HojaVida']);
    });

    // Captura el evento desencadenado al cambaiar el nombre del docente en el formulario Editar docente
    $('#form-editar-docente').find('[name="nombre"]').on('input', function () {
        // Captura el control
        var $nombre = $(this);
        // Valida el campo
        var isValid = $nombre[0].checkValidity();

        if (isValid) {
            $nombre.closest('.form-group').removeClass('has-error');
            $nombre.closest('.form-group').find('.help-block').empty();
        }
        else {
            $nombre.closest('.form-group').addClass('has-error');
            $nombre.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el grado académico del docenteen el formulario Editar docente
    $('#form-editar-docente').find('[name="grado-academico"]').on('input', function () {
        // Captura el control
        $gradoAcademico = $(this);
        // Valida el campo
        var isValid = $gradoAcademico[0].checkValidity();

        if (isValid) {
            $gradoAcademico.closest('.form-group').removeClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $gradoAcademico.closest('.form-group').addClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    })

    // Captura el evento desencadenado al cambiar la categoría y el régimen del docente en el formulario Editar docente
    $('#form-editar-docente').find('[name="categoria-regimen"]').change(function () {
        // Captura el control
        var $categoriaRegimen = $(this);
        // Valida el campo
        var isValid = $categoriaRegimen[0].checkValidity();

        if (isValid) {
            $categoriaRegimen.closest('.form-group').removeClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').empty();
        }
        else {
            $categoriaRegimen.closest('.form-group').addClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambaiar el correo electrónico del docente en el formulario Editar docente
    $('#form-editar-docente').find('[name="correo-electronico"]').on('input', function () {
        // Captura el control
        var $correoElectronico = $(this);
        // Valida el campo
        var isValid = $correoElectronico[0].checkValidity();

        if (isValid) {
            $correoElectronico.closest('.form-group').removeClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $correoElectronico.closest('.form-group').addClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambaiar la URL de la hoja de vida del docente en el formulario Editar docente
    $('#form-editar-docente').find('[name="hoja-vida"]').on('input', function () {
        // Captura el control
        var $hojaVida = $(this);
        // Valida el campo
        var isValid = $hojaVida[0].checkValidity();

        if (isValid) {
            $hojaVida.closest('.form-group').removeClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').empty();
        }
        else {
            $hojaVida.closest('.form-group').addClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').text('Introduzca una URL válida');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Foto del formulario Editar docente
    $('#form-editar-docente').find('[name="foto"]').change(function () {
        // Captura el campo de selección de archivos
        var $foto = $(this);

        if ($foto[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe superar los 4MB');
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $foto.closest('.form-group').removeClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $foto.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Editar docente 
    $('#form-editar-docente').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $nombre = $(this).find('[name="nombre"]');
        var $gradoAcademico = $(this).find('[name="grado-academico"]');
        var $categoriaRegimen = $(this).find('[name="categoria-regimen"]');
        var $correoElectronico = $(this).find('[name="correo-electronico"]');
        var $hojaVida = $(this).find('[name="hoja-vida"]');
        var $foto = $(this).find('[name="foto"]');

        // Valida el campo Nombre
        if ($nombre[0].checkValidity()) {
            $nombre.closest('.form-group').removeClass('has-error');
            $nombre.closest('.form-group').find('.help-block').empty();
        }
        else {
            $nombre.closest('.form-group').addClass('has-error');
            $nombre.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Grado académico
        if ($gradoAcademico[0].checkValidity()) {
            $gradoAcademico.closest('.form-group').removeClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $gradoAcademico.closest('.form-group').addClass('has-error');
            $gradoAcademico.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Categoría y régimen
        if ($categoriaRegimen[0].checkValidity()) {
            $categoriaRegimen.closest('.form-group').removeClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').empty();
        }
        else {
            $categoriaRegimen.closest('.form-group').addClass('has-error');
            $categoriaRegimen.closest('.form-group').find('.help-block').text('Selecciona una opción');
            isValid = false;
        }

        // Valida el campo Correo electrónico
        if ($correoElectronico[0].checkValidity()) {
            $correoElectronico.closest('.form-group').removeClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').empty();
        }
        else {
            $correoElectronico.closest('.form-group').addClass('has-error');
            $correoElectronico.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Hoja de vida
        if ($hojaVida[0].checkValidity()) {
            $hojaVida.closest('.form-group').removeClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').empty();
        }
        else {
            $hojaVida.closest('.form-group').addClass('has-error');
            $hojaVida.closest('.form-group').find('.help-block').text('Introduzca una URL válida');
            isValid = false;
        }

        // Valida el campo Foto
        if ($foto[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe superar los 4MB');
                    isValid = false;
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $foto.closest('.form-group').removeClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $foto.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Editar docente
    $('#editar-docente').on('hidden.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-editar-docente');
        // Restablece el formulario
        $form[0].reset();
        $form.find('[name="categoria-regimen"]').selectpicker('refresh');
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        $form.find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar docente
    $('[data-target="#eliminar-docente"]').click(function () {
        $('#eliminar-docente').find('.btn-ok').attr('data-href', 'entities/docentes/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar docente
    $('#eliminar-docente').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-docente').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar docente
    $('#eliminar-docente').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar docentes
    $('#btn-eliminar-docentes').click(function () {
        var select = [];

        $('[data-check-group="docentes"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-docentes').find('.btn-ok').attr('data-href', 'entities/docentes/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar docentes
    $('#eliminar-docentes').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-docentes').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar docentes
    $('#eliminar-docentes').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al cambaiar el título de la noticia en el formulario Publicar Noticia
    $('#form-publicar-noticia').find('[name="titulo"]').on('input', function () {
        // Captura el control
        var $titulo = $(this);
        // Valida el campo
        var isValid = $titulo[0].checkValidity();

        if (isValid) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Imagen de portada en el formulario Publicar noticia
    $('#form-publicar-noticia').find('[name="portada"]').change(function () {
        // Captura el campo de selección de archivos
        var $portada = $(this);
        // Valida el campo
        var isValid = $portada[0].checkValidity();

        if (isValid) {
            // Valida el tipo de archivo
            if ($portada[0].files[0].type == 'image/png' || $portada[0].files[0].type == 'image/jpeg' || $portada[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($portada[0].files[0].size < 4194304) {
                    $portada.closest('.form-group').removeClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $portada.closest('.form-group').find('.help-block').text($portada[0].files[0].name);
                }
                else {
                    $portada.closest('.form-group').addClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $portada.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $portada.closest('.form-group').addClass('has-error');
                $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $portada.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $portada.closest('.form-group').addClass('has-error');
            $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $portada.closest('.form-group').find('.help-block').text('Selecciona un archivo');
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Publicar noticia 
    $('#form-publicar-noticia').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $titulo = $(this).find('[name="titulo"]');
        var $portada = $(this).find('[name="portada"]');

        // Valida el campo Título
        if ($titulo[0].checkValidity()) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Imagen de portada
        if ($portada[0].checkValidity()) {
            // Valida el tipo de archivo
            if ($portada[0].files[0].type == 'image/png' || $portada[0].files[0].type == 'image/jpeg' || $portada[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($portada[0].files[0].size < 4194304) {
                    $portada.closest('.form-group').removeClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $portada.closest('.form-group').find('.help-block').text($portada[0].files[0].name);
                }
                else {
                    $portada.closest('.form-group').addClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $portada.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $portada.closest('.form-group').addClass('has-error');
                $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $portada.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $portada.closest('.form-group').addClass('has-error');
            $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $portada.closest('.form-group').find('.help-block').text('Selecciona un archivo');
            isValid = false;
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
            tinymce.editors[0].setMode('readonly');
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Publicar noticia
    $('#publicar-noticia').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-publicar-noticia');
        // Captura el campo Imagen de portada
        var $portada = $form.find('[name="portada"]');
        // Captura el editor de texto
        var $editor = $form.find('[name="contenido"]');
        // Restablece el formulario
        $form[0].reset();
        // Restablece el editor de texto
        tinymce.editors[0].setContent('');
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Inagen de portada
        $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Editar noticia
    $('[data-target="#editar-noticia"]').click(function () {
        // Captura el Id del elemento seleccionado
        var id = $(this).data('id');
        // Recupera el indice del elemento seleccionado
        var index = indexOfPropertyValue(noticias, 'Id', id);
        // Rellena el formulario con los datos correspondientes al elemento seleccionado
        $('#form-editar-noticia').find('[name="id"]').val(noticias[index]['Id']);
        $('#form-editar-noticia').find('[name="titulo"]').val(noticias[index]['Titulo']);
        tinymce.editors[1].setContent(noticias[index]['Contenido']);
    });

    // Captura el evento desencadenado al cambaiar el título de la noticia en el formulario Editar noticia
    $('#form-editar-noticia').find('[name="titulo"]').on('input', function () {
        // Captura el control
        var $titulo = $(this);
        // Valida el campo
        var isValid = $titulo[0].checkValidity();

        if (isValid) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Imagen de portada en el formulario Editar noticia
    $('#form-editar-noticia').find('[name="portada"]').change(function () {
        // Captura el campo de selección de archivos
        var $portada = $(this);

        if ($portada[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($portada[0].files[0].type == 'image/png' || $portada[0].files[0].type == 'image/jpeg' || $portada[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($portada[0].files[0].size < 4194304) {
                    $portada.closest('.form-group').removeClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $portada.closest('.form-group').find('.help-block').text($portada[0].files[0].name);
                }
                else {
                    $portada.closest('.form-group').addClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $portada.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $portada.closest('.form-group').addClass('has-error');
                $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $portada.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $portada.closest('.form-group').removeClass('has-error');
            $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $portada.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Editar noticia 
    $('#form-editar-noticia').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $titulo = $(this).find('[name="titulo"]');
        var $portada = $(this).find('[name="portada"]');

        // Valida el campo Título
        if ($titulo[0].checkValidity()) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Imagen de portada
        if ($portada[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($portada[0].files[0].type == 'image/png' || $portada[0].files[0].type == 'image/jpeg' || $portada[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($portada[0].files[0].size < 4194304) {
                    $portada.closest('.form-group').removeClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $portada.closest('.form-group').find('.help-block').text($portada[0].files[0].name);
                }
                else {
                    $portada.closest('.form-group').addClass('has-error');
                    $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $portada.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $portada.closest('.form-group').addClass('has-error');
                $portada.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $portada.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $portada.closest('.form-group').removeClass('has-error');
            $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $portada.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
            tinymce.editors[0].setMode('readonly');
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Editar noticia
    $('#editar-noticia').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-editar-noticia');
        // Captura el campo Imagen de portada
        var $portada = $form.find('[name="portada"]');
        // Restablece el formulario
        $form[0].reset();
        // Restablece el editor de texto
        tinymce.editors[1].setContent('');
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Imagen de portada
        $portada.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar noticia
    $('[data-target="#eliminar-noticia"]').click(function () {
        $('#eliminar-noticia').find('.btn-ok').attr('data-href', 'entities/noticias/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar noticia
    $('#eliminar-noticia').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-noticia').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar noticia
    $('#eliminar-noticia').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar noticias
    $('#btn-eliminar-noticias').click(function () {
        var select = [];

        $('[data-check-group="noticias"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-noticias').find('.btn-ok').attr('data-href', 'entities/noticias/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar noticias
    $('#eliminar-noticias').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-noticias').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar noticias
    $('#eliminar-noticias').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al cambaiar la descripción de la foto del formulario Publicar foto
    $('#form-publicar-foto').find('[name="descripcion"]').on('input', function () {
        // Captura el control
        var $descripcion = $(this);
        // Valida el campo
        var isValid = $descripcion[0].checkValidity();

        if (isValid) {
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Foto del formulario Publicar foto
    $('#form-publicar-foto').find('[name="foto"]').change(function () {
        // Captura el campo de selección de archivos
        var $foto = $(this);
        // Valida el campo
        var isValid = $foto[0].checkValidity();

        if (isValid) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $foto.closest('.form-group').addClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $foto.closest('.form-group').find('.help-block').text('Selecciona un archivo');
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Publicar foto 
    $('#form-publicar-foto').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $descripcion = $(this).find('[name="descripcion"]');
        var $foto = $(this).find('[name="foto"]');

        // Valida el campo Descripción
        if ($descripcion[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Foto
        if ($foto[0].checkValidity()) {
            // Valida el tipo de archivo
            if ($foto[0].files[0].type == 'image/png' || $foto[0].files[0].type == 'image/jpeg' || $foto[0].files[0].type == 'image/bmp') {
                // Válida el tamaño del archivo
                if ($foto[0].files[0].size < 4194304) {
                    $foto.closest('.form-group').removeClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $foto.closest('.form-group').find('.help-block').text($foto[0].files[0].name);
                }
                else {
                    $foto.closest('.form-group').addClass('has-error');
                    $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $foto.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $foto.closest('.form-group').addClass('has-error');
                $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $foto.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $foto.closest('.form-group').addClass('has-error');
            $foto.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $foto.closest('.form-group').find('.help-block').text('Selecciona un archivo');
            isValid = false;
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Publicar foto
    $('#publicar-foto').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-publicar-foto');
        // Captura el campo foto
        var $foto = $form.find('[name="foto"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Foto
        $foto.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Actualizar descripción de la foto
    $('[data-target="#actualizar-descripcion-foto"]').click(function () {
        // Captura el Id del elemento seleccionado
        var id = $(this).data('id');
        // Recupera el indice del elemento seleccionado
        var index = indexOfPropertyValue(galeria, 'Id', id);
        // Rellena el formulario con los datos correspondientes al elemento seleccionado
        $('#form-actualizar-descripcion-foto').find('[name="id"]').val(galeria[index]['Id']);
        $('#form-actualizar-descripcion-foto').find('[name="descripcion"]').val(galeria[index]['Descripcion']);
    });

    // Captura el evento desencadenado al cambaiar la descripción del formulario Actualizar descripción de la foto
    $('#form-actualizar-descripcion-foto').find('[name="descripcion"]').on('input', function () {
        // Captura el control
        var $descripcion = $(this);
        // Valida el campo
        var isValid = $descripcion[0].checkValidity();

        if (isValid) {
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Actualizar descripción de la foto 
    $('#form-actualizar-descripcion-foto').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $descripcion = $(this).find('[name="descripcion"]');

        // Valida el campo Descripción
        if ($descripcion[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Actualizar descripción de la foto
    $('#actualizar-descripcion-foto').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-actualizar-descripcion-foto');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar foto
    $('[data-target="#eliminar-foto"]').click(function () {
        $('#eliminar-foto').find('.btn-ok').attr('data-href', 'entities/galeria/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar foto
    $('#eliminar-foto').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-foto').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar foto
    $('#eliminar-foto').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar fotos
    $('#btn-eliminar-fotos').click(function () {
        var select = [];

        $('[data-check-group="galeria"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-fotos').find('.btn-ok').attr('data-href', 'entities/galeria/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar fotos
    $('#eliminar-fotos').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-fotos').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar fotos
    $('#eliminar-fotos').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al cambaiar la descripción del documento del formulario Publicar documento
    $('#form-publicar-documento').find('[name="descripcion"]').on('input', function () {
        // Captura el control
        var $descripcion = $(this);
        // Valida el campo
        var isValid = $descripcion[0].checkValidity();

        if (isValid) {
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Documento del formulario Publicar documento
    $('#form-publicar-documento').find('[name="documento"]').change(function () {
        // Captura el campo de selección de archivos
        var $documento = $(this);
        // Valida el campo
        var isValid = $documento[0].checkValidity();

        if (isValid) {
            // Valida el tipo de archivo
            if ($documento[0].files[0].type == 'application/pdf') {
                // Válida el tamaño del archivo
                if ($documento[0].files[0].size < 4194304) {
                    $documento.closest('.form-group').removeClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $documento.closest('.form-group').addClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $documento.closest('.form-group').find('.help-block').text('Selecciona un archivo');
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Publicar documento 
    $('#form-publicar-documento').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $descripcion = $(this).find('[name="descripcion"]');
        var $documento = $(this).find('[name="documento"]');

        // Valida el campo Descripción
        if ($descripcion[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Documento
        if ($documento[0].checkValidity()) {
            // Valida el tipo de archivo
            if ($documento[0].files[0].type == 'application/pdf') {
                // Válida el tamaño del archivo
                if ($documento[0].files[0].size < 4194304) {
                    $documento.closest('.form-group').removeClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $documento.closest('.form-group').addClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $documento.closest('.form-group').find('.help-block').text('Selecciona un archivo');
            isValid = false;
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Publicar documento
    $('#publicar-documento').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-publicar-documento');
        // Captura el campo Documento
        var $documento = $form.find('[name="documento"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Documento
        $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Actualizar documento
    $('[data-target="#actualizar-documento"]').click(function () {
        // Captura el Id del elemento seleccionado
        var id = $(this).data('id');
        // Recupera el indice del elemento seleccionado
        var index = indexOfPropertyValue(documentos, 'Id', id);
        // Rellena el formulario con los datos correspondientes al elemento seleccionado
        $('#form-actualizar-documento').find('[name="id"]').val(documentos[index]['Id']);
        $('#form-actualizar-documento').find('[name="descripcion"]').val(documentos[index]['Descripcion']);
    });

    // Captura el evento desencadenado al cambaiar la descripción del documento del formulario Actualizar documento
    $('#form-actualizar-documento').find('[name="descripcion"]').on('input', function () {
        // Captura el control
        var $descripcion = $(this);
        // Valida el campo
        var isValid = $descripcion[0].checkValidity();

        if (isValid) {
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Documento del formulario Actualizar documento
    $('#form-actualizar-documento').find('[name="documento"]').change(function () {
        // Captura el campo de selección de archivos
        var $documento = $(this);

        if ($documento[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($documento[0].files[0].type == 'application/pdf') {
                // Válida el tamaño del archivo
                if ($documento[0].files[0].size < 4194304) {
                    $documento.closest('.form-group').removeClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $documento.closest('.form-group').removeClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $documento.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Actualizar documento 
    $('#form-actualizar-documento').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $descripcion = $(this).find('[name="descripcion"]');
        var $documento = $(this).find('[name="documento"]');

        // Valida el campo Descripción
        if ($descripcion[0].checkValidity()) {
            // Quita el estado de error del campo Descripción
            $descripcion.closest('.form-group').removeClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').empty();
        }
        else {
            $descripcion.closest('.form-group').addClass('has-error');
            $descripcion.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Documento
        if ($documento[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($documento[0].files[0].type == 'application/pdf') {
                // Válida el tamaño del archivo
                if ($documento[0].files[0].size < 4194304) {
                    $documento.closest('.form-group').removeClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $documento.closest('.form-group').find('.help-block').text($documento[0].files[0].name);
                }
                else {
                    $documento.closest('.form-group').addClass('has-error');
                    $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $documento.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $documento.closest('.form-group').addClass('has-error');
                $documento.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $documento.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $documento.closest('.form-group').removeClass('has-error');
            $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $documento.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Actualizar documento
    $('#actualizar-documento').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-actualizar-documento');
        // Captura el campo Documento
        var $documento = $form.find('[name="documento"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Documento
        $documento.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar documento
    $('[data-target="#eliminar-documento"]').click(function () {
        $('#eliminar-documento').find('.btn-ok').attr('data-href', 'entities/documentos/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar documento
    $('#eliminar-documento').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-documento').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar documento
    $('#eliminar-documento').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar documentos
    $('#btn-eliminar-documentos').click(function () {
        var select = [];

        $('[data-check-group="documentos"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-documentos').find('.btn-ok').attr('data-href', 'entities/documentos/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar documentos
    $('#eliminar-documentos').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-documentos').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar documentos
    $('#eliminar-documentos').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Facebook
    $('#facebook').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-facebook');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Facebook
    $('#form-facebook').submit(function () {
        var $facebook = $(this).find('[name="facebook"]');

        // Valida los campos
        if ($facebook[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desenadenado al cerrar el cuadro de diálogo Facebook
    $('#facebook').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-facebook');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Twitter
    $('#twitter').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-twitter');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Twitter
    $('#form-twitter').submit(function () {
        var $twitter = $(this).find('[name="twitter"]');

        // Valida los campos
        if ($twitter[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desenadenado al cerrar el cuadro de diálogo Twitter
    $('#twitter').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-twitter');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al lanzar el cuadro de diálogo Google Plus
    $('#google-plus').on('show.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-google-plus');
        // Inicializa el validador
        $form.validator();
    });

    // Captura el evento desencadenado al enviar los datos del formulario Google Plus
    $('#form-google-plus').submit(function () {
        var $googlePlus = $(this).find('[name="google-plus"]');

        // Valida los campos
        if ($googlePlus[0].checkValidity()) {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desenadenado al cerrar el cuadro de diálogo Google Plus
    $('#google-plus').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-google-plus');
        // Restablece el formulario
        $form[0].reset();
        // Destruye el validador
        $form.validator('destroy');
    });

    // Captura el evento desencadenado al cambaiar el título en el formulario Agregar enlace externo
    $('#form-agregar-enlace-externo').find('[name="titulo"]').on('input', function () {
        // Captura el control
        var $titulo = $(this);
        // Valida el campo
        var isValid = $titulo[0].checkValidity();

        if (isValid) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambaiar la dirección URL en el formulario Agregar enlace externo
    $('#form-agregar-enlace-externo').find('[name="url"]').on('input', function () {
        // Captura el control
        var $url = $(this);
        // Valida el campo
        var isValid = $url[0].checkValidity();

        if (isValid) {
            $url.closest('.form-group').removeClass('has-error');
            $url.closest('.form-group').find('.help-block').empty();
        }
        else {
            $url.closest('.form-group').addClass('has-error');
            $url.closest('.form-group').find('.help-block').text('Ingresa una dirección URL válida');
        }
    });

    // Captura el evento desencadenado al cambaiar el orden en el formulario Agregar enlace externo
    $('#form-agregar-enlace-externo').find('[name="orden"]').on('input', function () {
        // Captura el control
        var $orden = $(this);
        // Valida el campo
        var isValid = $orden[0].checkValidity();

        if (isValid) {
            $orden.closest('.form-group').removeClass('has-error');
            $orden.closest('.form-group').find('.help-block').empty();
        }
        else {
            $orden.closest('.form-group').addClass('has-error');
            $orden.closest('.form-group').find('.help-block').text('Ingresa un número para definir el orden');
        }
    });

    // Captura el evento desencadenado al cambiar el campo Logotipo en el formulario Agregar enlace externo
    $('#form-agregar-enlace-externo').find('[name="logo"]').change(function () {
        // Captura el campo de selección de archivos
        var $logo = $(this);
        // Valida el campo
        var isValid = $logo[0].checkValidity();

        if (isValid) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $logo.closest('.form-group').addClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $logo.closest('.form-group').find('.help-block').text('Selecciona un archivo');
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Agregar enlace externo
    $('#form-agregar-enlace-externo').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $titulo = $(this).find('[name="titulo"]');
        var $url = $(this).find('[name="url"]');
        var $orden = $(this).find('[name="orden"]');
        var $logo = $(this).find('[name="logo"]');

        // Valida el campo Título
        if ($titulo[0].checkValidity()) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Dirección URL
        if ($url[0].checkValidity()) {
            $url.closest('.form-group').removeClass('has-error');
            $url.closest('.form-group').find('.help-block').empty();
        }
        else {
            $url.closest('.form-group').addClass('has-error');
            $url.closest('.form-group').find('.help-block').text('Ingresa una dirección URL válida');
            isValid = false;
        }

        // Valida el campo Orden
        if ($orden[0].checkValidity()) {
            $orden.closest('.form-group').removeClass('has-error');
            $orden.closest('.form-group').find('.help-block').empty();
        }
        else {
            $orden.closest('.form-group').addClass('has-error');
            $orden.closest('.form-group').find('.help-block').text('Ingresa un número para definir el orden');
            isValid = false;
        }

        // Valida el campo Logotipo
        if ($logo[0].checkValidity()) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $logo.closest('.form-group').addClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
            $logo.closest('.form-group').find('.help-block').text('Selecciona un archivo');
            isValid = false;
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Agregar enlace externo
    $('#agregar-enlace-externo').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-agregar-enlace-externo');
        // Captura el campo Logotipo
        var $logo = $form.find('[name="logo"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Logotipo
        $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Editar enlace externo
    $('[data-target="#editar-enlace-externo"]').click(function () {
        // Captura el Id del elemento seleccionado
        var id = $(this).data('id');
        // Recupera el indice del elemento seleccionado
        var index = indexOfPropertyValue(listaEnlacesExternos, 'Id', id);
        // Rellena el formulario con los datos correspondientes al elemento seleccionado
        $('#form-editar-enlace-externo').find('[name="id"]').val(listaEnlacesExternos[index]['Id']);
        $('#form-editar-enlace-externo').find('[name="titulo"]').val(listaEnlacesExternos[index]['Titulo']);
        $('#form-editar-enlace-externo').find('[name="url"]').val(listaEnlacesExternos[index]['Url']);
        $('#form-editar-enlace-externo').find('[name="orden"]').val(listaEnlacesExternos[index]['Orden']);
    });

    // Captura el evento desencadenado al cambaiar el título en el formulario Editar enlace externo
    $('#form-editar-enlace-externo').find('[name="titulo"]').on('input', function () {
        // Captura el control
        var $titulo = $(this);
        // Valida el campo
        var isValid = $titulo[0].checkValidity();

        if (isValid) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
        }
    });

    // Captura el evento desencadenado al cambaiar la dirección URL en el formulario Editar enlace externo
    $('#form-editar-enlace-externo').find('[name="url"]').on('input', function () {
        // Captura el control
        var $url = $(this);
        // Valida el campo
        var isValid = $url[0].checkValidity();

        if (isValid) {
            $url.closest('.form-group').removeClass('has-error');
            $url.closest('.form-group').find('.help-block').empty();
        }
        else {
            $url.closest('.form-group').addClass('has-error');
            $url.closest('.form-group').find('.help-block').text('Ingresa una dirección URL válida');
        }
    });

    // Captura el evento desencadenado al cambaiar el orden en el formulario Editar enlace externo
    $('#form-editar-enlace-externo').find('[name="orden"]').on('input', function () {
        // Captura el control
        var $orden = $(this);
        // Valida el campo
        var isValid = $orden[0].checkValidity();

        if (isValid) {
            $orden.closest('.form-group').removeClass('has-error');
            $orden.closest('.form-group').find('.help-block').empty();
        }
        else {
            $orden.closest('.form-group').addClass('has-error');
            $orden.closest('.form-group').find('.help-block').text('Ingresa un número para definir el orden');
        }
    });

    // Captura el evento desencadenado al cambiar el logotipo en el formulario Editar enlace externo
    $('#form-editar-enlace-externo').find('[name="logo"]').change(function () {
        // Captura el campo de selección de archivos
        var $logo = $(this);

        if ($logo[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
            }
        }
        else {
            $logo.closest('.form-group').removeClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $logo.closest('.form-group').find('.help-block').empty();
        }
    });

    // Captura el evento desencadenado al enviar los datos del formulario Editar Enlace externo 
    $('#form-editar-enlace-externo').submit(function (e) {
        // Inicializa la validación del formulario
        var isValid = true;

        // Captura los campos
        var $titulo = $(this).find('[name="titulo"]');
        var $url = $(this).find('[name="url"]');
        var $orden = $(this).find('[name="orden"]');
        var $logo = $(this).find('[name="logo"]');

        // Valida el campo Título
        if ($titulo[0].checkValidity()) {
            $titulo.closest('.form-group').removeClass('has-error');
            $titulo.closest('.form-group').find('.help-block').empty();
        }
        else {
            $titulo.closest('.form-group').addClass('has-error');
            $titulo.closest('.form-group').find('.help-block').text('Completa este campo');
            isValid = false;
        }

        // Valida el campo Dirección URL
        if ($url[0].checkValidity()) {
            $url.closest('.form-group').removeClass('has-error');
            $url.closest('.form-group').find('.help-block').empty();
        }
        else {
            $url.closest('.form-group').addClass('has-error');
            $url.closest('.form-group').find('.help-block').text('Ingresa una dirección URL válida');
            isValid = false;
        }

        // Valida el campo Orden
        if ($orden[0].checkValidity()) {
            $orden.closest('.form-group').removeClass('has-error');
            $orden.closest('.form-group').find('.help-block').empty();
        }
        else {
            $orden.closest('.form-group').addClass('has-error');
            $orden.closest('.form-group').find('.help-block').text('Ingresa un número para definir el orden');
            isValid = false;
        }

        // Valida el campo Logotipo
        if ($logo[0].files.length > 0) {
            // Valida el tipo de archivo
            if ($logo[0].files[0].type == 'image/png') {
                // Válida el tamaño del archivo
                if ($logo[0].files[0].size < 4194304) {
                    $logo.closest('.form-group').removeClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
                    $logo.closest('.form-group').find('.help-block').text($logo[0].files[0].name);
                }
                else {
                    $logo.closest('.form-group').addClass('has-error');
                    $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                    $logo.closest('.form-group').find('.help-block').text('El tamaño del archivo no debe sobrepasar los 4MB');
                    isValid = false;
                }
            }
            else {
                $logo.closest('.form-group').addClass('has-error');
                $logo.closest('.form-group').find('.btn-file').removeClass('btn-default').addClass('btn-danger');
                $logo.closest('.form-group').find('.help-block').text('El tipo de archivo no es válido');
                isValid = false;
            }
        }
        else {
            $logo.closest('.form-group').removeClass('has-error');
            $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
            $logo.closest('.form-group').find('.help-block').empty();
        }

        // Comprueba la validez general del formulario
        if (!isValid) {
            // Si no es válido, interrumpe el envío
            e.preventDefault();
        }
        else {
            $(this).find('input, select').prop('readonly', true);
            $(this).find('button').prop('disabled', true);
            $(this).closest('.modal').find('button').prop('disabled', true);
        }
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Editar enlace externo
    $('#editar-enlace-externo').on('hide.bs.modal', function () {
        // Captura el formulario
        var $form = $('#form-editar-enlace-externo');
        // Captura el campo Imagen de portada
        var $logo = $form.find('[name="logo"]');
        // Restablece el formulario
        $form[0].reset();
        // Quita los estados de error
        $form.find('.form-group').removeClass('has-error');
        $form.find('.help-block').empty();
        // Restablece el agrupador del campo Logotipo
        $logo.closest('.form-group').find('.btn-file').removeClass('btn-danger').addClass('btn-default');
    });

    // Captura el evento desencadenado al hacer clic sobre la opción Eliminar enlace externo
    $('[data-target="#eliminar-enlace-externo"]').click(function () {
        $('#eliminar-enlace-externo').find('.btn-ok').attr('data-href', 'entities/enlaces-externos/delete.php?id=' + $(this).data('id'));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar enlace externo
    $('#eliminar-enlace-externo').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-enlace-externo').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar enlace externo
    $('#eliminar-externo').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });

    // Captura el evento desencadenado al hacer clic sobre el botón para eliminar enlaces externos
    $('#btn-eliminar-enlaces-externos').click(function () {
        var select = [];

        $('[data-check-group="enlaces-externos"]').filter(':checked').each(function () {
            select.push($(this).data('value'));
        });

        $('#eliminar-enlaces-externos').find('.btn-ok').attr('data-href', 'entities/enlaces-externos/delete-mass.php?ids=' + JSON.stringify(select));
    });

    // Captura el evento desencadenado al confirmar la acción del cuadro de diálogo Eliminar enlaces externos
    $('#eliminar-enlaces-externos').find('.btn-ok').click(function () {
        window.location.href = $(this).data('href');
        $('#eliminar-enlaces-externos').find('button').prop('disabled', true);
    });

    // Captura el evento desencadenado al cerrar el cuadro de diálogo Eliminar enlaces externos
    $('#eliminar-enlaces-externos').on('hidden.bs.modal', function () {
        $(this).find('.btn-ok').removeAttr('data-href');
    });
});