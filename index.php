<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Удаляем ошибку из сессии, чтобы не отображалась повторно
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="background">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="container">
        <h1>Регистрация</h1>
        <form action="register.php" method="POST">
            <label for="username">Никнейм</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Почта</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Зарегистрироваться</button>

            <!-- Вывод сообщения об ошибке -->
            <?php if (!empty($error)): ?>
                <p style="color: red; margin-top: 10px;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </form>
        <p>Уже есть аккаунт?</p>
        <a href="login.php" class="secondary-button">Войти</a>
    </div>
</body>
</html>
