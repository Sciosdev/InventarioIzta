<?php

namespace Controllers;

use Model\Responsable;

class ResponsablesController
{
  public static function index()
  {
    $limite = $_GET['limite'] ?? null;
    $responsables = $limite ? Responsable::get($limite) : Responsable::all();
    echo json_encode($responsables);
  }

  public static function create()
  {
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

  public static function update()
  {
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $responsable = Responsable::find($datos['id']);

    $responsable->sincronizar($datos);
    $responsable->guardar();

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

  public static function delete()
  {
     $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $responsable = Responsable::find($datos['id']);

    $resultado = $responsable->eliminar();
    $respuesta = [
      'tipo' => 'success',
      'titulo' => 'Eliminado',
      'mensaje' => 'El Responsable fue eliminado correctamente'
    ];
    echo json_encode($respuesta);
    return;
  }
}
