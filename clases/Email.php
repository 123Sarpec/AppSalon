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
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('sarpecwilmer7@gmail.com');
        $mail->addAddress('sarpecwilmer7@gmail.com', 'Appsalon');
        $mail->Subject = 'Confirma Tu cuenta';

        $mail->isHTML(true); // Activar el formato HTML
        $mail->CharSet = 'UTF-8'; // Configurar el juego de caracteres UTF-8

        $mail = "<html>";
        $mail .= "<p><strong>Hola " . $this->email . "</strong> Has creado una cuenta en AppSalon,Solo debes cofirmar la cuenta presionando el siguiente enlace:</p>";
        $mail .= "<p> Haz Clic Aquí <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $mail .= "<p>Si no fuiste tú, ignora este mensaje, o verifica tu correo. </p>";
        $mail .= "</html>";
        $mail->Body = $contenido;

        // Enviar email
        $mail->send();
    }
    public function enviarInsturcciones(){
                // Crear objeto PHPMailer
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = $ENV['EMAIL_HOST'];
                $mail->SMTPAuth = true;
                $mail->Port = $_ENV['EMAIL_PORT'];
                $mail->Username = $_ENV['EMAIL_USER'];
                $mail->Password = $_ENV['EMAIL_PASS'];
        
                $mail->setFrom('sarpecwilmer7@gmail.com');
                $mail->addAddress('sarpecwilmer7@gmail.com', 'Appsalon');
                $mail->Subject = 'Restablece tu contraseña';
        
                $mail->isHTML(true); // Activar el formato HTML
                $mail->CharSet = 'UTF-8'; // Configurar el juego de caracteres UTF-8
        
                $contenido = "<html>";
                $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado restableces tu Contraseña, presiona en el siguiente enlace:</p>";
                $contenido .= "<p> Haz Clic Aquí <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'>Restablecer Contraseña</a></p>";
                $contenido .= "<p>Si no fuiste tú, ignora este mensaje, o verifica tu correo. </p>";
                $contenido .= "</html>";
                $mail->Body = $contenido;
        
                // Enviar email
                $mail->send();
    }
}
