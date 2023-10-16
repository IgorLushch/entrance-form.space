<?php
require_once __DIR__ . '/src/helpers.php';
// Перевіряємо, чи є користувач гостем (ця функція перенаправляє користувача, якщо він вже авторизований)
checkGuest();
?>
<!DOCTYPE html>
<html lang="ua" data-theme="light">
<?php include_once __DIR__ . '/components/head.php'?>
<body>
<form class="card" action="src/actions/login.php" method="post">
    <h2>Вхід</h2>
    <label for="email">
        Email
        <input
                type="text"
                id="email"
                name="email"
                placeholder="example@mail.com"
                required
        >
    </label>
    <label for="password">
        Пароль
        <input
                type="password"
                id="password"
                name="password"
                placeholder="******"
                required
        >
    </label>
    <button
            type="submit"
            id="submit"
    >Продовжити</button>
<p>У мене ще немає <a href="/register.php">аккаунта</a></p>
</body>
</html>
