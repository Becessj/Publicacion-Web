/// <reference path="jquery-2.1.0-vsdoc.js" />

// Captura el evento desencadenado tras cargar completamente la página
$(window).load(function () {
    // Agrega la dirección de la escuela profesional en el pie de la página
    var nombreEscuela = $('head').children('title').text().substring(23, $('head').children('title').text().length - 9);
    var ubicaion = '';
    var distrito = '';
    var provincia = '';
    var region = '';

    switch (nombreEscuela) {
        case 'Educación: Filial Canas':
            ubicaion = 'Av. Tupac Amaru S/N';
            distrito = 'Yanaoca';
            provincia = 'Canas';
            region = 'Cusco';
            break;
        case 'Ingeniería Agroindustrial: Filial Sicuani':
            ubicaion = 'Av. Arequipa 150';
            distrito = 'Sicuani';
            provincia = 'Canchis';
            region = 'Cusco';
            break;
        case 'Medicina Veterinaria: Filial Sicuani':
            ubicaion = 'Jr. Junín 525';
            distrito = 'Maranganí';
            provincia = 'Canchis';
            region = 'Cusco';
            break;
        case 'Medicina Veterinaria: Filial Espinar':
            ubicaion = 'Campo Ferial Versalles';
            distrito = 'Yauri';
            provincia = 'Espinar';
            region = 'Cusco';
            break;
        case 'Educación: Filial Espinar':
            ubicaion = 'Barrio Magisterial S/N';
            distrito = 'Yauri';
            provincia = 'Espinar';
            region = 'Cusco';
            break;
        case 'Ingeniería Agropecuaria: Filial Santo Tomás':
            ubicaion = 'Acopampa S/N';
            distrito = 'Santo Tomás';
            provincia = 'Chumbivilcas';
            region = 'Cusco';
            break;
        case 'Ingeniería Agropecuaria: Filial Andahuaylas':
            ubicaion = 'Jr. Girasoles S/N';
            distrito = 'Andahuaylas';
            provincia = 'Andahuaylas';
            region = 'Apurímac';
            break;
        case 'Obstetricia: Filial Andahuaylas':
            ubicaion = 'Jr. Girasoles S/N';
            distrito = 'Andahuaylas';
            provincia = 'Andahuaylas';
            region = 'Apurímac';
            break;
        case 'Ingeniería Forestal: Filial Puerto Maldonado':
            ubicaion = 'Jr. San Martín 451';
            distrito = 'Tambopata';
            provincia = 'Tambopata';
            region = 'Madre de Dios';
            break;
        case 'Ingeniería de Industrias Alimentarias: Filial Quillabamba':
            ubicaion = 'Jr. Kumpirushiato E-5';
            distrito = 'Quillabamba';
            provincia = 'La Convesnción';
            region = 'Cusco';
            break;
        case 'Agronomía Tropical: Filial Quillabamba':
            ubicaion = 'Jr. Kumpirushiato E-5';
            distrito = 'Quillabamba';
            provincia = 'La Convesnción';
            region = 'Cusco';
            break;
        case 'Ecoturismo: Filial Quillabamba':
            ubicaion = 'Jr. Kumpirushiato E-5';
            distrito = 'Quillabamba';
            provincia = 'La Convesnción';
            region = 'Cusco';
            break;
        default:
            ubicaion = 'Av. de la Cultura 733';
            distrito = 'Cusco';
            provincia = 'Cusco';
            region = 'Cusco';
    }

    $('#dev-info').before(
        $('<address />').css({
            'text-align': 'center',
            'color': '#777'
        }).append(
            $('<strong />').text('Universidad Nacional de San Antonio Abad del Cusco')
        ).append(
            $('<br />')
        ).append(
            $('<span />').text(ubicaion + ' - ' + distrito + ', ' + provincia + ', ' + region + ', Perú')
        )
    );

    // Desvanece la pantalla de carga
    $('.loader-wrapper').fadeOut('slow', function () {
        $(this).remove();
    });
});

