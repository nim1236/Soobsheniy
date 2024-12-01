<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Если пользователь не вошел, перенаправить на страницу входа
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мессенджер</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .header {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        text-align: center;
    }

    .chat-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        padding: 20px;
    }

    .message {
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        max-width: 60%;
    }

    .message.user {
        background-color: #d1ecf1;
        align-self: flex-end;
    }

    .message.bot {
        background-color: #f8d7da;
        align-self: flex-start;
    }

    .message-input {
        display: flex;
        padding: 10px;
        background-color: #e9ecef;
    }

    .message-input input {
        flex: 1;
        padding: 15px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .message-input button {
    margin-left: 10px;
    padding: 5px 0; /* Убираем боковые отступы */
    font-size: 14px;
    width: 20%; /* Ширина кнопки в процентах */
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}


    .message-input button:hover {
        background-color: #5a6268;
    }
</style>
</head>
<body>
    <div class="header">
        <h1>Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</h1>
    </div>
    <div class="chat-container" id="chat-container">
        <!-- Сообщения будут добавляться сюда -->
        <div class="message bot">Привет! Как я могу помочь?</div>
    </div>
    <div class="message-input">
        <input type="text" id="message" placeholder="Введите сообщение...">
        <button onclick="sendMessage()">Отправить</button>
    </div>
    <script>
        function sendMessage() {
            const chatContainer = document.getElementById('chat-container');
            const messageInput = document.getElementById('message');
            const userMessage = messageInput.value;

            if (userMessage.trim() !== '') {
                // Добавляем сообщение пользователя
                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'message user';
                userMessageDiv.textContent = userMessage;
                chatContainer.appendChild(userMessageDiv);

                // Ответ бота
                const botMessageDiv = document.createElement('div');
                botMessageDiv.className = 'message bot';
                botMessageDiv.textContent = 'Вы сказали: ' + userMessage;
                chatContainer.appendChild(botMessageDiv);

                // Прокрутка вниз
                chatContainer.scrollTop = chatContainer.scrollHeight;

                // Очистить поле ввода
                messageInput.value = '';
            }
        }
    </script>
</body>
</html>
