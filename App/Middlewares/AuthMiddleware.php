<?php

namespace App\Middlewares;

class AuthMiddleware{

    public function __invoke($request, $response, $next){

        if(isset($_SESSION) && isset($_SESSION['auth'])){
            $response = $next($request, $response);
        }else{
            $response = $response->withStatus(301);
            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(['status' => false, 'message' => "Vous n'êtes pas connecté"]));
        }

        return $response;
    }
}