<?php
namespace Clases;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear objeto PHPMailer
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASS'];

        $phpmailer->setFrom('sarpecwilmer7@gmail.com');
        $phpmailer->addAddress('sarpecwilmer7@gmail.com', 'Appsalon');
        $phpmailer->Subject = 'Confirma Tu cuenta';

        $phpmailer->isHTML(true); // Activar el formato HTML
        $phpmailer->CharSet = 'UTF-8'; // Configurar el juego de caracteres UTF-8

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado una cuenta en AppSalon,Solo debes cofirmar la cuenta presionando el siguiente enlace:</p>";
        $contenido .= "<p> Haz Clic Aquí <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no fuiste tú, ignora este mensaje, o verifica tu correo. </p>";
        $contenido .= "</html>";
        $phpmailer->Body = $contenido;

        // Enviar email
        $phpmailer->send();
    }
    public function enviarInsturcciones(){
                // Crear objeto PHPMailer
                $phpmailer = new PHPMailer();
                $phpmailer->isSMTP();
                $phpmailer->Host = $ENV['EMAIL_HOST'];
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = $_ENV['EMAIL_PORT'];
                $phpmailer->Username = $_ENV['EMAIL_USER'];
                $phpmailer->Password = $_ENV['EMAIL_PASS'];
        
                $phpmailer->setFrom('sarpecwilmer7@gmail.com');
                $phpmailer->addAddress('sarpecwilmer7@gmail.com', 'Appsalon');
                $phpmailer->Subject = 'Restablece tu contraseña';
        
                $phpmailer->isHTML(true); // Activar el formato HTML
                $phpmailer->CharSet = 'UTF-8'; // Configurar el juego de caracteres UTF-8
        
                $contenido = "<html>";
                $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restableces tu Contraseña, presiona en el siguiente enlace:</p>";
                $contenido .= "<p> Haz Clic Aquí <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablecer Contraseña</a></p>";
                $contenido .= "<p>Si no fuiste tú, ignora este mensaje, o verifica tu correo. </p>";
                $contenido .= "</html>";
                $phpmailer->Body = $contenido;
        
                // Enviar email
                $phpmailer->send();
    }
}
