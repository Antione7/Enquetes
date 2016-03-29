<?php

namespace Manager;


class DbManager {

//attributs
    protected $pdo;

    public function __construct() {
        $dns = "mysql:host=localhost;dbname=enquetes";
        $options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
        $this->pdo = new \PDO($dns,"root","", $options);
        //obligation utilisation \PDO car pas dans le même namespace
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection() {
        return $this->pdo;
    }

}


