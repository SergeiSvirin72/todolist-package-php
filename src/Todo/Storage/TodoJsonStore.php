<?php

namespace Todo\Storage;

class TodoJsonStore extends TodoStore
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $string = file_get_contents($filename);
        $this->data = json_decode($string, true);
        $el = array_slice($this->data, -1)[0];
        $this->last_id = $el ? $el['id'] : 0;
    }

    public function addItem($name)
    {
        $this->data[] = ['id' => $this->last_id + 1, 'name' => $name, 'status' => false];
        $this->saveChanges();
    }

    public function deleteItem($id)
    {
        $key = array_search($id, array_column($this->data, 'id'));
        array_splice($this->data, $key, 1);
        $this->saveChanges();
    }

    public function changeItem($id)
    {
        $key = array_search($id, array_column($this->data, 'id'));
        $this->data[$key]['status'] = !$this->data[$key]['status'];
        $this->saveChanges();
    }

    private function saveChanges()
    {
        file_put_contents($this->filename, json_encode($this->data));
    }
}