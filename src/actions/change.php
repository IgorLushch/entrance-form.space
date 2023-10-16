<?php
// Підключаємо допоміжний файл helpers.php
require_once __DIR__ . '/../helpers.php';
// Отримуємо поточного користувача
$user = currentUser();
// Перевіряємо, чи було відправлено POST запит та чи була натиснута кнопка зміни пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    // Отримуємо значення введених користувачем паролів
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    // Перевірка поточного пароля
    $salt = $user['salt'];
    $encryptedPassword = $user['password'];
if (verifyEncryptedPassword($currentPassword, $encryptedPassword, $salt)) {
    // Якщо все вірно, то оновлюємо пароль в базі даних
    $newSalt = generateSalt();
    $newEncryptedPassword = md5($newPassword . $newSalt);
    // Оновлюємо пароль користувача в базі даних
    updateUserPassword($user['id'], $newEncryptedPassword, $newSalt);
    }
}
// Перенаправляємо користувача на сторінку home.php
redirect('/home.php');