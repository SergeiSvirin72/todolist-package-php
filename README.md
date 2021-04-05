# Todo list
Simple PHP todo list demonstrating basic knowledge of Composer and OOP.

## Installation
``` php
composer require sergeisvirin72/todo
```

## Usage
### Database storage
``` sql
CREATE TABLE todos (
 id int(11) NOT NULL AUTO_INCREMENT,
 name tinytext NOT NULL,
 status tinyint(1) NOT NULL DEFAULT 0,
 PRIMARY KEY (id)
) 
```
``` php
$todoStore = new TodoDbStore($pdo_object);
```
### File storage
``` php
$todoStore = new TodoJsonStore($absolute_path_to_json);
```
### After creating storage
``` php
$todoList = new TodoList($todoStore);
$todoList->render();
```