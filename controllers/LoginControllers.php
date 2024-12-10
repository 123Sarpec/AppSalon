<?php

namespace Controllers;

use Clases\Email;
use MVC\Router;
use Model\Usuario;



class LoginControllers
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //comprobar si exixte el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    if ($usuario->comprobarContraseña($auth->password)) {
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " .
                        $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // redireccionamiento 
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El Usuario no Existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    // cerrar sesion del usuario 
    public static function logout()
    {
        session_start();

        $_SESSION = [];
        header('Location: /');

    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado === "1") {
                    $usuario->crearToken();
                    $usuario->guardar();

                    // enviar email 
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInsturcciones();

                    // alerta de exit 
                    Usuario::setAlerta('exito', 'Revisa tu correo');
                } else {
                    Usuario::setAlerta('error', 'El Usuario no Existe o no ha sido confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // mostrar mensaje de error 
            Usuario::setAlerta('error', 'Token invalido para recuperar Contraseña');
            $error = true;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // leer mensaje recuperar
            $password = new Usuario($_POST);
            $alertas = $password->validarpassword();

            if (empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado =$usuario->guardar();
                if($resultado){
                    header('Location: /');
                }

            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario($_POST);

        $alertas = [];


        // Validar y guardar los datos del usuario en la base de datos.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();



            //revisar que alertas esta vacia
            if (empty($alertas)) {
                //verificar el usuario que no esta registrado
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //hashear el password
                    $usuario->hashPassword();

                    //Gener un token
                    $usuario->crearToken();
                    //enviar a email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //crear usiario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                    // debuguear($usuario);
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // mostrar mensaje de error 
            Usuario::setAlerta('error', 'Token invalido para confirmar Cuenta');
        } else {
            // confirmat cuenta de usuario 
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmado');
        }


        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
