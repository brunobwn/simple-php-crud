<?php

abstract class Base
{
    protected $conn;

    public function __construct()
    {
        // Conecta ao banco de dados
        //$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
        $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT . ';charset=UTF8';
        $this->conn = new PDO($dsn, DB_USER, DB_PASS);
    }

    public function __destruct()
    {
        $this->conn = null;
    }
}