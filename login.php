<?php
session_start();
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']); // Удаляем ошибку после отображения
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="background">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="container">
        <h1>Вход</h1>
        <form action="login_proverka.php" method="POST">
            <label for="login">Никнейм или почта</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Войти</button>
        </form>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <p>Нет аккаунта?</p>
        <a href="index.php" class="secondary-button">Зарегистрироваться</a>
    </div>
</body>
</html>
