<?php

namespace Todo\Storage;

abstract class TodoStore
{
    protected $data, $last_id;

    public function getData()
    {
        return $this->data;
    }

    public function getLastId() : int
    {
        return $this->last_id;
    }

    abstract public function addItem($name);

    abstract public function deleteItem($id);

    abstract public function changeItem($id);
}