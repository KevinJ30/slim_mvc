<?php

namespace App\Controller;

use Core\Controller\Controller;

class ArticlesController extends Controller{

    public function beforeFilter(){

        echo 'Bonjour je suis le before filter!';

    }

    public function index(){
        $users = $this->table('users')->fields(['id', 'username'])->find();

        var_dump($users);

    }

}