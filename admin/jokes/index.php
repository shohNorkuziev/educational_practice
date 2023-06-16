<?php
include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/magicquotes.inc.php';

// Поиск шуток
include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
    try
    {
        $result = $pdo->query('SELECT id, name FROM author');
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении записей об атворах! ';
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row)
    {
        $authors[]= array('id' => $row['id'], 'name'=> $row['name']);
    }
    try
    {
        $result = $pdo->query('SELECT id, name FROM category');
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении категорий из базы данных! ';
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row)
    {
        $categories[]= array('id' => $row['id'], 'name'=> $row['name']);
    }
    

    if(isset($_GET['action']) and $_GET['action'] == 'search')
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        $select = 'SELECT id, joketext';
        $from = ' FROM joke';
        $where = ' WHERE TRUE'; 
        
        if ($_GET['author'] != '')
            {
                $where .= " AND authorid = :authorid";
                $placeholders[':authorid'] = $_GET['author'];
            }
        if ($_GET['category'] != '')
            {
                $from .= ' INNER JOIN jokecategory ON id = jokeid';
                $where .= " AND categoryid = :categoryid";
                $placeholders[':categoryid'] = $_GET['category'];
            }
        if ($_GET['text'] != '')
            {
                $where .= " AND joketext LIKE :joketext";
                $placeholders[':joketext'] ='%'. $_GET['text'] . '%';
            }
        
        try
        {
            $sql = $select . $from .$where;
            $s = $pdo->prepare($sql);
            $s->execute($placeholders);
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении шуток. '; 
            include 'error.html.php'; 
            exit();
        }
        foreach ($s as $row)
        {
            $jokes[] = array('id' => $row['id'], 'text'=> $row['joketext']);
        }
        include 'jokes.html.php';
        exit();
    }
  

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

// Удаление шутки
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
// include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
// try
// {
//     $sql = 'SELECT joke.id, joketext, name, email from joke INNER JOIN author ON joke.authorid=author.id';
//     $result = $pdo->query($sql);
// }
// catch(PDOException $e)
// {
//     $error = 'Ошибка при извлечении шуток: '. $e->getMessage();
//     include 'error.html.php';
//     exit();
// }
// while ($row=$result->fetch())
// {
//     $jokes[] = array(
//         'id'=>$row['id'],
//         'text'=>$row['joketext'],
//         'name'=>$row['name'],
//         'email'=>$row['email']
//     );
// }
// include 'jokes.html.php';
include 'searchform.html.php';
include 'footer.inc.html.php';
?>