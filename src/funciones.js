import { getApi, getApiFiltros, postApi, deleteApi, putApi } from './api/funcionesApi.js';
import { modalActivo, tablas, filtros, validacionesFormularios, nombreTabla, datos, divTabla, bienesModal, datosSelect, btnConsultar, filasSeleccionadas, dato_Editar } from './variables.js';

//LLEENA EL OBJETO FILTROS PARA DESPUES CONSULTAR
export function eventoFiltro(input) {
    //llenar el objeto filtros con los valores 
    input.addEventListener('change', function () {
        //Llenando objeto de filtros
        const filtroNombre = input.getAttribute('data-campo')
        filtros.value[filtroNombre] = input.value;
    });
}

//LIMPIA LOS REGISTROS PREVIOS DE UNA TABLA
export function limpiaTabla(elemento) {
    const tabla = elemento.querySelector('table');
    while (tabla.firstChild) {
        tabla.removeChild(tabla.firstChild);
    }
}

//LIMPIA EL HTML PREVIO DE UN ELEMENTO
export function limpiaHTML(elemento) {
    while (elemento.firstChild) {
        elemento.removeChild(elemento.firstChild);
    }
}

//MUESTRA LAS TABLAS CON AL INFORMACION DE LA BD
export function mostrarTabla(nombreDeTabla, paginacion = true, datosMostrar) {

    datos.value = datosMostrar ? datosMostrar : datos.value;

    const tabla = document.querySelector(`div[name="${nombreDeTabla}"] table`);


    limpiaTabla(tabla.parentElement);
    eliminarSpiner();

    //Consguimos las columnas del objeto tablas
    const columnas = tablas[nombreDeTabla].columnas;

    //Crear el encabezado
    const thead = document.createElement('THEAD')
    const headerRow = document.createElement('TR');
    headerRow.classList.add('fs-6')

    //Iteramos por cada columna
    columnas.forEach(columna => {
        //Por cada columna creamos un th
        const th = document.createElement('TH');
        th.scope = 'col';
        th.textContent = columna.field;
        headerRow.appendChild(th);
    });

    thead.appendChild(headerRow);

    //Creamos el body
    const tbody = document.createElement('TBODY');

    datos.value.forEach(dato => {
        //Creamos una fila por cada dato
        const bodyRow = document.createElement('TR');
        bodyRow.classList.add('fs-6', 'fila');

        bodyRow.setAttribute('data-id', dato.id);
        bodyRow.onclick = function () {
            seleccionandoFila(bodyRow, dato);
        }

        //Agregando valores a cada celda
        columnas.forEach(columna => {
            const cell = document.createElement('TD');

            //Cuando sea la tabla de usuarios se ejecutara este codigo
            if (columna.field === 'Estatus') {

                const boton = document.createElement('BUTTON');
                boton.setAttribute('data-usuario-id', dato.id);
                boton.classList.add('btn', dato[columna.campo] === 'activo' ? 'btn-success' : 'btn-danger', 'px-2', 'py-0', 'rounded-3', 'fs-6', 'text-capitalize');
                boton.textContent = dato[columna.campo];
                boton.onclick = function (e) {
                    e.stopPropagation();
                    cambiandoEstatus({ ...dato });
                }
                cell.appendChild(boton);

            } else {
                cell.textContent = dato[columna.campo];
            }

            bodyRow.appendChild(cell);
        });
        tbody.appendChild(bodyRow)
    });

    tabla.appendChild(thead); // Agrega el <thead> a la tabla
    tabla.appendChild(tbody); // Agrega el <tbody> a la tabla

    //Agrega la paginacion
    if (paginacion) {
        $(document).ready(function () {
            $('#tabla').DataTable({
                destroy: true,
                searching: true,    // Activa/desactiva la barra de búsqueda
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100], // Opciones para el menú de cantidad de elementos
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json" // Traducción al español
                }
            });
        });
    }
}

