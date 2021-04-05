<?php

namespace Todo;

use Todo\Storage\TodoStore;

class TodoList
{
    private $list = [];
    private $store;

    public function __construct(TodoStore $store)
    {
        $this->store = $store;
        foreach ($store->getData() as $item) {
            $this->list[] = new TodoItem($item['id'], $item['name'], $item['status']);
        }
    }

    public function getList() : array
    {
        return $this->list;
    }

    public function addItem($name)
    {
        $this->list[] = new TodoItem($this->store->getLastId() + 1, $name, false);
        $this->store->addItem($name);
    }

    public function deleteItem($id)
    {
        foreach ($this->list as $key => $value) {
            if ($value->getId() == $id) {
                array_splice($this->list, $key, 1);
                break;
            }
        }
        $this->store->deleteItem($id);
    }

    public function changeItem($id)
    {
        foreach ($this->list as $key => $value) {
            if ($value->getId() == $id) {
                $this->list[$key]->changeStatus();
                break;
            }
        }
        $this->store->changeItem($id);
    }

    public function render() {
        $this->validate();

        echo "<form action='$_SERVER[PHP_SELF]' method='post'><ol>";
        foreach ($this->getList() as $todoItem) {
            echo "<li><span";
            if ($todoItem->getStatus()) echo " style='text-decoration: line-through'";
            echo ">".$todoItem->getName()."</span> ";
            echo "<button type='submit' name='todo[do]' value='"
                .$todoItem->getId()."'>Do</button>";
            echo "<button type='submit' name='todo[delete]' value='"
                .$todoItem->getId()."'>Delete</button>";
            echo "</li>";
        }
        echo "</ol>
            <input type='text' name='todo[name]'>
            <input type='submit' name='todo[add]' value='Add item'>
        </form>";
    }

    private function validate() {
        if (isset($_POST['todo']['delete'])
            && filter_var($_POST['todo']['delete'], FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 0]]) !== false) {
            $this->deleteItem($_POST['todo']['delete']);
        }

        if (isset($_POST['todo']['do'])
            && filter_var($_POST['todo']['do'], FILTER_VALIDATE_INT,
                ['options' => ['min_range' => 0]]) !== false) {
            $this->changeItem($_POST['todo']['do']);
        }

        if (isset($_POST['todo']['add']) && $_POST['todo']['name']) {
            $this->addItem($_POST['todo']['name']);
        }
    }
}