function stringStartsWith (str, search) {
    // Determina si la cadena de entrada empieza por el término de búsqueda
    return str.substr(0, search.length) == search;
}

function stringEndsWith (str, search) {
    return str.substr(-search.length) == search;
}

function matchWithWildcards(str, pathern) {
    return new RegExp('^' + pathern.replace('*', '.*') + '$').test(str);
}

function indexOfPropertyValue (array, prop, value) {
    // Establece los valores iniciales
    var found = false;
    var i = 0;

    // Recorre el arreglo hasta encontrar el objeto
    do {
        if (array[i][prop] === value) {
            found = true;
        }
        else {
            i++;
        }
    } while (i < array.length && !found);

    // Si el objeto fue encontrado, devuelve su posisión
    return found ? i : -1;
}

function prevWithBucle (index, array) {
    // Si el índice es distinto de 0 devolveá el anterior, de lo contrario devolverá el último
    return index != 0 ? index - 1 : array.length - 1;
}

function nextWithBucle (index, array) {
    // Si el distinto drl último devolverá el siguiente, de lo contrario devolverá 0
    return index != array.length - 1 ? index + 1 : 0;
}

function formattedFileSize (size) {
    // Define las unidades de almacenamiento
    var units = Array('byte', 'KB', 'MB', 'GB', 'TB', 'PB');
    // Calcula itertivamente el multiplo de unidad adecuado a la magnitud de entrada
    for (var i = 0; size >= 1024 && i < units.length - 1; size /= 1024, i++);
    // Devuelve la magnitud equivalente usando la unidad de medida calculada
    return parseFloat(parseFloat(size).toFixed(2)).toString() + ' ' + units[i] + (size != 1 && i == 0 ? 's' : '');
}

function enableSubmit() {
    // Habilita el botón de envío
    $('[type="submit"]').prop('disabled', false);
    // Hace una validadción para determinar si el botón permanecerá habilitado
    $('form').validator('validate');
}

function disableSubmit() {
    // Deshabilita el botón de envío
    $('[type="submit"]').prop('disabled', true);
}