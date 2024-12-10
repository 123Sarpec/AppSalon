<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

// Cargar las variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__); // Correcto, no necesitas repetir Dotenv\Dotenv
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);
