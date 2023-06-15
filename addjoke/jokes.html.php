<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/helpers.inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p><a href="?addjoke">Добавьте собственную шутку</a></p>
    <p> Все шутки, которые етсть в базе данных:</p>
    <?php foreach ($jokes as $joke) : ?>
        <form action="?deletejoke" method="post">
            <blockquote>
                <p>
                    <?php echo htmlout($joke['text']);?>
                    <input type="hidden" name="id" value="<?php echo $joke['id']; ?>">
                    <input type="submit" value="Удалить">
                    <a href="mailto:
                    <?php echo htmlout($joke['email']); ?>">
                    <?php echo htmlout($joke['name']); ?>
                    </a>
                </p>
            </blockquote>
        </form>
    <?php endforeach; ?>
</body>

</html>