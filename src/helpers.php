<?php
session_start();
require_once __DIR__ . '/config.php';
function redirect(string $path)
{
    header("Location: $path");
    die();
}
// Встановлюємо з'єднання з базою даних
function getPDO(): PDO
{
    return new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8;dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD
    );
}
// Знаходимо користувача в базі даних за його email
function findUser(string $email): array|bool
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Отримуємо поточного користувача з бази даних
function currentUser(): array|false
{
    $pdo = getPDO();
    // Перевіряємо, чи існує користувач в сесії
    if (!isset($_SESSION['user'])) {
        return false;
    }
    // Отримуємо ID користувача з сесії
    $userId = $_SESSION['user']['id'] ?? null;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Виходимо з облікового запису користувача
function logout(): void
{
    unset($_SESSION['user']['id']);
    redirect('/');
}
// Перевіряємо, чи користувач авторизований
function checkAuth(): void
{
    if (!isset($_SESSION['user']['id'])) {
        redirect('/');
    }
}
// Перевіряємо, чи користувач є гостем
function checkGuest(): void
{
    if (isset($_SESSION['user']['id'])) {
        redirect('/home.php');
    }
}
// Генеруємо сіль для хешування пароля
/**
 * @throws Exception
 */
function generateSalt($length = 16): string
{
    return bin2hex(random_bytes($length));
}
// Хешуємо пароль з використанням солі
function hashPasswordWithSalt($password, $salt): string
{
    return md5($password . $salt);
}
// Перевіряємо зашифрований пароль
function verifyEncryptedPassword($inputPassword, $encryptedPassword, $salt): bool
{
    // Хешуємо введений пароль з використанням солі та алгоритму MD5
    $inputPasswordHash = md5($inputPassword . $salt);
    // Порівнюємо отриманий хеш з зашифрованим паролем
    return ($inputPasswordHash === $encryptedPassword);
}
// Оновлюємо пароль користувача в базі даних
function updateUserPassword($userId, $encryptedPassword, $salt)
{    // Отримуємо об'єкт PDO, що представляє з'єднання з базою даних
    $pdo = getPDO();

    // SQL-запит для оновлення пароля та солі користувача
    $sql = 'UPDATE users SET password = :password, salt = :salt WHERE id = :id';

    // Підготовка SQL-запиту
    $statement = $pdo->prepare($sql);

    // Прив'язуємо параметри до певних змінних
    $statement->bindParam(':password', $encryptedPassword, PDO::PARAM_STR);
    $statement->bindParam(':salt', $salt, PDO::PARAM_STR);
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
}