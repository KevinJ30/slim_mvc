<?php

namespace Core\Controller;

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

        var_dump($this->container->database->getDatabase());
    }
}