//RETORNA EL FORMULARIO QUE NECESITEMOS
export function crearFormulario(tabla, dato = []) {
    switch (tabla) {
        case 'bienes':
            return formularioBienes();
        case 'tipos':
            return formularioTipos(dato);
        case 'edificios':
            return formularioEdificios(dato);
        case 'areas':
            return formularioAreas(dato);
        case 'responsables':
            return formularioResponsables(dato);
        case 'usuarios':
            return formularioUsuarios(dato);
        case 'editarBienes':
            return formularioEditarBienes();
        default:
            console.error('Tabla no reconocida:', tabla);
    }
}

//MUESTRA LOS ERRORES CUANDO SE ENVIA UN FORMULARIO
export function mostrarErrores(mensajes, tipo, referencia) {

    limpiarAlertas();
    const divAlertas = document.createElement('DIV');
    divAlertas.classList.add('row', 'p-1', 'div-alertas');

    mensajes.forEach(mensaje => {
        const divCol = document.createElement('DIV');
        divCol.classList.add('col-12', mensajes.length < 5 ? 'col-sm-12' : 'col-sm-6');
        const divAlerta = document.createElement('DIV');
        divAlerta.textContent = mensaje;
        divAlerta.classList.add('alert', 'ext-uppercase', 'fs-6', `alert-${tipo}`,);
        divCol.appendChild(divAlerta)
        divAlertas.appendChild(divCol);
    })

    referencia.parentElement.insertBefore(divAlertas, referencia);

}

//LIMPIA LOS ERRORES PREVIOS DE LOS FORMULARIOS
function limpiarAlertas() {
    const alertaPrevia = document.querySelector('.div-alertas');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }
}

//MUESTRA UN MODAL DE ALERTA CUANDO SEA CREAR, ELIMINA O EDITA UN REGISTRO O SI HAY UN ERROR.
export function mostrarAlerta(tipo, titulo, mensaje) {

    if (tipo === 'success') {
        cerraModal();
    }


    // Crear la estructura básica del modal
    const modal = document.createElement('div');
    modal.classList.add('modal', 'fade');
    modal.tabIndex = -1;
    modal.setAttribute('aria-hidden', 'true');  // Inicialmente oculto para tecnologías asistivas

    // Crear el contenido del modal
    modal.innerHTML = `
    <div class="modal-dialog modal-sm">
        <div class="modal-content ${tipo === 'success' ? 'bg-success' : tipo === 'danger' ? 'bg-danger' : tipo === 'warning' ? 'bg-warning' : ''}">
            <div class="modal-body p-4">
                <div class="text-center">
                    <i class="ri-${tipo === 'success' ? 'check-line' : tipo === 'warning' ? 'alert-line' : tipo === 'danger' ? 'close-circle-line' : ''} h1 ${tipo === 'success' ? 'text-light' : tipo === 'warning' ? 'text-warning' : tipo === 'danger' ? 'text-light' : ''}"></i>
                    <h4 class="mt-2 text-white">${titulo}</h4> <!-- Color blanco -->
                    <p class="mt-3 text-white">${mensaje}</p> <!-- Color blanco -->
                    <button 
                        type="button" 
                        class="btn btn-light my-2" 
                        ${tipo === 'danger' ? 'id="retryButton"' : ''} 
                    >
                        ${tipo === 'danger' ? 'Reintentar' : 'Aceptar'}
                    </button>
                </div>
            </div>
        </div>
    </div>
`;

    // Agregar el modal al body
    document.body.appendChild(modal);

    // Mostrar el modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();

    // Agregar eventos de cierre personalizados al botón
    const btn = modal.querySelector('button');
    btn.addEventListener('click', () => {
        bootstrapModal.hide();
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });

    // Eliminar el modal después de que se cierre
    modal.addEventListener('hidden.bs.modal', () => {
        modal.remove();
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    });

}


