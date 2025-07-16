<?php
$dsn = 'mysql:host=localhost;dbname=coursework;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $output = 'Unable to connect to the database server: ' . $e->getMessage();
}
