<?php

use Model\Usuario;
use Clase\Email;

if ($method === 'GET') {
    $limite = $_GET['limite'] ?? '';
    $usuarios = $limite ? Usuario::get($limite) : Usuario::all();
    foreach ($usuarios as $usuario) {
        unset($usuario->password); // Elimina la propiedad 'password' de cada usuario
    }
    echo json_encode($usuarios);
    return;
}

if ($method === 'POST') {

    $input = file_get_contents('php://input');
    $datos = json_decode($input, true);
    $usuario = new Usuario($datos);

    $existeUsuario = Usuario::where('num_cuenta', $usuario->num_cuenta);

    if (!empty($existeUsuario)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El usuario ya existe.'
        ];
        echo json_encode($respuesta);
        return;
    }

    $token = bin2hex(random_bytes(32));

    $usuario->token_email = $token;

    $resultado = $usuario->guardar();

    $usuario = Usuario::where('num_cuenta', $usuario->num_cuenta);

    //Eliminar password2
    unset($usuario->password);
    

    //Enviar el Correo, creamos una instacia del correo con los datos que nos envairon.
    $email = new Email($usuario->email, $usuario->nombre, $usuario->token_email);
    $email->enviarConfirmacion();

    //Eliminar token para regresar la informacion
    unset($usuario->token_email);
    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Creado',
        'dato' => [$usuario],
        'mensaje' => 'El usuario ha sido creado correctamente',
    ];
    echo json_encode($respuesta);
    return;
}

if ($method === 'DELETE') {

    $usuario = Usuario::find($resourceId);
    
    if (empty($usuario)) {
        $respuesta = [
            'tipo' => 'danger',
            'titulo' => 'Error',
            'mensaje' => 'El usuario no existe.'
        ];
        echo json_encode($respuesta);
        return;
    }

    $usuario->eliminar();

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Eliminado',
        'mensaje' => 'El Usuario fue eliminado correctamente',
    ];

    echo json_encode($respuesta);
    return;
}


if ($method === 'PUT') {

    $input = file_get_contents('php://input');
    // Decodifica los datos JSON
    $datos = json_decode($input, true);
    $datos['id'] = $resourceId;

    $usuario = Usuario::find($datos['id']);

    if ($usuario->num_cuenta !== $datos['num_cuenta']) {

        $numCuentaExists = Usuario::where('num_cuenta', $datos['num_cuenta']);

        if (!empty($numCuentaExists)) {
            $respuesta = [
                'tipo' => 'danger',
                'titulo' => 'Error',
                'mensaje' => 'El numero de cuenta ya esta asociado a otro usuario.'
            ];
            echo json_encode($respuesta);
            return;
        }
    }


    $usuario->sincronizar($datos);
    
    if (isset($datos['password'])) {
        $usuario->hashPassword();
    }

    $usuario->guardar();

    $usuario = Usuario::find($usuario->id);

    $respuesta = [
        'tipo' => 'success',
        'titulo' => 'Actualizado',
        'dato' => [$usuario],
        'mensaje' => 'Se ha actualizo correctamente',
    ];

    echo json_encode($respuesta);
    return;
}
