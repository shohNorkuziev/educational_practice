<?php 
    include_once $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление авторами</title>
</head>
<body>
    <h1> Управление атворами</h1>
    <p><a href="?add">Добавьте нового автора</a></p>
    <ul>
        <?php foreach ($authors as $author): ?>
        <li>
            <form action="" method="post">
                <div>
                    <?php htmlout($author['name']); ?>
                    <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
                    <input type="submit" name="action" value="Редактировать">
                    <input type="submit" name="action" value="Удалить">
                </div>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
    <p><a href="..">Вернуться на главную страницу</a></p>
    <?php include '../logout.inc.html.php'; ?>
</body>
</html>