<?php

use Model\Bien;

if ($method === 'GET') {

    $filtros = $_GET;

    $resultadoConsulta = Bien::construirConsulta($filtros);
    $consulta = $resultadoConsulta['consulta'];
    $params = $resultadoConsulta['params'];

    $bienes = Bien::ejecutarConsulta($consulta, $params);

    echo json_encode($bienes);
    return;
}

if ($method === 'DELETE') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    return json_encode($datos);
    

    $bien = Bien::find($resourceId);
    $resultado = $bien->eliminar();
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'id' => $resultado['id'],
        'mensaje' => 'El bien fue eliminado correctamente',
    ];
    echo json_encode($respuesta);

    return;
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $bien = new Bien($datos);
    $existeBien = Bien::where('numero_inventario', $bien->numero_inventario);

    //Comprobamos si existe el el bien
    if ($existeBien) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El artículo ya está registrado en el sistema.',
        ];
        echo json_encode($respuesta);
        return;
    }
 

    $resultado = $bien->guardar();

    $resultadoConsulta = Bien::construirConsulta(["numero_inventario" => $bien->numero_inventario]);
    
    $consulta = $resultadoConsulta['consulta'];
    
    $params = $resultadoConsulta['params'];

    $bien = Bien::ejecutarConsulta($consulta, $params);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => $bien,
        'mensaje' => 'El bien ha sido creado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'PUT') {

    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true); 
    $bien = Bien::find($datos['id']);
    $bien->sincronizar($datos);
    $resultado = $bien->guardar();
    
    $resultadoConsulta = Bien::construirConsulta(["numero_inventario" => $bien->numero_inventario]);
    $consulta = $resultadoConsulta['consulta'];
    $params = $resultadoConsulta['params'];

    $bien = Bien::ejecutarConsulta($consulta, $params);
    

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Actualizado',
        'dato' => $bien,
        'mensaje' => 'El bien fue actualizado correctamente',
    ];

    echo json_encode($respuesta);
    return;
}
