<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/helpers.inc.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление шутками: результаты поиска</title>
</head>

<body>
    <h1>результаты поиска</h1>
    <?php if(isset($jokes)): ?>
        <table>
            <tr>
                <th>Текст шутки</th>
                <th>Действия</th>
            </tr>
            <?php foreach ($jokes as $joke) : ?>
                <tr>
                    <td><?php htmlout($joke['text']); ?></td>
                    <td>
                    <form action="?" method="post">
                        <div>
                            <input type="hidden" name="id" value="<?php htmlout($joke['id']); ?>">
                            <input type="submit" name="action" value="Редактировать">
                            <input type="submit" name="action" value="Удалить">
                        </div>
                    </form>
                    </td>
                </tr>
                <?php endforeach; ?>
        </table>
        <?php endif; ?>
    <p><a href="?">Искать заново</a></p>
    <p><a href="..">Вернуться на главную страницу</a></p>
    <?php include '../logout.inc.html.php'; ?>
</body>

</html>