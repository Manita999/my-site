<?php
$host = 'localhost';
$dbname = 'creative_workshop';
$username = 'root'; // Замените на вашего пользователя MySQL
$password = ''; // Замените на ваш пароль MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>