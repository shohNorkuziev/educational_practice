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
    <?php if (isset($_GET['addjoke']))
    {
        include 'form.html.php';
        exit();
    } 
    ?>
</body>
</html>