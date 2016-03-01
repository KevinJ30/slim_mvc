<?php
namespace Core\Routing;
use Core\App;

/**
 * class Router
 *
 * Permet la construction de route plus facilement
 **/
class Router{

    /**
     * @param $path
     * @param $callable
     * @return mixed
     * @throws \Exception
     *
     * Appèlle à la fonction native get de slim
     **/
    public static function get($path, $callable){
        return self::call($path, $callable, 'get');
    }

    /**
     * @param $path
     * @param $callable
     * @return mixed
     * @throws \Exception
     *
     * Appèlle à la fonction native post de slim
     **/
    public static function post($path, $callable){
        return self::call($path, $callable, 'post');
    }

    /**
     * @param $path
     * @param $callable
     * @return mixed
     * @throws \Exception
     *
     * Appèlle à la fonction native put de slim
     **/
    public static function put($path, $callable){
        return self::call($path, $callable, 'put');
    }

    /**
     * @param $path
     * @param $callable
     * @return mixed
     * @throws \Exception
     *
     * Appèlle à la fonction native delete de slim
     **/
    public static function delete($path, $callable){
        return self::call($path, $callable, 'delete');
    }

    /**
     * @param $path : chemin de la route
     * @param $callable : closure | controller plus methode
     * @param $type : type de méthode
     * @return mixed
     * @throws \Exception
     *
     * Permet d'appeller la bonne methode de la class slim
     **/
    private static function call($path, $callable, $type){
        $slim = App::getInstance()->getSlim();

        /**
         * Si on a définit un controller
         **/
        if(!is_callable($callable)){
            $callable = explode('@', $callable);

            // On recherche le controller
            $class = "\\App\\Controller\\".$callable[0];

            // Si le controller n'existe pas.
            if(!class_exists($class)){
                http_response_code(404);
                throw new \Exception("La classe ".$class."  n'existe pas");
            }


            // Si la methode du controller n'existe pas
            if(!method_exists($class, $callable[1])){
                http_response_code(404);
                throw new \Exception("La methode ".$callable[1]."  n'existe pas dans la classe \"".$class."\"");
            }

            $class .= ":".$callable[1];
            $params = [$path, $class];
        }
        else
        {
            $params = [$path, $callable];
        }

        // On execute le controller ou la methode callable
        return call_user_func_array([$slim, $type], $params);
    }

    /**
     * @param $path
     * @param $callable
     *
     * Permet de créer des groupe de route
     **/
    public static function group($path, $callable){
        $slim = App::getInstance()->getSlim();
        return $slim->group($path, $callable);
    }
}