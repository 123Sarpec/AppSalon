<?php
namespace Controllers;

use MVC\Router;

class CitaController{
    public static function index ( Router $router ){
        session_start();

        // renderizar la autenticacion del usuario
        isAuth();
        

        // renderizar la vista de la cita
        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
        ]);
    }
}