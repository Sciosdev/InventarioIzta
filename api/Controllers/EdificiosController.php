<?php

namespace Controllers;

use Model\Edificio;

class EdificiosController
{
  public static function index()
  {
    $limite = $_GET['limite'] ?? null;
    $edificios = $limite ? Edificio::get($limite) : Edificio::all();
    echo json_encode($edificios);
  }
  public static function create()
  {

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
  public static function update()
  {
    $input = file_get_contents('php://input');

   // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $edificio = Edificio::find($datos['id']);

    $edificio->sincronizar($datos);
    $edificio->guardar();

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
  public static function delete()
  { 
    $input = file_get_contents('php://input');

    // Decodifica los datos JSON
    $datos = json_decode($input, true);

    $edificio = Edificio::find($datos['id']);
    $edificio->eliminar();
    $respuesta = [
      'tipo' => 'success',
      'titulo' => 'Eliminado',
      'mensaje' => 'El Edificio fue eliminado correctamente',
    ];
    echo json_encode($respuesta);
    return;
  }
}
