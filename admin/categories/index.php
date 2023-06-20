<?php     
//Удаление всех записей связывающие шутки с этой категорией
    // include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
    //     try
    //         {
    //             $sql='DELETE FROM category WHERE id=:id';
    //             $s=$pdo->prepare($sql);
    //             $s->bindValue(':id', $_POST['id']);
    //             $s->execute();
    //         }
    //         catch (PDOException $e)
    //         {
    //             $error='Ошибка при удалении категории. ';
    //             include 'error.html.php';
    //             exit();
    //         }
    // //Удаляем категорию
    // try
    // {
    //     $sql='DELETE FROM jokecategory WHERE categoryid=:id';
    //     $s=$pdo->prepare($sql);
    //     $s->bindValue(':id', $_POST['id']);
    //     $s->execute();
    // }
    // catch (PDOException $e)
    // {
    //     $error='Ошибка при удалении шуток из категории. ';
    //     include 'error.html.php';
    //     exit();
    // } 
    
    ?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/welcome_with_php/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/welcome_with_php/includes/access.inc.php';
if (!userIsLoggedIn())
{
include '../login.html.php';
exit () ;
}
if (!userHasRole('Администратор сайта'))
{
$error='Доступ к этой странице имеет только администратор
сайта';
include '../accessdenied.html.php';
exit ();
}

//Добавление и редактирование автора
    include_once $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
    if (isset($_GET['add']))
    {
        $pageTitle='Новая категория';
        $action='addFrom';
        $name='';
        $id='';
        $button='Добавить категорию';
        include 'form.html.php';
        exit();
    }

    if (isset($_POST['action']) and $_POST['action']=='Добавить категорию')
    {
        include $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
         try
         {
            $sql='INSERT INTO category SET name=:name';
            $s=$pdo->prepare($sql);
            $s->bindValue(':name', $_POST['name']); 
            $s->execute();
         }
         catch (PDOException $e)
         {
            $error='Ошибка при добавлении категории. ';
            include 'error.html.php';
            exit();
         }
         header('Location: .');
         exit();
    }
    if (isset($_POST['action']) and $_POST['action']=='Редактировать')
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
        try
        {
            $sql='SELECT id, name FROM category WHERE id=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
           $error='Ошибка при извлечении информации о категории. ';
           include 'error.html.php';
           exit();
        }
        $row=$s->fetch();
        $pageTitle='Редактировать категорию';
        $action='editform';
        $name=$row['name'];
        $id=$row['id'];
        $button='Обновить информацию о категории';
        include 'form.html.php';
        exit();
    }

    if (isset($_GET['editform']))
    {
        include $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
         try
         {
            $sql='UPDATE category SET name=:name WHERE id=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->bindValue(':name', $_POST['name']); 
            $s->execute();
         }
         catch (PDOException $e)
         {
            $error='Ошибка при обновлении записи о категории. ';
            include 'error.html.php';
            exit();
         }
         header('Location: .');
         exit();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
    try
    {
        $result=$pdo->query('SELECT id, name from category');
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении категорий из базы данных!';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row)
    {
        $categories[]=array('id'=>$row['id'], 'name'=>$row['name']);
    }

    include 'categories.html.php';

    if (isset($_POST['action']) and $_POST['action']=='Удалить')
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
        try
            {
                $sql='DELETE FROM category WHERE id=:id';
                $s=$pdo->prepare($sql);
                $s->bindValue(':id', $_POST['id']);
                $s->execute();
            }
            catch (PDOException $e)
            {
                $error='Ошибка при удалении категории. ';
                include 'error.html.php';
                exit();
            }
    //Удаляем категорию
    try
    {
        $sql='DELETE FROM jokecategory WHERE categoryid=:id';
        $s=$pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error='Ошибка при удалении шуток из категории. ';
        include 'error.html.php';
        exit();
    } 

        header('Location: .');

        exit();
}
?>