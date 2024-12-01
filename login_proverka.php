<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$dbname = 'users';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars($_POST['login']); // Ник или почта
    $password = $_POST['password']; // Пароль

    // Проверка пользователя в базе данных
    $query = "SELECT * FROM user WHERE (Nick = :login OR Email = :login)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        // Успешный вход
        $_SESSION['username'] = $user['Nick']; // Сохраняем ник в сессии
        header('Location: account.php'); // Перенаправление на мессенджер
        exit;
    } else {
        // Неверные данные
        $error = "Неверный логин или пароль.";
        $_SESSION['login_error'] = $error; // Сохраняем ошибку в сессии
        header('Location: login.php'); // Возвращаемся на страницу входа
        exit;
    }
}
