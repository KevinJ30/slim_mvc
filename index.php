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

/**Router::get('/login', function(){
    var_dump($this->database);
});**/

//Router::get('/posts', 'ArticlesController@index')->add(new AuthMiddleware());
//Router::post('/posts', 'ArticlesController@index');

Router::group('/api', function(){
    Router::get('/say', function($request, $response, $args){
       $response->getBody()->write('Bonjours...');
    });
})->add(new AuthMiddleware());


App::run();