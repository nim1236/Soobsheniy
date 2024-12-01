<?php
session_start();
require 'db.php'; // Подключение к базе данных

if (!isset($_SESSION['user_id'])) {
    // Если пользователь не вошел, перенаправляем на страницу входа
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Получение ника текущего пользователя
$query_user = $pdo->prepare("SELECT Nick FROM user WHERE id = ?");
$query_user->execute([$user_id]);
$user = $query_user->fetch();

if (!$user) {
    echo "Пользователь не найден.";
    exit;
}

// Получение списка друзей
$query_friends = $pdo->prepare("
    SELECT u.Nick 
    FROM friends f 
    JOIN user u ON u.id = f.friend_id 
    WHERE f.user_id = ?
");
$query_friends->execute([$user_id]);
$friends = $query_friends->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аккаунт</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
        }

        .friends-list {
            margin-top: 20px;
            list-style: none;
            padding: 0;
        }

        .friends-list li {
            padding: 10px;
            border: 1px solid #ccc;
            margin: 5px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .btn-search {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-search:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать, <?php echo htmlspecialchars($user['Nick']); ?>!</h1>
        <h2>Список друзей</h2>
        <ul class="friends-list">
            <?php if (count($friends) > 0): ?>
                <?php foreach ($friends as $friend): ?>
                    <li><?php echo htmlspecialchars($friend['Nick']); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>У вас пока нет друзей.</li>
            <?php endif; ?>
        </ul>
        <a href="find_friends.php" class="btn-search">Поиск друзей</a>
    </div>
</body>
</html>
