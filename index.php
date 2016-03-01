<?php

/**
 * Point d'entrée de l'application
 **/
use App\Middlewares\AuthMiddleware;
use Core\App;
use Core\Routing\Router;

// On créer la session
session_start();

require 'vendor/autoload.php';

// On inclut le fichier de route
require 'config/routes.php';


App::run();