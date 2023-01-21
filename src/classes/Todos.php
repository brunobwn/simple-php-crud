<?php
class Todos extends Base
{
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