//ABRE UN MODAL
export function crearScrollableModal(id, titulo, contenido, boton = 'guardar') {

    // Verificar si el modal ya existe
    const existingModal = document.getElementById(id);
    if (existingModal) {
        // Eliminar el modal existente del DOM
        existingModal.parentNode.removeChild(existingModal);
    }


    // Crear el modal
    const modalHTML = `
    <div class="modal fade" id="${id}" tabindex="-1" role="dialog" aria-labelledby="${id}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-4" id="${id}Label">${titulo}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ${contenido}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary text-capitalize ${boton}">${boton}</button>
                </div>
            </div>
        </div>
    </div>
`;

    // Insertar el modal en el contenedor
    document.getElementById('modalContainer').innerHTML = modalHTML;

    // Mostrar el modal
    const modalElement = document.getElementById(id);
    const modalInstance = new bootstrap.Modal(modalElement);
    // Agregar evento para eliminar modal del DOM después de cerrarlo
    modalElement.addEventListener('hidden.bs.modal', () => {
        modalElement.remove(); // eliminar el HTML del modal
    });

    modalInstance.show();
    modalActivo.value = modalInstance;
    modalInstance.hide();


}

//CIERRA EL MODAL CUANDO SE COMPLETO LA ACCION.
function cerraModal(tipo = 'success') {
    // Verificar si hay un modal activo y cerrarlo
    if (modalActivo.value && tipo === 'success') {
        modalActivo.value.hide();
        modalActivo.value = null;
        const modal = document.querySelector('.modal');
        modal.remove();
    }
}

//CREAR SPINNER
export function spinner(divTabla = divTabla) {
    const divSpinner = document.createElement('DIV');
    divSpinner.classList.add('d-flex', 'justify-content-center');
    const spinner = document.createElement('DIV');
    spinner.classList.add('spinner-border', 'spinner');
    spinner.rol = 'status';

    divSpinner.appendChild(spinner);
    divTabla.appendChild(divSpinner);
}
//ELIMINAR SPINNER
function eliminarSpiner() {
    const spinner = document.querySelector('.spinner');
    spinner.remove();
}

//FUNCIONES PARA LLENAR SELECTS
//LLENA LO SELECT DEL FORMULARIO DE FILTROS Y EL MODAL PARA CREAR O EDITAR UN BIEN.
export async function consultarSelect(selects) {
    for (const select of selects) {
        if (select.tagName === 'SELECT' && select.id !== 'tipo_inventario') {
            const idInput = select.id === 'autorizador' ? 'responsables' : select.id;
            const url = `${window.location.origin}/api/index.php/${idInput}`;
            const valoresFiltros = await getApi(url);
            datosSelect[select.id] = valoresFiltros;
        }
    }
    llenarSelect(selects);
}

export function llenarSelect(selects) {
    selects.forEach(select => {
        const nombreTabla = select.id;
        datosSelect[nombreTabla].forEach(datoSelect => {
            const option = document.createElement('OPTION');
            const filtroNombre = select.getAttribute('data-campo')
            option.textContent = datoSelect[filtroNombre];
            option.value = datoSelect.id;
            select.appendChild(option);
        })
    });

}
// FIN FUNCIONES PARA LLENAR SELECTS

//DA ESTILOS AL REGISTRO QUE QUEREMOS ELIMINAR O EDITAR
function seleccionandoFila(bodyRow, dato) {

    const id = dato.id;

    if (filasSeleccionadas.has(id)) {
        filasSeleccionadas.delete(id);
        dato_Editar.delete(id)
        bodyRow.classList.remove('table-active');

    } else {
        filasSeleccionadas.add(id);
        dato_Editar.set(id, dato)
        bodyRow.classList.add('table-active');
    }


    // else {
    //     resetearFilaSeleccionada(bodyRow);
    // }
}

export function resetearFilaSeleccionada(fila) {
    fila.classList.remove('table-active');
    dato_Editar.clear();
}

