import { spinner, mostrarTabla } from './funciones.js';
import { getApi, basePath } from './api/funcionesApi.js';
import { datos,tablasPagina } from './variables.js';

(function () {

    tablasPagina.forEach(tablaPagina => {
        const nombreTabla = tablaPagina.getAttribute('name');
        spinner(tablaPagina);
        obtenerDatos(nombreTabla, 5)
    })
    return;

    async function obtenerDatos(nombreTabla, limite = '') {
        const url = new URL(`${basePath}/api/index.php/${nombreTabla}`, window.location.origin);
        if (limite) {
            url.searchParams.set('limite', limite);
        }

        datos.value = await getApi(url);
        mostrarTabla(nombreTabla, false, null);
    }

})();