// Captura el evento desencadenado al cargar el DOM del documento
$(document).ready(function () {
    // Hotfix para revelar las secciones según la posición actual del documento
    $(this).scrollTop(0);

    // Declara una función anónima que ejecuta los cambios en la barra de navegación al desplazarse por la página
    var highlight_on_scroll = function () {
        var $resenaHistorica = $('[data-anchor="#resena-historica"]').first().closest('li');
        var $nosotros = $('[data-anchor="#nosotros"]').first().closest('li');
        var $planEstudios = $('[data-anchor="#plan-estudios"]').first().closest('li');
        var $docentes = $('[data-anchor="#docentes"]').first().closest('li');
        var $noticias = $('[data-anchor="#noticias"]').first().closest('li');
        var $galeria = $('[data-anchor="#galeria"]').first().closest('li');
        var $descargas = $('[data-anchor="#descargas"]').first().closest('li');
        var $contacto = $('[data-anchor="#contacto"]').first().closest('li');

        if ($(this).scrollTop() < $('#resena-historica').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $resenaHistorica.removeClass('selected');
        }
        else if ($(this).scrollTop() < $('#nosotros').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $resenaHistorica.siblings().not('.open').removeClass('selected');
            $resenaHistorica.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#plan-estudios').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $nosotros.siblings().not('.open').removeClass('selected');
            $nosotros.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#docentes').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $planEstudios.siblings().not('.open').removeClass('selected');
            $planEstudios.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#noticias').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $docentes.siblings().not('.open').removeClass('selected');
            $docentes.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#galeria').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $noticias.siblings().not('.open').removeClass('selected');
            $noticias.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#descargas').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $galeria.siblings().not('.open').removeClass('selected');
            $galeria.addClass('selected');
        }
        else if ($(this).scrollTop() < $('#contacto').offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)) {
            $descargas.siblings().not('.open').removeClass('selected');
            $descargas.addClass('selected');
        }
        else {
            $contacto.siblings().not('.open').removeClass('selected');
            $contacto.addClass('selected');
        }

        $('.section').each(function () {
            if ($(window).height() * 0.67 + $(document).scrollTop() >= $(this).offset().top) {
                $(this).children('.container').addClass('displayed');
            }
        });
    };

    // Captura el evento desencadenado al usar un enlace de anclaje
    $('[data-anchor]').click(function (e) {
        // Interrumpe la acción por defecto
        e.preventDefault();

        // Almacena el objetivo del ancla
        var target = $(this).data('anchor');
        // Desactiva temporalmente el capturador del evento "scroll"
        $(window).off('scroll', highlight_on_scroll);
        // Ejecuta un desplazamiento con efecto hasta la sección apuntada
        $('html').add('body').animate({
            scrollTop: $(target).offset().top - (window.innerWidth < 768 ? (($(document).scrollTop() < $('#header').height() && $('#navbar-collapse-cp').hasClass('in')) ? 369 : 50) : 80)
        }, 1000, 'easeInOutExpo', function () {
            // Actualiza el elemento activo de la barra de navegación al desplazarse por la página
            $(window).on('scroll', highlight_on_scroll);

            // Muestra todas las secciones si se ha llegado al final de la página
            if ($(document).height() - $(window).height() == $(document).scrollTop()) {
                $('.section').children('.container').addClass('displayed');
            }
            else {
                $('.section').each(function () {
                    if ($(window).height() * 0.67 + $(document).scrollTop() >= $(this).offset().top) {
                        $(this).children('.container').addClass('displayed');
                    }
                });
            }
        });
        // Resalta directamente al enlace utilizado como el elemento activo
        $nav_item = $('[data-anchor="' + $(this).data('anchor') + '"]').first().closest('li');
        $nav_item.siblings().not('.open').removeClass('selected');
        $nav_item.addClass('selected');

        if (window.innerWidth < 768) {
            $('#navbar-collapse-cp').collapse('hide');
        }
    });

    // Actualiza el elemento activo de la barra de navegación al desplazarse por la página
    $(window).on('scroll', highlight_on_scroll);

    // Captura el evento desencadenado al redimensionar el área del navegador
    $(window).resize(function () {
        if ($(this)[0].innerWidth > 768) {
            $('.navbar-collapse').removeClass('in');
        }
    });

    // Aplica animaciones a los menúes desplegables
    $('.dropdown').on('shown.bs.dropdown', function () {
        $(this).children('.dropdown-menu').hide().fadeIn(200);
    });

    $('.dropdown').on('hide.bs.dropdown', function () {
        if ($(window).width() > 763) {
            $(this).children('.dropdown-menu').fadeOut(100);
        }
        else {
            $(this).children('.dropdown-menu').hide();
        }
    });

    // Captura el evento desencadenado al desplazarse
    $(document).scroll(function () {
        // Ubicación del borde inferior del encabezado
        var pos = $('#header').height();
        // Posisión vertical de la barra de desplazamiento para el documento
        var scroll = $(this).scrollTop();

        if (scroll >= pos + 1) {
            $('.navbar-chrome').addClass('navbar-fixed-top');
            $('#header').addClass('top-placeholder');
        }
        else {
            $('.navbar-chrome').removeClass('navbar-fixed-top');
            $('#header').removeClass('top-placeholder');
        }
    });

    // Captura el evento desencadenado al hacer clic sobre el enlace de una publicación
    $('.link-publishing').click(function (e) {
        // Interrumpe la acción por defecto
        e.preventDefault();

        // Muestra el cuadro de diálogo Noticia
        $('#publicacion').modal('show');

        // Recupera el Id de la publicación correspondiente
        var id = $(this).data('target');
        // Recuper el indice de la publicación
        var index = indexOfPropertyValue(lista_publicaciones, 'Id', id)

        // Prepara el cargador
        $loader = $('<div/>', { 'class': 'loader-alt' });
        var i = 0;

        do {
            $loader.append($('<div/>', { 'class': 'circle' }));
            i++;
        } while (i < 5);

        // Limpia el contenedor de la publicación
        $('#publicacion').find('.publishing-container').empty().hide();
        // Muestra el cargador
        $('#publicacion').find('.modal-body').append($loader);

        // Carga la imagen de portada
        var targetImage = new Image();
        targetImage.src = lista_publicaciones[index]['URL'];
        targetImage.onload = function () {
            $loader.fadeOut(function () {
                $loader.remove();
                $('#publicacion').find('.publishing-container').append($('<img/>', {
                    'class': 'img-original',
                    'src': targetImage.src
                }));
                $('#publicacion').find('.publishing-container').append($('<h3>', { 'class': 'publishing-title text-chrome' }));
                $('#publicacion').find('.publishing-title').text(lista_publicaciones[index]['Titulo']);
                $('#publicacion').find('.publishing-container').append($('<p/>', { 'class': 'publishing-datetime text-muted' }));
                $('#publicacion').find('.publishing-datetime').text(lista_publicaciones[index]['FechaHoraPublicacion']);
                $('#publicacion').find('.publishing-container').append($('<hr/>'));
                $('#publicacion').find('.publishing-container').append($('<div/>', { 'class': 'publishing-content text-justify' }));
                $('#publicacion').find('.publishing-content').html(lista_publicaciones[index]['Contenido']);
                $('#publicacion').find('.publishing-container').fadeIn();
            });
        }
    });

    // Abre la Galería de imágenes
    $('#btn-galeria').click(function (e) {
        // Interrumpe la acción por defecto
        e.preventDefault();

        // Abre el navegador de imágenes
        $(this).next('.hidden').children('a').eq(0).click();
    });

    // Captura el evento desencadenado al hacer clic sobre un elemento de la lista de documentos
    $('.file-row').click(function () {
        window.open($(this).data('href'), '_blank');
    });

    // Renderiza los cuadros de información de herramienta
    $('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
    });

    // Personaliza las opciones del Lightbox
    lightbox.option({
        albumLabel: 'Imagen %1 de %2',
        wrapAround: true
    });

    // Renderiza los navegadores de pestañas adaptables
    $('.tabbed-block-responsive').find('.nav-tabs').tabCollapse({
        accordionClass: 'visible-sm visible-xs'
    });

    $('.tabbed-block-responsive').on('shown-accordion.bs.tabcollapse', function () {
        $('.panel-heading a').on('click', function (e) {
            if ($(this).parents('.panel').children('.panel-collapse').hasClass('in')) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
    });

    // Inicializa el recortador de texto
    $('.nombre-docente').dotdotdot({
        elipsis: '...',
        wrap: 'word',
        fallBackToLetter: true,
        after: null,
        watch: true,
        height: 20,
        tolerance: 0,
        lastCharacter: {
            remove: [' ', '.', ',', ';', '!', '?'],
            noElipsis: []
        }
    });

    $('.grado-academico-docente').dotdotdot({
        elipsis: '...',
        wrap: 'word',
        fallBackToLetter: true,
        after: null,
        watch: true,
        height: 40,
        tolerance: 0,
        lastCharacter: {
            remove: [' ', '.', ',', ';', '!', '?'],
            noElipsis: []
        }
    });

    $('.link-title').dotdotdot({
        elipsis: '...',
        wrap: 'word',
        fallBackToLetter: true,
        after: null,
        watch: true,
        height: 66,
        tolerance: 0,
        lastCharacter: {
            remove: [' ', '.', ',', ';', '!', '?'],
            notElipsis: []
        }
    });

    $('.thumbnail-title').dotdotdot({
        elipsis: '...',
        wrap: 'word',
        fallBackToLetter: true,
        after: null,
        watch: true,
        height: 52,
        tolerance: 0,
        lastCharacter: {
            remove: [' ', '.', ',', ';', '!', '?'],
            noElipsis: []
        }
    });

    $('.thumbnail-summary').dotdotdot({
        elipsis: '...',
        wrap: 'word',
        fallBackToLetter: true,
        after: null,
        watch: true,
        height: 100,
        tolerance: 0,
        lastCharacter: {
            remove: [' ', '.', ',', ';', '!', '?'],
            noElipsis: []
        }
    });

    // Autposisiona la pagina en la sección Reseña histórica
    if (document.location.hash == '#resena-historica') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#resena-historica"]').click();
    }

    // Autposisiona la pagina en la sección Nosotros
    if (document.location.hash == '#nosotros') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#nosotros"]').click();
    }

    // Autposisiona la pagina en la sección Plan de estudios
    if (document.location.hash == '#plan-estudios') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#plan-estudios"]').click();
    }

    // Autposisiona la pagina en la sección Docentes
    if (document.location.hash == '#docentes') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#docentes"]').click();
    }

    // Autposisiona la pagina en la sección Noticias
    if (document.location.hash == '#noticias') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#noticias"]').click();
    }

    // Autposisiona la pagina en la sección Galería
    if (document.location.hash == '#galeria') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#galeria"]').click();
    }

    // Autposisiona la pagina en la sección Descargas
    if (document.location.hash == '#descargas') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#descargas"]').click();
    }

    // Autposisiona la pagina en la sección Contacto
    if (document.location.hash == '#contacto') {
        history.replaceState('', document.title, window.location.pathname);
        $('[data-anchor="#contacto"]').click();
    }
});