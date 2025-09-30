<?php
require_once __DIR__ . '/../layouts/app.php';

use Model\Usuario;
require_once __DIR__ . '/../clases/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    $token = $_GET['token'];
    $usuario = Usuario::where('token_email', $token);

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_GET['token'];
    $usuario = new Usuario($_POST);

    $alertas = $usuario->validarContraseña();

    if (empty($alertas)) {
        
        $usuario = Usuario::where('token_email', $token);
        $usuario->sincronizar( $_POST);
        unset($usuario->password_confirm);
        $usuario->confirmado = 1;
        $usuario->hashPassword();
        unset($usuario->token_email);
        $usuario->guardar();
        header('Location: ' . url('/message.php'));
    }

    return;

}
$alertas = Usuario::getAlertas();


