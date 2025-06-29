import { spinner, mostrarTabla } from './funciones.js';
import { getApi } from './api/funcionesApi.js';
import { datos,tablasPagina } from './variables.js';

(function () {

    tablasPagina.forEach(tablaPagina => {
        const nombreTabla = tablaPagina.getAttribute('name');
        spinner(tablaPagina);
        obtenerDatos(nombreTabla, 5)
    })
    return;

    async function obtenerDatos(nombreTabla, limite = '') {
        const baseUrl = `${window.location.origin}/api/index.php/${nombreTabla}`;
        const url = limite ? `${baseUrl}?limite=${limite}` : baseUrl;
        datos.value = await getApi(url);        
        mostrarTabla(nombreTabla, false, null);
    }

})();