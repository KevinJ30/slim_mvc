<?php

namespace Core;

/**
 * Class Singleton App
 *
 * Class de base de l'application
 **/
class App{

    private $slim;
    private static $_instance;

    // Constructeur de la class
    private function __construct(){
        // Récupération de la configuration
        $settings = require 'config/app.php';


        $this->slim = new \Slim\App($settings);
    }

    public static function getInstance(){
        if(!self::$_instance){
            self::$_instance = new App();
        }

        return self::$_instance;
    }

    public static function run(){
        return self::getInstance()->getSlim()->run();
    }

    public function getSlim(){
        return $this->slim;
    }
}