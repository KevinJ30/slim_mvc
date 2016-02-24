<?php

/**
 * Point d'entrée de l'application
 **/
use Core\App;
use Core\Routing\Router;

require 'vendor/autoload.php';

Router::get('/login', function(){
    var_dump('login');
});

Router::get('/posts', 'ArticlesController@index');
Router::post('/posts', 'ArticlesController@index');


App::run();