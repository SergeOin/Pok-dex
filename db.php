<?php
$database = [
    'host' => 'localhost',
    'port' => '3308',
    'dbname' => 'my_shop',
    'username' => 'root',
    'password' => '',
];

function connectDB()
{
    global $database;
    $host = $database['host'];
    $port = $database['port'];
    $name = $database['dbname'];
    $username = $database['username'];
    $password = $database['password'];
    try {
        $pdo = new PDO("mysql:host=$host; port=$port; dbname=$name", "$username", "$password");
    } catch (PDOException $errors) {
        echo $errors->getMessage();
        die('die2');
    } 
    return $pdo;
}
