<?php
require_once __DIR__ . '/src/helpers.php';
// Перевіряємо, чи існує куки користувача для авторизації
checkAuth();
// Отримуємо дані поточного користувача
$user = currentUser();
?>
<!DOCTYPE html>
<html lang="ua" data-theme="light">
<?php include_once __DIR__ . '/components/head.php'?>
<body>
<div class="card home">
    <img
    class="avatar"
    src="src/img/avatar_1697304085.jpg"
    alt="<?php echo $user['name'] ?>"
    >
    <h1>Привіт, <?php echo $user['name'] ?>!</h1>
    <form action="src/actions/logout.php" method="post">
        <button role="button">Вийти з аккаунта</button>
    </form>
    <form action="src/actions/change.php" method="post">
        <label>
            <input type="password" name="current_password" placeholder="Поточний пароль" required>
            <input type="password" name="new_password" placeholder="Новий пароль" required>
        </label>
        <button type="submit" name="change_password">Змінити пароль</button>
    </form>
</div>
</body>
</html>