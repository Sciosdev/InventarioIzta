<!-- Acciones -->
<div class="row mb-3 acciones">

    <div class="col-12 d-flex flex-column flex-sm-row gap-1">
        <?php if ($consultarTodos) { ?>
            <button id="consultar"
                class="btn btn-primary w-100 ">
                <i class="ri-search-line"></i>
                Consultar Todos
            </button>
        <?php } ?>
        <button type="button"
            class="btn btn-success w-100"
            id="nuevo">
            <i class="ri-add-line"></i>
            Nuevo
        </button>
        <!-- <button id="" class="btn btn-dark w-100 "><i class="ri-printer-line"></i> Imprimir</button> -->
        <button id="editar"
            type="button"
            class="btn btn-secondary w-100">
            <i class="ri-pencil-line"></i>
            Editar
        </button>

        <?php if (isAdmin()) { ?>
            <button id="eliminar"
                type="button"
                class="btn btn-dark w-100">
                <i class="ri-delete-bin-line"></i>
                Eliminar
            </button>
        <?php } ?>

        <?php if ($imprimir) { ?>
    <button id="btnImprimirBienes"
        class="btn btn-info w-100 ">
        <i class="ri-printer-line"></i>
        Imprimir
    </button>
<?php } ?>

    </div>
</div>