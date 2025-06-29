<?php

use Model\Area;

if ($method === 'GET') {
    $limite = $_GET['limite'] ?? null;
    $areas = $limite ? Area::get($limite) : Area::all();
    echo json_encode($areas);
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $area = new Area($datos);

    $existeArea = Area::where('cve_area', $area->cve_area);

    if (!empty($existeArea)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El Area ya existe en el sistema.'
        ];
        echo json_encode($respuesta);
        return;
    }

    $resultado = $area->guardar();

    $area =  Area::where('cve_area', $area->cve_area);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => [$area],
        'mensaje' => 'La area ha sido creada correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'DELETE') {
    $area = Area::find($resourceId);
    $resultado = $area->eliminar();
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'mensaje' => 'El Area fue eliminada correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'PUT') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $datos['id'] = $resourceId;

    $area = new Area($datos);
    
    $resultado = $area->guardar();

    $area = Area::where('cve_area', $area->cve_area);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Guardado',
        'dato' => [$area],
        'mensaje' => 'El Tipo de bien fue actualizado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}
