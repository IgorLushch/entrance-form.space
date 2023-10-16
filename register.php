<?php
require_once __DIR__ . '/src/helpers.php';
// Перевірка, чи не залогінений користувач
checkGuest();
?>
<!DOCTYPE html>
<html lang="ua" data-theme="light">
<?php
include_once __DIR__ . '/components/head.php'
?>
<body>
<form class="card" action="src/actions/register.php" method="post" >
    <h2>Реєстрація</h2>
    <label for="name">
        Ім'я
        <input
            type="text"
            id="name"
            name="name"
            placeholder="Призвіще Ім'я"
            required
        >
    </label>
    <label for="email">
        E-mail
        <input
            type="text"
            id="email"
            name="email"
            placeholder="example@mail.com"
            required
        >
    </label>
    <div class="grid">
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
    </div>
    <button
        type="submit"
        id="submit"
    >Продовжити</button>
</form>
<p>У мене вже є <a href="/">аккаунт</a></p>
</body>
</html>