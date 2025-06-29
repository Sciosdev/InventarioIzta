<?php
use Model\Usuario;
include_once __DIR__ . '/../clases/Usuario.php';
$usuario = new Usuario;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($_POST);
    $alertas = $usuario->validarLogin();
    // debuguear($alertas);

    if (empty($alertas)) {
        $usuario = Usuario::where('num_cuenta', $usuario->num_cuenta);

        if (!$usuario) {
            //El usuario no existe
            Usuario::setAlerta('danger','El usuario no existe');
        } else {
            //El usuario si existe
            if (password_verify($_POST['password'], $usuario->password)) {
                if ($usuario->estatus === 'inactivo') {
                    Usuario::setAlerta('danger', 'Tu usuario esta inactivo');
                } else {
                    session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre;
                    $_SESSION['num_cuenta'] = $usuario->num_cuenta;
                    $_SESSION['login'] = true;
                    $_SESSION['rol'] = $usuario->rol ? 'Administrador' : 'Usuario';
                    header('Location:/dashboard.php');
                }
            }else {
                Usuario::setAlerta('danger', 'La contraseña es incorrecta');
            }
        }
          
    }
}

$alertas = Usuario::getAlertas();
