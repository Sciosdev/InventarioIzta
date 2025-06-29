<?php

use Model\Edificio;

if ($method === 'GET') {
    $limite = $_GET['limite'] ?? null;
    $edificios = $limite ? Edificio::get($limite) : Edificio::all();
    echo json_encode($edificios);
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $edificio = new Edificio($datos);

    $existeEdificio = Edificio::where('cveedif', $edificio->cveedif);

    if (!empty($existeEdificio)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El Edificio ya existe en el sistema.',
        ];
        echo json_encode($respuesta);
        return;
    }

    $resultado = $edificio->guardar();

    $edificio = Edificio::where('cveedif', $edificio->cveedif);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => [$edificio],
        'mensaje' => 'El Edificio ha sido creado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'DELETE') {
    $edificio = Edificio::find($resourceId);
    $resultado = $edificio->eliminar();
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'mensaje' => 'El Edificio fue eliminado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'PUT') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $datos['id'] = $resourceId;

    $edificio = new Edificio($datos);
    
    $resultado = $edificio->guardar();

    $edificio = Edificio::where('cveedif', $edificio->cveedif);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Guardado',
        'dato' => [$edificio],
        'mensaje' => 'El Tipo de bien fue actualizado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}
