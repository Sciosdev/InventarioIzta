<?php

use MVC\Router;
use Model\Usuario;
use Controllers\AreasController;
use Controllers\BienesController;
use Controllers\EdificiosController;
use Controllers\ResponsablesController;
use Controllers\TiposController;
use Controllers\UsuariosController;

require_once __DIR__ . '/../layouts/app.php';
require_once __DIR__ . '/../config/env.php';

spl_autoload_register('mi_autoload');
spl_autoload_register('mi_autoloadController');
spl_autoload_register('mi_autoloadMVC');
session_start();

if (!$_SESSION['login']) {
    echo json_encode(['Solicitud Incorrecta']);
    return;
}

$usuario = Usuario::find($_SESSION['id']);

if ($usuario->estatus !== 'activo') {
    $respuesta = [
        'tipo' => 'danger',
        'titulo' => 'Error',
        'mensaje' => 'Lo sentimos, tu usuario no tiene permiso para realizar esta acción',
    ];
    echo json_encode($respuesta);
    return;
}

//Cargar variables de entorno
$ruta = __DIR__ . '/../config/.env';
cargarEnv($ruta);

// $method = $_SERVER['REQUEST_METHOD'];
// $path = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
// $resourceId = isset($path[1]) ? $path[1] : null;
// $request = $path[0];

$router = new Router();

//Bienes
$router->get('/bienes', [BienesController::class, 'index']);
$router->post('/bienes', [BienesController::class, 'create']);
$router->put('/bienes', [BienesController::class, 'update']);
$router->delete('/bienes', [BienesController::class, 'delete']);
$router->put('/bienes/editarBienes', [BienesController::class, 'editarBienes']);

//Areas
$router->get('/areas', [AreasController::class, 'index']);
$router->post('/areas', [AreasController::class, 'create']);
$router->put('/areas', [AreasController::class, 'update']);
$router->delete('/areas', [AreasController::class, 'delete']);

//Edificios
$router->get('/edificios', [EdificiosController::class, 'index']);
$router->post('/edificios', [EdificiosController::class, 'create']);
$router->put('/edificios', [EdificiosController::class, 'update']);
$router->delete('/edificios', [EdificiosController::class, 'delete']);

//Responsables
$router->get('/responsables', [ResponsablesController::class, 'index']);
$router->post('/responsables', [ResponsablesController::class, 'create']);
$router->put('/responsables', [ResponsablesController::class, 'update']);
$router->delete('/responsables', [ResponsablesController::class, 'delete']);

//Tipos
$router->get('/tipos', [TiposController::class, 'index']);
$router->post('/tipos', [TiposController::class, 'create']);
$router->put('/tipos', [TiposController::class, 'update']);
$router->delete('/tipos', [TiposController::class, 'delete']);

//Usuarios
$router->get('/usuarios', [UsuariosController::class, 'index']);
$router->post('/usuarios', [UsuariosController::class, 'create']);
$router->put('/usuarios', [UsuariosController::class, 'update']);
$router->put('/usuarios/editarEstado', [UsuariosController::class, 'updateStatus']);
$router->delete('/usuarios', [UsuariosController::class, 'delete']);


$router->comprobarRutas();

// $routes = [
//     //Bienes
//     'bienes' => ['BienesController', 'index'],
// ];

// if (array_key_exists($request, $routes)) {
//     call_user_func($routes[$request], $method);
// } else {
//     http_response_code(404);
//     echo json_encode(['error' => 'Ruta no encontrada']);
// }


// switch ($request) {

//     case 'bienes':
//         require_once __DIR__ .'/endpoints/bienes.php';
//         break;

//     case 'tipos':
//         require_once __DIR__ .'/endpoints/tipos.php';
//         break;

//     case 'edificios':
//         require_once __DIR__ .'/endpoints/edificios.php';
//         break;

//     case 'areas':
//         require_once __DIR__ .'/endpoints/areas.php';
//         break;
        
//     case 'responsables':
//         require_once __DIR__ .'/endpoints/responsables.php';
//         break;

//     case 'usuarios':
//         //Cargar lo necesario para enviar un email
//         require_once __DIR__.'/endpoints/usuarios.php';
//         break;

//     default:
//         # code...
//         break;
// }
