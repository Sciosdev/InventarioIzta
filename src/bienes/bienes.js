
import { spinner, crearFormulario, mostrarTabla, crearScrollableModal, mostrarAlerta, consultarSelect, eventoFiltro, guardar, eliminar, llenarFormulario, abrirModalConsultaBienes, llenarSelect, validarVarios } from '../funciones.js';
import { getApiFiltros } from '../api/funcionesApi.js';
import { filtros, datos, divTabla, nombreTabla, btnConsultar, btnLimpiar, btnConsultarVarios, btnNuevo, btnEditar, btnEliminar, inputsFiltros, selects, dato_Editar } from '../variables.js';

(function () {

    //Llena los select de filtros
    consultarSelect(selects);

    //Cuanodo cambia el valor del input 
    inputsFiltros.forEach(inputFiltro => {
        //Evento change a los filtros 
        eventoFiltro(inputFiltro);
    });
    
    //Eventos Botones
    btnConsultar.addEventListener('click', async function () {
        spinner(divTabla);

        datos.value = await getApiFiltros(nombreTabla, filtros.value);
           //  Depuración: mira qué trae datos.value
        console.log('datos.value tras getApiFiltros:', datos.value);

        sessionStorage.setItem('bienes_imprimir', JSON.stringify(datos.value));

        console.log('✅ sessionStorage.bienes_imprimir:', JSON.parse(sessionStorage.getItem('bienes_imprimir')));

        mostrarTabla(nombreTabla, true, null);

    });

    btnLimpiar.addEventListener('click', function () {
        document.querySelector('.filtros').reset();
        filtros.value = {}
    });

    btnConsultarVarios.addEventListener('click', function () {
        abrirModalConsultaBienes();
    });

    btnNuevo.addEventListener('click', function () {
        // Contenido para el modal
        const formulario = crearFormulario('bienes');
        //Mostramos el modal
        crearScrollableModal('scrollable-modal', 'Crear', formulario.outerHTML);
        //Llenamos los select del modal 
        const inputsFormulario = document.querySelectorAll('.formulario select:not(#tipo_inventario):not(#transferido)');
        llenarSelect(inputsFormulario);

        guardar();
    });

    btnEditar.addEventListener('click', function () {

        if (dato_Editar.size === 0 ) {
            mostrarAlerta('warning', 'Alerta', 'Por favor, selecciona un registro antes de continuar');
            return;
        }

        const formulario = dato_Editar.size !== 1
        ? crearFormulario('editarBienes')
        : crearFormulario(nombreTabla, dato_Editar.values().next().value);

        crearScrollableModal('scrollable-modal', 'Editar Bien(es)', formulario.outerHTML);

        const inputsFormulario = dato_Editar.size !== 1
        ? document.querySelectorAll('.formulario select#areas, .formulario select#responsables')
        : document.querySelectorAll('.formulario select:not(#tipo_inventario):not(#transferido)');

        llenarSelect(inputsFormulario);

        if (dato_Editar.size === 1) {
            llenarFormulario(dato_Editar.values().next().value);
            guardar(); 
        }else if(dato_Editar.size > 1){
            validarVarios();
        }
    });

    btnEliminar.addEventListener('click', async function () {

        if (dato_Editar.size !== 1) {
            const mensaje = dato_Editar.size === 0 
            ? 'Por favor, selecciona un registro antes de continuar'
            : 'No es posible eliminar más de un registro a la vez.';

            mostrarAlerta('warning', 'Alerta', mensaje);
            return;
        }

        const texto = document.createElement('P');
        texto.classList.add('text-center', 'fs-4');
        texto.textContent = '¿Estás seguro de que deseas eliminar este registro?'
        crearScrollableModal('scrollable-modal', 'Eliminar', texto.outerHTML, 'confirmar');

        const btnConfirmar = document.querySelector('.confirmar');
        
        btnConfirmar.addEventListener('click', eliminar);
    });


})();