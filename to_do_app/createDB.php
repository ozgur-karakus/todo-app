<?php

function createDb(){
    $db = new PDO('sqlite:database/todo.db');

    $db->exec('CREATE TABLE IF NOT EXISTS users (
        userId INTEGER PRIMARY KEY,
        username TEXT,
        password TEXT
    )');

    $db->exec('CREATE TABLE IF NOT EXISTS tasks (
        taskId INTEGER PRIMARY KEY,
        userId INTEGER,
        description TEXT
    )');
}

?>
