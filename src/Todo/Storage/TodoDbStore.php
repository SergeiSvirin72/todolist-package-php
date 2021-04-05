<?php

namespace Todo\Storage;

use PDO;

class TodoDbStore extends TodoStore
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $query = $this->pdo->query('SELECT * FROM todos');
        $this->data = $query->fetchAll();
        $query = $this->pdo->query('SELECT MAX(id) AS lastId FROM todos');
        $this->last_id = $query->fetch()['lastId'] || 0;
    }

    public function addItem($name)
    {
        $query = $this->pdo->prepare('INSERT INTO todos VALUES (NULL, :name, 0)');
        $query->execute(['name' => $name]);
    }

    public function deleteItem($id)
    {
        $query = $this->pdo->prepare('DELETE FROM todos WHERE id = :id');
        $query->execute(['id' => $id]);
    }

    public function changeItem($id)
    {
        $query = $this->pdo->prepare('UPDATE todos SET status = NOT status WHERE id = :id');
        $query->execute(['id' => $id]);
    }
}