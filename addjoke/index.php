<?php
include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/magicquotes.inc.php';

if (isset($_GET['addjoke']))
{
    include 'form.html.php';
    exit();
}

if (isset($_POST['joketext']))
{
    include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO joke SET
        joketext = :joketext,
        jokedate = CURDATE()';
        $s = $pdo->prepare($sql);
        $s->bindValue(':joketext', $_POST['joketext']);
        $s->execute();
    }
    catch(PDOException $e)
    {
        $error = 'Ошибка при добавлении шутки: '. $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
if (isset($_GET['deletejoke']))
{
    include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
    try
    {
        $sql = 'DELETE FROM joke where id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка при удалении шутки: '. $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
try
{
    $sql = 'SELECT joke.id, joketext, name, email from joke INNER JOIN author ON joke.authorid=author.id';
    $result = $pdo->query($sql);
}
catch(PDOException $e)
{
    $error = 'Ошибка при извлечении шуток: '. $e->getMessage();
    include 'error.html.php';
    exit();
}
while ($row=$result->fetch())
{
    $jokes[] = array(
        'id'=>$row['id'],
        'text'=>$row['joketext'],
        'name'=>$row['name'],
        'email'=>$row['email']
    );
}
include 'jokes.html.php';
include 'samplepage.html.php';
?>