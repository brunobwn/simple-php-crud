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

    public function getTodoById($todoId)
    {
        if (is_null($todoId)) return false;
        $query = $this->conn->prepare("SELECT * FROM todos WHERE todoId = ?");
        $query->execute([$todoId]);
        return $query->fetch();
    }

    public function create($userId, $description, $completed = 0)
    {
        if (is_null($userId) || is_null($description)) return [false, 'Preencha todos os campos'];
        $query = $this->conn->prepare("INSERT INTO todos (userId, description, completed) VALUES (?, ?, ?)");
        $res = $query->execute([$userId, $description, $completed]);
        return ($res) ? [true] : [false, 'Erro interno do servidor, tente novamente mais tarde'];
    }

    public function toggleCompleted($todoId, $userId)
    {
        if (is_null($userId) || is_null($todoId)) return [false, 'Preencha todos os campos'];
        $userId = strval($userId);
        $query = $this->conn->prepare('SELECT userId, completed FROM todos WHERE todoId = ?');
        $query->execute([$todoId]);
        $todo = $query->fetch();
        if (!$todo) {
            return [false, 'Tarefa não encontrada'];
        }
        if ($todo['userId'] != $userId) {
            return [false, 'Você não tem permissão para editar esta tarefa'];
        }
        $completed = ($todo['completed'] == 0) ? '1' : '0';
        $query = $this->conn->prepare('UPDATE `todos` SET `completed` = ? WHERE `todoId` = ?');
        $res = $query->execute([$completed, $todoId]);
        return ($res) ? [true] : [false, 'Erro interno do servidor, tente novamente mais tarde'];
    }

    public function update($todoId, $userId, $description)
    {
        if (is_null($userId) || is_null($todoId)) return [false, 'Preencha todos os campos'];
        $userId = strval($userId);
        $query = $this->conn->prepare('SELECT userId FROM todos WHERE todoId = ?');
        $query->execute([$todoId]);
        $todo = $query->fetch();
        if (!$todo) {
            return [false, 'Tarefa não encontrada'];
        }
        if ($todo['userId'] != $userId) {
            return [false, 'Você não tem permissão para editar esta tarefa'];
        }
        $query = $this->conn->prepare('UPDATE `todos` SET `description` = ? WHERE `todoId` = ?');
        $res = $query->execute([$description, $todoId]);
        return ($res) ? [true] : [false, 'Erro interno do servidor, tente novamente mais tarde'];
    }

    public function delete($todoId, $userId)
    {
        if (is_null($userId) || is_null($todoId)) return [false, 'Preencha todos os campos'];
        $userId = strval($userId);
        $query = $this->conn->prepare('SELECT userId, completed FROM todos WHERE todoId = ?');
        $query->execute([$todoId]);
        $todo = $query->fetch();
        if (!$todo) {
            return [false, 'Tarefa não encontrada'];
        }
        if ($todo['userId'] != $userId) {
            return [false, 'Você não tem permissão para deletar esta tarefa'];
        }
        $completed = ($todo['completed'] == 0) ? '1' : '0';
        $query = $this->conn->prepare('DELETE FROM `todos` WHERE `todoId` = ?');
        $res = $query->execute([$todoId]);
        return ($res) ? [true] : [false, 'Erro interno do servidor, tente novamente mais tarde'];
    }
}