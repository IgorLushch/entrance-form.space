<?php
require_once __DIR__ . '/../helpers.php';
// Видобуваємо дані з $_POST у окремі змінні
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
// Генеруємо сіль
$salt = generateSalt();
// Хешуємо пароль з використанням солі
$hashedPassword = hashPasswordWithSalt($password, $salt);
$pdo = getPDO();
$query = "INSERT INTO users (name, email, password, salt) VALUES (:name, :email, :password, :salt)";
$params = [
    'name' => $name,
    'email' => $email,
    'password' => $hashedPassword,
    'salt' => $salt
];
$stmt = $pdo->prepare($query);
try {
    $stmt->execute($params);
} catch (Exception $e) {
    die($e->getMessage());
}
redirect('/');