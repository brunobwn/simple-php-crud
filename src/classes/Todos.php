<?php
class Todos extends Base
{
    public function getAll()
    {
        $query = $this->conn->prepare("SELECT * FROM todos");
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllByUserId($userId)
    {
        if (is_null($userId) || !is_int($userId)) return [];
        $query = $this->conn->prepare("SELECT * FROM todos WHERE userId = ?");
        $query->execute([$userId]);
        return $query->fetchAll();
    }
}