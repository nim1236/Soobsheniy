<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
session_start();
require 'db.php'; // Подключаем файл с подключением к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Проверка на пустые поля
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Пожалуйста, заполните все поля!";
        header('Location: index.php');
        exit;
    }

    try {
        // Проверка на существование email
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Пользователь с таким email уже существует.";
            header('Location: index.php');
            exit;
        }

        // Хешируем пароль
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Добавляем нового пользователя
        $stmt = $pdo->prepare("INSERT INTO user (Nick, Email, Password) VALUES (:username, :email, :password)");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        // Сохраняем данные пользователя в сессии
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;

        // Перенаправляем на страницу аккаунта
        header('Location: account.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка базы данных: " . htmlspecialchars($e->getMessage());
        header('Location: index.php');
        exit;
    }
}
?>
