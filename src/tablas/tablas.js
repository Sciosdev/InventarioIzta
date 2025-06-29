import { crearFormulario, crearScrollableModal, mostrarAlerta, consultarRegistros, guardar, eliminar, resetearFilaSeleccionada, mostrarContraseña } from '../funciones.js';
import { nombreTabla, datos, btnNuevo, btnEditar, btnEliminar, btnConsultar, datoEditar, dato_Editar } from '../variables.js';

(function () {

    consultarRegistros();

    //Boton para nuevo
    btnNuevo.addEventListener('click', function () {
        // Contenido para el modal
        const formulario = crearFormulario(nombreTabla);

        //Mostramos el modal
        crearScrollableModal('scrollable-modal', 'Crear', formulario.outerHTML);

        const filaSeleccionada = document.querySelector('tbody .table-active');

        if (filaSeleccionada) {
            resetearFilaSeleccionada(filaSeleccionada);
        }

        guardar();
    });

    //Boton para editar
    btnEditar.addEventListener('click', async function () {

        console.log(dato_Editar.size);
        
        if (dato_Editar.size !== 1) {
            const mensaje = dato_Editar.size === 0 
            ? 'Por favor, selecciona un registro antes de continuar'
            : 'Solo puedes editar un registro a la vez';

            mostrarAlerta('warning', 'Alerta', mensaje);
            return;
        }
       
        const dato = dato_Editar.values().next().value;

        const formulario = crearFormulario(nombreTabla, dato);

        crearScrollableModal('scrollable-modal', 'Editar', formulario.outerHTML);

        if (nombreTabla === 'usuarios') {
            mostrarContraseña();
        }

        guardar();
    });

    //Boton para eliminar
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


    btnConsultar.addEventListener('click', consultarRegistros);

})();