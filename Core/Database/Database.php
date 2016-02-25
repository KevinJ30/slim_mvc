<?php

/**
 * Class Database
 *
 * Gestion de la connection à la base de données
 **/

namespace Core\Database;

use Exception;
use PDO;
use PDOException;
use Slim\Collection;
use Slim\Exception\NotFoundException;
use Slim\Exception\SlimException;

class Database{

    /**
     * @var bool : mode debug
     **/
    private $debug;

    /**
     * @var string $host Hôte de connection
     **/
    private $host;

    /**
     * @var string username
     **/
    private $username;

    /**
     * @var string mot de passe
     **/
    private $password;

    /**
     * @var string nom de la base de données
     **/
    private $dbname;

    /**
     * @var string encodage de la base de données
     **/
    private $encodage;

    /**
     * @instance \PDO()
     **/
    private $_pdo;

    /**
     * @var $_instance @instance
     **/
    private static $_instance;

    /**
     * @param Collection $settings
     * @return Database
     *
     * Permet d'appeller la class avec une seule et meme instance
     **/
    public static function getInstance(Collection $settings){
        if(!self::$_instance){
            self::$_instance = new Database($settings);
        }

        return self::$_instance;
    }

    /**
     * @param Collection $settings
     *
     * Initialisation de la class
     **/
    public function __construct(Collection $settings){

        // Récupération de la configuration de la base de données
        $database_config = $settings->get('database');

        // Initialisation
        $this->host = $database_config['host'];
        $this->username = $database_config['username'];
        $this->password = $database_config['password'];
        $this->dbname = $database_config['dbname'];
        $this->encodage = $database_config['encodage'];
        $this->debug = $settings->get('debug');

        return $this;
    }

    public function getDatabase(){
        $dsn = "mysql:dbname=".$this->dbname.";host=".$this->host;
        $username = $this->username;
        $password = $this->password;

        // Connection a la base de données
        try{
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES '.$this->encodage);

            $this->pdo = $pdo;
            return $this->pdo;
        }catch(PDOException $e){
            if($this->debug){
                throw new Exception('Erreur : '.$e->getMessage());
            }
            else
            {
                die('Impossible de se connecter à la base de données');
            }
        }
    }

}