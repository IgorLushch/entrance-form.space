<?php
// Відкриваємо PHP блок
// Підключаємо допоміжний файл helpers.php
require_once __DIR__ . '/../helpers.php';
// Отримуємо значення email з POST запиту або присвоюємо null, якщо відсутнє
$email = $_POST['email'] ?? null;
// Отримуємо значення password з POST запиту або присвоюємо null, якщо відсутнє
$password = $_POST['password'] ?? null;
// Шукаємо користувача за його email в базі даних
$user = findUser($email);
// Якщо користувача не знайдено
if (!$user) {
    redirect('/');
}
// Отримуємо сіль та зашифрований пароль користувача з бази даних
$salt = $user['salt'];
$encryptedPassword = $user['password'];
// Перевіряємо введений пароль, використовуючи сіль та алгоритм MD5
if (!verifyEncryptedPassword($password, $encryptedPassword, $salt)) {
    redirect('/index.php');
}
// Зберігаємо ID користувача в сесії
$_SESSION['user']['id'] = $user['id'];
redirect('/home.php');