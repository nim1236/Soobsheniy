<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$friend_id = $_GET['friend_id'] ?? null;

if ($friend_id && $friend_id != $user_id) {
    // Проверяем, не добавлен ли пользователь уже в друзья
    $query_check_friend = $pdo->prepare("
        SELECT 1 
        FROM friends 
        WHERE user_id = ? AND friend_id = ?
    ");
    $query_check_friend->execute([$user_id, $friend_id]);
    $is_friend = $query_check_friend->fetchColumn();

    if (!$is_friend) {
        // Добавляем друга
        $query_add_friend = $pdo->prepare("
            INSERT INTO friends (user_id, friend_id) 
            VALUES (?, ?)
        ");
        $query_add_friend->execute([$user_id, $friend_id]);

        // Добавляем обратную связь
        $query_add_reverse_friend = $pdo->prepare("
            INSERT INTO friends (user_id, friend_id) 
            VALUES (?, ?)
        ");
        $query_add_reverse_friend->execute([$friend_id, $user_id]);
    }
}

// Возвращаем на страницу поиска
header('Location: search.php');
exit;
