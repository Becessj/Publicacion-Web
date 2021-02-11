<?php
    // Constantes de la aplicación

    // Este archivo almacena valores constantes que son
    // utilizados por el sistema de forma recurrente
    // Clave del sistema
    define('SYSTEM_KEY', 'a52f83737b40414799d7983894c233d4');

    // Versión del sistema
    define('SYSTEM_VERSION', '2.28.1712.2211');

    // Clave pública de reCAPTCHA
    //define('CAPTCHA_PUBLIC_KEY', '6LcJDg0TAAAAAKp_Nw8y0So5zeAkncdqZZtO4ys2');
    define('CAPTCHA_PUBLIC_KEY', '6LdphsAUAAAAAIKyReShykVBg2NWPxtOFfRAFlgH');

    
    // Clave privada de reCAPTCHA
    //define('CAPTCHA_PRIVATE_KEY', '6LcJDg0TAAAAAEkky9njL6Tp5BjdZCSP-BVP6QWN');
    define('CAPTCHA_PRIVATE_KEY', '6LdphsAUAAAAAJbOdkLFD25W4d_62iSYXTBcMiaV');

    // Tamaño máximo permitido de archivo para cargas
    define('UPLOAD_MAX_FILESIZE', 4194304);

    // Número máximo permitido de archivos a cargar
    define('MAX_FILE_UPLOADS', 10);

    // Patrón de indentación
    define('INDENT_PATTERN', '    ');

    // URL base
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST']);

    // URL de inicio
    define('HOME_URL', BASE_URL . '/publicacion/home');

    // Mensajes del sistema
    define('LOGIN_FAILED', 'El nombre de usuario y/o la contraseña no son válidos.');
    define('NOT_LOGGED_IN', 'Debe iniciar sesión para realizar esta operación.');
    define('ALREADY_LOGGED_IN', 'Usted ya ha iniciado sesión.');
    define('PAGE_NOT_FOUND', 'No se ha podido encontrar el recurso asociado a la categoría seleccionada.');
    define('USERNAME_NOT_FOUND', 'El nombre de usuario que ingresó no está registrado en el sistema.');
    define('CONFIRM_MAIL_SENT', 'Se le ha enviado un mensaje de correo electrónico de confirmación.');
    define('CONFIRM_MAIL_FAILED', 'Se ha producido un error inesperado al envíar la confirmación.');
    define('NEW_PASSWORD_MAIL_FAILED', 'Se ha producido un error inesperado al envíar la nueva contraseña.');
    define('NEW_PASSWORD_SENT', 'Se le ha enviado su nueva contraseña por correo electrónico.');
    define('LINK_HAS_EXPIRED', 'El enlace ha expirado.');
    define('INVALID_LINK', 'El enlace no es valido.');
    define('RESET_PASSWORD_SUCCESS', 'Se ha generado una nueva contraseña para la cuenta de usuario.');
    define('RESET_PASSWORD_FAILED', 'Se ha producido un error inesperado al restablecer la contraseña.');
    define('DENIED_ACCESS', 'Acceso denegado, no tiene permiso para realizar esta operación.');
    define('REGISTER_SUCCESS', 'Se ha creado un nuevo registro exitosamente.');
    define('REGISTER_FAILED', 'Se ha producido un error inesperado y no se pudo completar el registro.');
    define('PASSWORD_MAIL_FAILED', 'No se pudo enviar la contraseña de la nueva cuenta de usuario.');
    define('EDIT_SUCCESS', 'Se han guardado los cambios realizados.');
    define('EDIT_FAILED', 'Se ha producido un error inesperado y no se pudieron guardar los cambios.');
    define('DELETE_SUCCESS', 'Se ha eliminado un registro.');
    define('DELETE_FAILED', 'Se ha producido un error inesperado y no se pudo eliminar el registro.');
    define('DELETE_MASS_FAILED', 'Se ha producido un error inesperado y no se pudieron eliminar los registros seleccionados.');
    define('DELETE_MASS_PARTIAL_SUCCESS', 'Algunos de los elementos seleccionados no pudieron ser eliminados.');
    define('DELETE_MASS_SUCCESS', 'Se eliminaron los elementos seleccionados.');
    define('REQUEST_AUTHENTICATION_FAILED', 'No se ha podido determinar la autenticidad de su solicitud.');
    define('INVALID_REQUEST', 'La solicitud no es válida.');
?>
