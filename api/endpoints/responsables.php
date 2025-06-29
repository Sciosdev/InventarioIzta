<?php

use Model\Responsable;

if ($method === 'GET') {
    $limite = $_GET['limite'] ?? null;
    $responsables = $limite ? Responsable::get($limite) : Responsable::all();
    echo json_encode($responsables);
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $responsable = new Responsable($datos);

    $existeResponsable = Responsable::where('rfc', $responsable->rfc);

    if (!empty($existeResponsable)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El Responsable ya existe en el sistema.',
        ];
        echo json_encode($respuesta);
        return;
    }

    $resultado = $responsable->guardar();

    $responsable =  Responsable::where('rfc', $responsable->rfc);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => [$responsable],
        'mensaje' => 'El Responsable se creo correctamente.'
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'DELETE') {
    $responsable = Responsable::find($resourceId);
    $resultado = $responsable->eliminar();
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'mensaje' => 'El Responsable fue eliminado correctamente'
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'PUT') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $datos['id'] = $resourceId;

    $responsable = new Responsable($datos);
    
    $resultado = $responsable->guardar();

    $responsable = Responsable::where('rfc', $responsable->rfc);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Guardado',
        'dato' => [$responsable],
       'mensaje' => 'El Responsable fue actualizado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}
