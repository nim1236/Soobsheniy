<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';
$results = [];

// Поиск друзей
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $query_search = $pdo->prepare("SELECT id, Nick FROM user WHERE Email = ? AND id != ?");
    $query_search->execute([$email, $user_id]);
    $results = $query_search->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        $error = "Пользователь с таким email не найден.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск друзей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Поиск друзей</h1>
        <form action="find_friends.php" method="POST">
            <label for="email">Введите email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Найти</button>
            </form>
        <button onclick="window.location.href='account.php'" class="btn-back">Назад</button>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($results)): ?>
            <h2>Результаты поиска:</h2>
            <ul>
                <?php foreach ($results as $user): ?>
                    <li>
                        <?php echo htmlspecialchars($user['Nick']); ?>
                        <form action="add_friend.php" method="POST" style="display:inline;">
                            <input type="hidden" name="friend_id" value="<?php echo $user['id']; ?>">
                            <button type="submit">Добавить в друзья</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
