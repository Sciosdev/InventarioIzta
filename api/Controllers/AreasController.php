<?php

namespace Controllers;

use Model\Area;


class AreasController
{
  public static function index()
  {
    $limite = $_GET['limite'] ?? null;
    $areas = $limite ? Area::get($limite) : Area::all();
    echo json_encode($areas);
  }

  public static function create()
  {
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

  public static function update()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $area = Area::find($datos['id']);
    $area->sincronizar($datos);
    $area->guardar();

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

  public static function delete()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $bien = Area::find($datos['id']);
    $resultado = $bien->eliminar();
    $respuesta = [
      'tipo' => 'success',
      'titulo' => 'Eliminado',
      'mensaje' => 'El Area fue eliminada correctamente',
    ];
    echo json_encode($respuesta);
    return;
  }
}
