<?php

namespace Clase;

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;


class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        //Creamos el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST_EMAIL_INVENTARIO'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['SMTP_PORT_EMAIL_INVENTARIO'];
        $mail->Username = $_ENV['SMTP_USER_EMAIL_INVENTARIO'];
        $mail->Password = $_ENV['SMTP_PASSWORD_EMAIL_INVENTARIO'];
        $mail->SMTPSecure = 'tls';

        $mail->setFrom($_ENV['SMTP_FROM_EMAIL_INVENTARIO'], 'Inventario Fesi');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Crea tu contraseña';

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';


        $contenido = "<html>";
        $contenido .= "<p><strong>Hola {$this->nombre},</strong></p>";
        $contenido .= "<p>Hemos registrado tu correo electrónico en el sistema de Inventario. Para completar tu acceso, es necesario que crees una contraseña personal.</p>";
        $contenido .= "<p>Por favor, haz clic en el siguiente enlace para establecer tu contraseña y activar tu cuenta:</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['URL_APP'] . "/confirm.php?token=" . $this->token . "'> Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si no reconoces este registro, puedes ignorar este mensaje.</p>";
        $contenido .= "</html>";


        $mail->Body = $contenido;
        $mail->send();
    }
}
