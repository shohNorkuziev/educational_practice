<?php  include_once $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/helpers.inc.php';  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
   <h1>Вход</h1>
   <p>Пожалуйста, войдите в систему, чтобы посмотреть страницу, к которой вы обратились</p>
   <?php if (isset($loginError)): ?>
    <p><?php htmlout($loginError); ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <div>
            <label for="email">Email: <input type="text" name="email" id="email"></label>
        </div>
        <div>
            <label for="password">Пароль:
                <input type="password" name="password" id="password">
            </label>
        </div>
        <div>
            <input type="hidden" name="action" value="login">
            <input type="submit" value="Войти">
        </div>
        <p><a href="/welcome_with_php/admin/">Вернуться на главную страницу</a></p>
    </form>
</body>
</html>