//FUNCIONES CREAR FORMULARIOS(RETORNA LOS FORMULARIOS)
function formularioBienes() {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'p-2');
    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <div class="col-md-6">
                <label class="form-label" for="num_inventario">Número Inventario</label>
                <input type="text" class="form-control fs-6 num_inventario" id="num_inventario" placeholder="Ejemplo: 554821" name="numero_inventario">
            </div>
            <div class="col-md-6">
                <label for="tipo_inventario" class="form-label">Tipo Inventario</label>
                <select class="form-select fs-6 tipo_inventario" id="tipo_inventario" name="tipo_inventario"  data-campo="tipo_inventario">
                    <option value="" selected>Seleccionar</option>
                    <option value="Unam">Unam</option>
                    <option value="Fesi">Fesi</option>
                    <option value="SinInv">Sin Inventario</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="tipos-bien" class="form-label">Tipo de Bien</label>
                <select class="form-select fs-6 tipos-bien" id="tipos" name="tipo_bien_id" data-campo="tipobien">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-md-12">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" class="form-control fs-6 descripcion" id="descripcion" name="descripcion" placeholder="Ejemplo: Laptop HP 15 pulgadas">
            </div>
            <div class="col-md-6">
                <label for="numero_serie" class="form-label">Numero serie</label>
                <input type="text" class="form-control fs-6 numero_serie" id="numero_serie" name="numero_serie" placeholder="Ejemplo: SN-2023-001">
            </div>
            <div class="col-md-6">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control fs-6 marca" id="marca" name="marca" placeholder="Ejemplo: HP">
            </div>
            <div class="col-md-6">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control fs-6 modelo" id="modelo" name="modelo" placeholder="Ejemplo: Pavilion 15">
            </div>
            <div class="col-md-6">
                <label for="autorizador" class="form-label">Autorizador</label>
                <select class="form-select fs-6 autorizador" id="responsables" name="autorizador" data-campo="nombre_responsable">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="responsables" class="form-label">Responsable</label>
                <select class="form-select fs-6 responsable_id" id="responsables" name="responsable_id" data-campo="nombre_responsable">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="areas" class="form-label">Unidad</label>
                <select class="form-select fs-6 area" id="areas" name="area_id" data-campo="nombre_area">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="edificios" class="form-label">Edificio</label>
                <select class="form-select fs-6 edificio" id="edificios" name="edificio_id" data-campo="nombreedif">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
             <div class="col-md-6">
                <label for="transferencia" class="form-label">Transferncia</label>
                <input type="text" class="form-control fs-6 filtro" id="transferencia" placeholder="Ejemplo: 1" name="transferencia" data-campo="transferencia">
            </div>
            <div class="col-md-12">
                <label for="ubicacion" class="form-label">Ubicacion</label>
                <input type="text" class="form-control fs-6 ubicacion" id="ubicacion" name="ubicacion" placeholder="Segundo piso, aula de informática">
            </div>  
        </div>

`;
    return formulario;
}

function formularioTipos(dato = {}) {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'p-2');
    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <div class="col-md-4">
                <label class="form-label" for="cvetpo">Clave</label>
                <input type="text" class="form-control fs-6 cvetpo" id="cvetpo" placeholder="Ejemplo: TB005" name="cvetpo" value="${dato.cvetpo ? dato.cvetpo : ''}">
            </div>
            <!--Nombre Tipo de Bien -->
            <div class="col-md-8">
                <label class="form-label" for="tipo-bien">Nombre</label>
                <input type="text" class="form-control fs-6 tipobien" id="tipo-bien" placeholder="Ejemplo: Escritorio" name="tipobien" value="${dato.tipobien ? dato.tipobien : ''}">
            </div> 
        </div>
`;
    return formulario;
}

