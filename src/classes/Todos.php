<?php

class Todos
{
    private $conn;

    public function __construct()
    {
        // Conecta ao banco de dados
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    }

    public function getAll()
    {
        return $this->conn->query("SELECT * FROM todos");
    }

    public function getAllByUserId($userId)
    {
        if (is_null($userId) || !is_int($userId)) return null;
        return $this->conn->query("SELECT * FROM todos WHERE userId = $userId");
    }
}