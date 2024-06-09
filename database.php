<?php
// Функция для подключения к базе данных
function connectDB() {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($connection->connect_error) {
        die('Connection Failed: ' . $connection->connect_error);
    }
    return $connection;
}