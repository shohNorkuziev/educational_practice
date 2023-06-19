<?php 
    include_once $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/helpers.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление категорями</title>
</head>
<body>
    <h1> Управление категориями</h1>
    <p><a href="?add">Добавьте новую категорию</a></p>
    <ul>
        <?php foreach ($categories as $category): ?>
        <li>
            <form action="" method="post">
                <div>
                    <?php htmlout($category['name']); ?>
                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
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