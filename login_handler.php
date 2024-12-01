<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Предположим, что пользователь всегда вводит корректные данные
    // В реальном проекте замените на проверку из базы данных
    $_SESSION['username'] = "ExampleUser"; // Замените на реальный никнейм, связанный с почтой
    header('Location: messenger.php');
    exit;
}
?>