function formularioEdificios(dato = {}) {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'p-2');

    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <!-- Clave del Edificio -->
            <div class="col-md-4">
                <label class="form-label" for="clave">Clave</label>
                <input 
                    type="text" 
                    class="form-control fs-6 clave" 
                    id="clave" 
                    name="cveedif" 
                    placeholder="Ejemplo: E003" 
                    value="${dato.cveedif || ''}">
            </div>

            <!-- Nombre del Edificio -->
            <div class="col-md-8">
                <label class="form-label" for="nombre_edificio">Nombre</label>
                <input 
                    type="text" 
                    class="form-control fs-6 nombre_edificio" 
                    id="nombre_edificio" 
                    name="nombreedif" 
                    placeholder="Ejemplo: Edificio de Gobierno" 
                    value="${dato.nombreedif || ''}">
            </div>
        </div>
    `;

    return formulario;
}

function formularioAreas(dato = {}) {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'p-2');

    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <!-- Clave del Área -->
            <div class="col-md-4">
                <label class="form-label" for="cve_area">Clave</label>
                <input 
                    type="text" 
                    class="form-control fs-6 cve_area" 
                    id="cve_area" 
                    name="cve_area" 
                    placeholder="Ejemplo: A005" 
                    value="${dato.cve_area || ''}">
            </div>

            <!-- Nombre del Área -->
            <div class="col-md-8">
                <label class="form-label" for="nombre_area">Nombre</label>
                <input 
                    type="text" 
                    class="form-control fs-6 nombre_area" 
                    id="nombre_area" 
                    name="nombre_area" 
                    placeholder="Ejemplo: Recursos Humanos" 
                    value="${dato.nombre_area || ''}">
            </div>
        </div>
    `;

    return formulario;
}

