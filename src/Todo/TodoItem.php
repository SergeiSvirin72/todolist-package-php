<?php

namespace Todo;

class TodoItem
{
    private $id, $name, $status;

    public function __construct($id, $name, $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getStatus() : bool
    {
        return $this->status;
    }

    public function changeStatus()
    {
        $this->status = !$this->status;
    }
}