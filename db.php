<?php
// Настройки подключения к базе данных
$host = 'localhost'; // Имя хоста (обычно localhost)
$dbname = 'users';   // Имя базы данных
$user = 'root';      // Имя пользователя базы данных
$password = '';      // Пароль пользователя базы данных

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Устанавливаем режим обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
