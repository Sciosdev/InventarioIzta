<?php

namespace Model;

class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuarios';

    protected static $columnasDB  = ['id', 'num_cuenta', 'nombre', 'password', 'rol', 'estatus', 'modified_by','token_email','email', 'confirmado'];

    protected static $validaciones = [
        ['regex' => '/.{6,}/', 'mensaje' => 'Tu contraseña necesita 6 caracteres o más'],
        ['regex' => '/[A-Z]/', 'mensaje' => 'Tu contraseña necesita al menos una letra mayúscula'],
        ['regex' => '/\d/', 'mensaje' => 'Tu contraseña necesita al menos un número'],
        ['regex' => '/[@$#,!%*?&]/', 'mensaje' => 'Tu contraseña necesita al menos uno de estos caracteres (@$#,!%*?&)'],
    ];

    public $id;
    public $nombre;
    public $num_cuenta;
    public $password;
    public $password_confirm;
    public $rol;
    public $estatus;
    public $modified_by;
    public $email;
    public $token_email;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->num_cuenta = $args['num_cuenta'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password_confirm = $args['password_confirm'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->token_email = $args['token_email'] ?? '';
        $this->rol = $args['rol'] ?? 0;
        $this->estatus = $args['estatus'] ?? 'inactivo';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->modified_by = $args['modified_by'] ?? null;
    }

    public function validarLogin(): array
    {
        if (!$this->num_cuenta) {
            self::$alertas['danger'][] = 'Por favor, ingresa el número de cuenta.';
        }
      
        if (!$this->password) {
            self::$alertas['danger'][] = 'Por favor, ingresa una contraseña.';
        }

        return self::$alertas;
    }

    public function validarContraseña(): array
    {
       if ($this->password !== $this->password_confirm) {
            self::$alertas['danger'][] = 'Las contraseñas no coinciden';
        }
      
        if (!$this->password) {
            self::$alertas['danger'][] = 'La contraseña es obligatoria';
        } else {
            foreach (self::$validaciones as $validacion):
                if (!preg_match($validacion['regex'], $this->password)) {
                    self::$alertas['danger'][] = $validacion['mensaje'];
                }
            endforeach;
        }

        return self::$alertas;
    }

    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}
