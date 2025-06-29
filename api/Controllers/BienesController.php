<?php

namespace Controllers;

use Model\Bien;

class BienesController
{
  public static function index()
  {
    $filtros = $_GET;

    $resultadoConsulta = Bien::construirConsulta($filtros);
    $consulta = $resultadoConsulta['consulta'];
    $params = $resultadoConsulta['params'];

    

    $bienes = Bien::ejecutarConsulta($consulta, $params);

    echo json_encode($bienes);
    return;
  }

  public static function create()
  {
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


    $bien->guardar();

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

  public static function update()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $bien = Bien::find($datos['id']);
    $bien->sincronizar($datos);
    $bien->guardar();

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

  public static function delete()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $bien = Bien::find($datos['id']);
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

  public static function editarBienes()
  {
    $input = file_get_contents('php://input');
    $datos = json_decode($input, true); // ← como array

    $idsBienes = implode(', ', $datos['idsBienes']);

    unset($datos['idsBienes']);


    $resultado = Bien::updateBienes($datos, $idsBienes);

    $resultadoConsulta = Bien::getBienes($idsBienes);
    $consulta = $resultadoConsulta['consulta'];
    $params = $resultadoConsulta['params'];

    $bienes = Bien::ejecutarConsulta($consulta, $params);


    if (!$resultado) {
      echo json_encode(['status' => 'error', 'message' => 'Hubo un problema al actualizar']);
      return;
    }
    echo json_encode([
        'tipo' => 'success',
        'titulo' => 'Actualizados',
        'datos' => $bienes,
        'mensaje' => 'Los bienes se actualizaron corectamente']);
    return;
  }
}
