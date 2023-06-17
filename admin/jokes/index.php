<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/magicquotes.inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
   
if  (isset($_GET['addjoke']))
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        $pageTitle= 'Новая шутка';
        $action = 'addform';
        $text='';
        $authorid = '';
        $button = 'Добавить шутку';
        
        // Формируем список авторов
        try
        {
            $result = $pdo->query('SELECT id, name FROM author');
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении списка атворов. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        foreach ($result as $row)
        {
            $authors[] = array('id' => $row['id'], 'name' => $row['name']);
        }
        
        
        // Формируем список категории
        try
        {
            $result = $pdo->query('SELECT id, name FROM category');
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении списка категорий. ' . $e->getMessage();
            include 'error.html.php';
            exit(); 
        }
        foreach ($result as $row)
        {
            $categories[]= array(
                'id'=> $row['id'],
                'name'=> $row['name'],
                'selected'=> FALSE,);
            
        }
        include 'form.html.php';
            exit();
    }

    if (isset($_POST['action']) and $_POST['action'] == 'Редактировать')
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        try
        {
            $sql = 'SELECT id, joketext, authorid FROM joke WHERE id =:id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении информации о шутке. ' . $e->getMessage();
            include 'error.html.php';
            exit(); 
        }
        $row = $s->fetch();
        $pageTitle= 'Редактировать шутку';
        $action = 'editform';
        $text=$row['joketext'];
        $authorid = $row['authorid'];
        $id = $row['id'];
        $button = 'Обновить шутку';
        try 
        {
            $result = $pdo->query('SELECT id, name FROM author'); 
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении списка атворов. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        foreach ($result as $row)
        {
            $authors[]= array('id' => $row['id'], 'name'=> $row['name']);
        }
        try
        {
            $sql = 'SELECT categoryid FROM jokecategory WHERE jokeid =:id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении списка выбранных категорий. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        foreach ($s as $row)
        {
            $selectedCategories[] = $row['categoryid'];
        }
        try
        {
            $result = $pdo->query('SELECT id, name FROM category'); 
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении списка категорий. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        foreach ($result as $row){
            $categories[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'selected' => in_array($row['id'],$selectedCategories)
            );
            
           
        }
        include 'form.html.php';
        exit();
    }

    // Проверка на пустую строку
    if (isset($_POST['action']) and $_POST['action'] == 'Добавить шутку')
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        if ($_POST['author'] == '')
        {
            $error = 'Вы должны выбрать атвора для этой шутки. Вернитесь назад  и попробуйте еще раз';
            include 'error.html.php';
            exit();
        }
        try
        {
            $sql = 'INSERT INTO joke SET joketext = :joketext, jokedate = CURDATE() , authorid = :authorid';
            $s = $pdo->prepare($sql);
            $s->bindValue(':joketext', $_POST['joketext']);
            $s->bindValue(':authorid', $_POST['author']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при добавлении шутки. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        $jokeid = $pdo->lastInsertId();
        if(isset($_POST['categories']))
        {
        try
        {
            $sql = 'INSERT INTO jokecategory SET
            jokeid = :jokeid,
            categoryid = :categoryid';
            $s = $pdo->prepare ($sql);
            foreach ($_POST['categories'] as $categoryid)
                {
                    $s->bindValue(':jokeid', $jokeid);
                    $s->bindValue(":categoryid", $categoryid);
                    $s->execute () ;
                }
        }
            catch (PDOException $e)
            {
                $error='Ошибка при добавлении шутки в выбранные категории.' . $e->getMessage();
                include 'error.html.php';
                exit () ; 
            }
        }
            header('Location: .');
            exit ();
    }

    //Редактирование шутки
    if (isset($_POST['action']) and $_POST['action'] == 'Обновить шутку')
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        if ($_POST['author'] == '')
        {
            $error = 'Вы должны выбрать автора для этой шутки. Вернитесь назад и попробуйте еще раз ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        try
        {
            $sql = 'UPDATE joke SET joketext =:joketext, authorid = :authorid WHERE id =:id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->bindValue(':joketext', $_POST['joketext']);
            $s->bindValue(':authorid', $_POST['author']);
            $s->execute();
        }    
        catch (PDOException $e)
            {
            $error='Ошибка при обновлении шутки.' . $e->getMessage();
            include 'error.html.php';
            exit () ; 
            }
        try
        {
            $sql = 'DELETE FROM jokecategory WHERE jokeid= :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }    
        catch (PDOException $e)
            {
            $error='Ошибка при удалении лишних записей относительно категорий шутки.' . $e->getMessage();
            include 'error.html.php';
            exit () ; 
            }
        if (isset($_POST['categories']))
        {
            try
            {
                $sql = 'INSERT INTO jokecategory SET
                jokeid =:jokeid,
                categoryid = :categoryid';
                $s = $pdo->prepare($sql);
                foreach ($_POST['categories'] as $categoryid)
                {
                    $s->bindValue(':jokeid', $_POST['id']);
                    $s->bindValue(':categoryid', $categoryid);
                    $s->execute(); 
                }
            }    
            catch (PDOException $e)
                {
                $error='Ошибка при добавлении шутки в выбранные категории.' . $e->getMessage();
                include 'error.html.php';
                exit () ; 
                }  
        }
        header('Location: .');
        exit();
    
    }

    //Удаление шуток

    if (isset($_POST['action']) and $_POST['action'] == 'Удалить')
    {
        include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
        try
        {
            $sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }    
        catch (PDOException $e)
            {
            $error='Ошибка при удалении шутки из категорий.' . $e->getMessage();
            include 'error.html.php';
            exit () ; 
            }
        try
        {
            $sql = 'DELETE FROM joke WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }    
        catch (PDOException $e)
            {
            $error='Ошибка при удалении шутки.' . $e->getMessage();
            include 'error.html.php';
            exit () ; 
            }
        
       
        header('Location: .');
        exit();
    
    }




// Поиск шуток

    try
    {
        $result = $pdo->query('SELECT id, name FROM author');
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении записей об атворах! ' . $e->getMessage();
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
        $error='Ошибка при извлечении категорий из базы данных! ' . $e->getMessage();
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
            if(isset($placeholders)){
                $s->execute($placeholders);
            }
            else{
                $s->execute();
            }
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при извлечении шуток. ' . $e->getMessage(); 
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
  
    //Удаление шуток


if (isset($_GET['addjoke']))
{
    include 'form.html.php';
    exit();
}

// if (isset($_POST['joketext']))
// {
//     include $_SERVER['DOCUMENT_ROOT'].'/welcome_with_php/includes/db.inc.php';
//     try
//     {
//         $sql = 'INSERT INTO joke SET
//         joketext = :joketext,
//         jokedate = CURDATE()';
//         $s = $pdo->prepare($sql);
//         $s->bindValue(':joketext', $_POST['joketext']);
//         $s->execute();
//     }
//     catch(PDOException $e)
//     {
//         $error = 'Ошибка при добавлении шутки: '. $e->getMessage();
//         include 'error.html.php';
//         exit();
//     }
//     header('Location: .');
//     exit();
// }

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