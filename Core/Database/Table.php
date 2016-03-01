<?php

namespace Core\Database;

use Core\Database\Database;

class Table{

    private $database;

    private $table;

    private $fields;

    private $condition;

    private $order;

    private $limit;

    /**
     * @param $table : nom de la table
     **/
    public function __construct(Database $database, $table){
        $this->database = $database;
        $this->table = $table;
    }

    public function find(){
        $driver = $this->database->getDatabase();
        $req = $driver->query($this->buildQuery());

        $data = $req->fetchAll(\PDO::FETCH_OBJ);

        // Si il y a qu'une seule entrée dans le tableau
        // On retourne directement le resultat
        if(count($data) == 1){
            $data = current($data);
        }

        return $data;
    }

    /**
     * @param $condition : condition
     * @param $type : type de condition
     **/
    public function where($condition, $type = null){
        $this->condition = " WHERE ";

        // On test si un comparateur a été spécifier
        $regex = "#^[a-z]+$#";

        foreach($condition as $k=>$v){
            $this->condition .= preg_match($regex, $k) ? $k.' = '.$v.' ' : $k.' '.$v.' ';
        }

        return $this;
    }

    /**
     * @param $field : le champs
     * @param $type : type de ordre
     * @return $this
     **/
    public function order($field, $type){
        $this->order = 'ORDER BY ';
        $this->order .= $field . ' ' . $type;
        return $this;
    }

    /**
     * @param $offset
     * @param $limit
     * @return $this
     **/
    public function limit($offset, $limit){
        $this->limit = " LIMIT ";
        $this->limit .= $offset . ', '.$limit;
        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     **/
    public function fields(array $fields){
        $this->fields = implode($fields, ', ');
        return $this;
    }

    /**
     * @return string : requête sql
     **/
    private function buildQuery(){
        $fields = $this->fields ? $this->fields : '*';
        $sql = "SELECT " . $fields . " FROM " . $this->table . $this->condition . $this->order . $this->limit;
        return $sql;
    }
}