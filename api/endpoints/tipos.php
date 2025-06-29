<?php

use Model\TipoBien;

if ($method === 'GET') {
    $limite = $_GET['limite'] ?? null;
    $tipos_bien = $limite ? TipoBien::get($limite) : TipoBien::all();
    echo json_encode($tipos_bien);
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $tipoBien = new TipoBien($datos);

    $existeBienTipo = TipoBien::where('cvetpo', $tipoBien->cvetpo);

    if (!empty($existeBienTipo)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El tipo de bien ya existe en el sistema.',
        ];
        echo json_encode($respuesta);
        return;
    }

    $resultado = $tipoBien->guardar();

    $tipoBien = TipoBien::where('cvetpo', $tipoBien->cvetpo);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => [$tipoBien],
        'mensaje' => 'El Tipo de bien ha sido creado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'DELETE') {
    $tipoBien = TipoBien::find($resourceId);
    $resultado = $tipoBien->eliminar();
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'mensaje' => 'El Tipo de bien fue eliminado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'PUT') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $datos['id'] = $resourceId;

    $tipoBien = new TipoBien($datos);
    $resultado = $tipoBien->guardar();

    $tipoBien = TipoBien::where('cvetpo', $tipoBien->cvetpo);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Guardado',
        'dato' => [$tipoBien],
        'mensaje' => 'El Tipo de bien fue actualizado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}