function formularioResponsables(dato = {}) {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'formulario-responsables', 'p-2');

    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <!-- Nombre del Responsable -->
            <div class="col-12">
                <label class="form-label" for="nombre_responsable">Nombre</label>
                <input 
                    type="text" 
                    class="form-control fs-6 nombre_responsable" 
                    id="nombre_responsable" 
                    name="nombre_responsable" 
                    placeholder="Ejemplo: Juan Pérez" 
                    value="${dato.nombre_responsable || ''}">
            </div>

            <!-- RFC -->
            <div class="col-12">
                <label class="form-label" for="rfc">RFC</label>
                <input 
                    type="text" 
                    class="form-control fs-6 rfc" 
                    id="rfc" 
                    name="rfc" 
                    placeholder="Ejemplo: PEJU850912HZ1" 
                    value="${dato.rfc || ''}">
            </div>

            <!-- Puesto -->
            <div class="col-12">
                <label class="form-label" for="puesto">Puesto</label>
                <input 
                    type="text" 
                    class="form-control fs-6 puesto" 
                    id="puesto" 
                    name="puesto" 
                    placeholder="Ejemplo: Coordinador Administrativo" 
                    value="${dato.puesto || ''}">
            </div>
        </div>
        <div id="alertas" class="mt-3"></div>
    `;

    return formulario;
}

function formularioUsuarios(dato = {}) {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'formulario-responsables', 'p-2');

    formulario.innerHTML = `
        <div class="row g-3 fs-6">
            <!-- Nombre del Usuario -->
            <div class="col-12">
                <label class="form-label" for="nombre">Nombre</label>
                <input 
                    type="text" 
                    class="form-control fs-6 nombre" 
                    id="nombre" 
                    name="nombre" 
                    placeholder="Ejemplo: Juan Pérez" 
                    value="${dato.nombre || ''}">
            </div>

            <!-- Numero de cuenta -->
            <div class="col-12">
                <label class="form-label" for="num_cuenta">Numero de trabajador</label>
                <input 
                    type="text" 
                    class="form-control fs-6 num_cuenta" 
                    id="num_cuenta" 
                    name="num_cuenta" 
                    placeholder="Ejemplo: 19256314" 
                    value="${dato.num_cuenta || ''}">
            </div>

            <!-- password -->
            <div class="col-12">
                <label for="email" class="form-label">Correo electronico</label> 
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control fs-6 email" 
                        placeholder="Ejemplo: inventariofesi@gmail.com"
                    >
            </div>
        </div>
       
    `;

    return formulario;
}

function formularioEditarBienes() {
    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'formulario-responsables', 'p-2');
    formulario.innerHTML = `
            <div class="col-md-12">
                <label for="areas" class="form-label">Unidad</label>
                <select class="form-select fs-6 area" id="areas" name="area_id" data-campo="nombre_area">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>

            <div class="col-md-12 mt-2">
                <label for="responsables" class="form-label">Responsable</label>
                <select class="form-select fs-6 responsable_id" id="responsables" name="responsable_id" data-campo="nombre_responsable">
                    <option value="" selected>Seleccionar</option>
                </select>
            </div>
            `;
    return formulario;
}
//FIN DE FORMULARIOS

//LLENAR FORMULARIO BIENES
export function llenarFormulario(dato) {
    const camposFormulario = document.querySelectorAll('.formulario select, .formulario input');
    camposFormulario.forEach(campoFormulario => {
        campoFormulario.value = dato[campoFormulario.name];
    });
}

//FUNCIONES PARA CONSULTAR LO BIENES DESDE EL MODAL
export function abrirModalConsultaBienes() {

    const formulario = document.createElement('FORM');
    formulario.classList.add('formulario', 'p-2');
    formulario.innerHTML = `
            <div class="row g-3 fs-6 contenidoModal">
                <div class="col-md-6">
                    <label class="form-label" for="num_inventario">Número Inventario</label>
                    <input type="text" class="form-control fs-6 num_inventario" id="num_inventarioModal" placeholder="Ejemplo: 554821" name="numero_inventario">
                </div>
                <div class="col-md-6 d-flex flex-column align-items-end justify-content-end">
                    <button type="button" class="btn btn-info text-capitalize consultarModal">Consultar</button>
                </div>
                <div class="col-md-6 d-flex divEtiquetas">
                </div>
            </div>
    `;

    //Mostramos el modal
    crearScrollableModal('scrollable-modal', 'Consultar', formulario.outerHTML, 'mostrar');

    //Evento al boton de consultar del formulario
    const btnConsultarModal = document.querySelector('.consultarModal');
    btnConsultarModal.addEventListener('click', function () {
        const numInventario = document.querySelector('#num_inventarioModal').value.trim();
        if (!numInventario) {
            mostrarErrores(['Por favor, ingresa el numero de inventario'], 'danger', document.querySelector('.formulario'));
            borrarErrores();
            return;
        }
        consultarBien(numInventario);
    });

    //Evento al boton de consultar del formulario
    const btnMostrar = document.querySelector('.mostrar');
    btnMostrar.addEventListener('click', function () {
        if (bienesModal.value.length === 0) {
            mostrarErrores(['Por favor, primero consulta un bien.'], 'danger', document.querySelector('.formulario'));
            borrarErrores();
            return;
        }
        datos.value = bienesModal.value;
        bienesModal.value = [];
        spinner(divTabla);
        mostrarTabla(nombreTabla, true, null);

        cerraModal();
    });
}

async function consultarBien(numInventario) {

    const objBien = {
        numero_inventario: numInventario
    }

    if (bienesModal.value.some(bien => bien.numero_inventario == numInventario)) {
        mostrarErrores(['El numero de inventario ya lo consultaste'], 'danger', document.querySelector('.formulario'));
        borrarErrores();
        return;
    }

    const dato = await getApiFiltros(nombreTabla, objBien);

    if (Object.keys(dato).length === 0) {
        mostrarErrores(['El bien no existe'], 'danger', document.querySelector('.formulario'));
        borrarErrores();
        return;
    }

    bienesModal.value = [...bienesModal.value, dato[0]];

    mostrarEtiqueta(numInventario);

    document.querySelector('#num_inventarioModal').value = '';

}

function mostrarEtiqueta(numInventario) {
    const divEtiquetas = document.querySelector('.divEtiquetas');

    const etiqueta = document.createElement('P');
    etiqueta.textContent = numInventario; // Espacio añadido después del texto

    // Agregar clases a la etiqueta
    etiqueta.classList.add('badge', 'badge-outline-success', 'fs-6', 'px-2', 'cursor-pointer', 'me-1');

    etiqueta.addEventListener('dblclick', function () {
        quitarEtiqueta(this);
    });

    // Agregar la etiqueta al contenedor
    divEtiquetas.appendChild(etiqueta);
}

function quitarEtiqueta(etiqueta) {
    const numInventario = etiqueta.textContent;

    bienesModal.value = bienesModal.value.filter(bien => bien.numero_inventario !== numInventario);

    etiqueta.remove();
}

function borrarErrores() {
    const alertaPrevia = document.querySelector('.alert');
    setTimeout(() => {
        alertaPrevia.remove();
    }, 3000);
}
//FIN DE FUNCIONES PARA EL MODAL

//VALIDA TODOS LOS FORMULARIOS.
export function validarFormulario(editar, nombreT) {

    const formulario = document.querySelector('.formulario');
    const formData = new FormData(formulario);

    // Lista de errores con mensajes asociados
    const validaciones = validacionesFormularios[nombreT];

    let alertas = [];
    let valores = {};

    // Validar campos del formulario
    for (let [key, value] of formData.entries()) {

        if (!value.trim()) {
            if (editar && key === 'password') {
                continue;
            }
            // Para todos los demás casos, validamos campos vacíos
            alertas = [...alertas, validaciones[key]];
        } else {
            valores[key] = value;
        }
    }
    // Mostrar alertas si hay errores
    if (alertas.length > 0) {
        mostrarErrores(alertas, 'danger', formulario);

        const modal = document.querySelector('.modal-body');
        if (modal) {
            modal.scrollTop = 0; // Llevar el scroll al inicio
        }
        return; // Formulario no válido
    }

    return valores; // Formulario válido
}

export function validarVarios() {
    const btnGuardar = document.querySelector('.guardar');
    btnGuardar.addEventListener('click', function () {

        let camposVacios = 0;
        const formulario = document.querySelector('.formulario');
        const formData = new FormData(formulario);

        for (let [key, value] of formData.entries()) {
            if (!value.trim()) {
                camposVacios += 1;
            }
        };
        if (camposVacios == 2) {
            mostrarErrores(['Selecciona una unidad o un responsable'], 'danger', formulario);
            return;
        }

        actualizarItems(formData);
    })
}

//FUNCIONES CRUD
export function guardar() {

    const btnGuardar = document.querySelector('.guardar');
    btnGuardar.addEventListener('click', function () {

        const editar = dato_Editar.size === 1;

        //Validamos el formulario
        const valores = validarFormulario(editar, nombreTabla);

        if (!valores) {
            return;
        }

        if (editar) {
            //Obtiene el id de la persona que edita el registro
            valores.modified_by = obtenerId();
            actualizar(valores);
        } else {
            //Obtiene el id de la persona que crea el registro
            valores.created_by = obtenerId();
            crear(valores);
        }
    })
}

async function crear(registro) {

    const url = `/api/index.php/${nombreTabla}`;

    const resultado = await postApi(url, registro);

    if (resultado.tipo === 'success') {
        const formulario = document.querySelector('.formulario');
        formulario.reset();
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        spinner(divTabla);
        datos.value = resultado.dato;
        mostrarTabla(nombreTabla, true, null);
        dato_Editar.clear();
    } else {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        return;
    }

}

async function actualizar(registro) {

    const iterator = dato_Editar.values();
    const unicoValor = iterator.next().value;
    const { id } = unicoValor
    registro.id = id;

    const url = `/api/index.php/${nombreTabla}`;
    const resultado = await putApi(url, registro);

    if (resultado.tipo === 'success') {
        const formulario = document.querySelector('.formulario');
        formulario.reset();

        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);

        datos.value = datos.value.map(dato => dato.id !== id ? dato : resultado.dato[0]);

        spinner(divTabla);
        mostrarTabla(nombreTabla, true, null);
        dato_Editar.clear();
    } else {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        return;
    }

}

export async function eliminar() {

    const iterator = dato_Editar.values();
    console.log(dato_Editar);
    const unicoValor = iterator.next().value;
    console.log(unicoValor);

    const { id } = unicoValor
    const objId = {
        id
    };

    const url = `/api/index.php/${nombreTabla}`;

    const resultado = await deleteApi(url, objId);

    if (resultado.tipo === 'success') {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);

        datos.value = datos.value.filter(dato => dato.id !== id);

        spinner(divTabla);
        mostrarTabla(nombreTabla, true, null);
        dato_Editar.clear();
    } else {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        return;
    }

}

//Consulta todos los registro de las tablas menos la de bienes y usuarios.
export async function consultarRegistros() {
    spinner(divTabla);
    const url = `/api/index.php/${nombreTabla}`;

    datos.value = await getApi(url);

    mostrarTabla(nombreTabla, true, null);

}

//Actualiza los registros 
async function actualizarItems(formData) {
    const idsBienes = [];

    dato_Editar.forEach((_, id) => {
        idsBienes.push(id);
    });

    // Convertir formData a objeto normal
    const datosFormulario = formDataToObject(formData);

    // Combinar los datos del formulario con los idsBienes
    const datos = {
        ...datosFormulario,
        idsBienes
    };

    const url = `/api/index.php/bienes/editarBienes`;
    const resultado = await putApi(url, datos);

    if (resultado.tipo === 'success') {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);

        spinner(divTabla);
        mostrarTabla(nombreTabla, true, resultado.datos);
        dato_Editar.clear();

    } else {
        mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        return;
    }
}
//FIN FUNCIONES CRUD


function obtenerId() {
    return document.getElementById('user-data').getAttribute('data-user-id');
}

function formDataToObject(formData) {
    const object = {};
    for (const [key, value] of formData.entries()) {
        object[key] = value;
    }
    return object;
}

//FUNCIONES PARA CAMBIAR EL ESTATUS DE USUARIO
function cambiandoEstatus(usuario) {
    const estatusTarea = usuario.estatus === 'activo' ? 'inactivo' : 'activo';
    usuario.estatus = estatusTarea;
    usuario.modified_by = obtenerId();
    actualizarEstatus(usuario, true);
}

async function actualizarEstatus(registro, cambioEstado = false) {

    const url = `/api/index.php/${nombreTabla}/editarEstado`;

    const resultado = await putApi(url, {
        id: registro.id,
        estatus: registro.estatus,
        modified_by: registro.modified_by
    });

    if (resultado.tipo === 'success') {
        if (!cambioEstado) {
            const formulario = document.querySelector('.formulario');
            formulario.reset();
            mostrarAlerta(resultado.tipo, resultado.titulo, resultado.mensaje);
        }
        const dato = resultado.dato;

        const index = datos.value.findIndex(u => u.id === dato.id);
        if (index !== -1) {
            datos.value[index].estatus = dato.estatus;
        }
        const botonEstatus = document.querySelector(`button[data-usuario-id="${dato.id}"]`);

        if (botonEstatus.classList.contains('btn-danger')) {
            botonEstatus.classList.remove('btn-danger');
            botonEstatus.classList.add('btn-success');
        } else {
            botonEstatus.classList.remove('btn-success');
            botonEstatus.classList.add('btn-danger');
        }
        console.log(dato);

        botonEstatus.textContent = dato.estatus;
    }
}

export function mostrarContraseña() {
    const divIcono = document.querySelector('.input-group-text');
    const inputPassword = document.querySelector('#password');
    divIcono.addEventListener('click', () => {
        const icono = document.querySelector('.input-group-text i');
        if (inputPassword.type === 'password') {
            inputPassword.type = 'text';
            icono.classList.replace('ri-eye-line', 'ri-eye-off-line');
        } else {
            inputPassword.type = 'password';
            icono.classList.replace('ri-eye-off-line', 'ri-eye-line');
        }
    });
}

export function modalConfirmacion() {

}


