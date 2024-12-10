<?php 

require_once __DIR__ . '/../includes/app.php';
use Controllers\AdminController;
use Controllers\apiController;
use Controllers\CitaController;
use Controllers\LoginControllers;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();


// iniciar sesion 
$router->get('/', [LoginControllers::class, 'login']);
$router->post('/', [LoginControllers::class, 'login']);
$router->get('/logout', [LoginControllers::class, 'logout']);


// recuperar contraseña
$router->get('/olvide', [LoginControllers::class, 'olvide']);
$router->post('/olvide', [LoginControllers::class, 'olvide']);
$router->get('/recuperar', [LoginControllers::class, 'recuperar']);
$router->post('/recuperar', [LoginControllers::class, 'recuperar']);

// crear cuenta
$router->get('/crear-cuenta', [LoginControllers::class, 'crear']);
$router->post('/crear-cuenta', [LoginControllers::class, 'crear']);


//confirmar cuenta 
$router->get('/confirmar-cuenta', [LoginControllers::class, 'confirmar']);
$router->get('/mensaje', [LoginControllers::class, 'mensaje']);


// Ruta para cargar vistas  privad
$router->get('/cita',[CitaController::class, 'index']);
$router->get('/admin',[AdminController::class, 'index']);

$router->get('/api/servicios', [apiController::class, 'index'] );
$router->post('/api/citas', [apiController::class, 'guardar'] );
$router->post('/api/eliminar', [apiController::class, 'eliminar'] );

// crud de servicios para 
$router->get('/servicios', [ServicioController::class, 'index'] );
$router->get('/servicios/crear', [ServicioController::class, 'crear'] );
$router->post('/servicios/crear', [ServicioController::class, 'crear'] );
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar'] );
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar'] );
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();