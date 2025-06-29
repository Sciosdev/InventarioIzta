<?php

namespace Controllers;

use Model\TipoBien;

class TiposController
{
  public static function index()
  {
    $limite = $_GET['limite'] ?? null;
    $tipos_bien = $limite ? TipoBien::get($limite) : TipoBien::all();
    echo json_encode($tipos_bien);
  }

  public static function create()
  {
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

  public static function update()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $tipoBien = TipoBien::find($datos['id']);

    $tipoBien->sincronizar($datos);
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

  public static function delete()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $tipoBien = TipoBien::find($datos['id']);
    $resultado = $tipoBien->eliminar();
    $respuesta = [
      'tipo' => 'success',
      'titulo' => 'Eliminado',
      'mensaje' => 'El Tipo de bien fue eliminado correctamente',
    ];
    echo json_encode($respuesta);
    return;
  }
}
