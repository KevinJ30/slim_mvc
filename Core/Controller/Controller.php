<?php

namespace Core\Controller;
use Core\Database\Table;

/**
 * Class Controller
 *
 * Class Controller de base
 **/

class Controller{

    public $request;

    public $router;

    private $container;

    /**
     * Initialisation du controller
     *
     * @var $container : Injection du container par Slim Frameworks
     **/
    public function __construct($container){
        $this->request = $container->request;
        $this->router = $container->router;
        $this->container = $container;
    }

    public function table($table){
        return new Table($this->container->database, $table);
    }
}