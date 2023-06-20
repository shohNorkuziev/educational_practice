<?php
include_once $_SERVER['DOCUMENT_ROOT'] .'/welcome_with_php/includes/magicquotes.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/welcome_with_php/includes/access.inc.php';
if (!userIsLoggedIn())
{
include '../login.html.php';
exit () ;
}
if (!userHasRole('Администратор учетных записей'))
{
$error='Доступ к этой странице имеет только администратор
учетных записей';
include '../accessdenied.html.php';
exit ();
}
//Добавление и редактирование автора
    include_once $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
    if (isset($_GET['add']))
    {
        include $_SERVER['DCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
        $pageTitle='Новый автор';
        $action='addFrom';
        $name='';
        $email='';
        $id='';
        $button='Добавить автора';
        try
        {
            $result = $pdo->query('SELECT id, description FROM role');
        }
        catch (PDOException $e)
        {
            $error='Ошибка при получении списка ролей. ' . $e->getMessage();
            include 'error.html.php';
            exit();
        }
        foreach ($result as $row)
        {
            $roles[]= array(
                'id' => $row['id'],
                'description' => $row['description'],
                'selected' => FALSE);
        }
        include 'form.html.php';
        exit();
    }

    if (isset($_POST['action']) and $_POST['action']=='Добавить автора')
    {
        include $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
         try
         {
            $sql='INSERT INTO author SET name=:name, email=:email';
            $s=$pdo->prepare($sql);
            $s->bindValue(':name', $_POST['name']);
            $s->bindValue(':email', $_POST['email']); 
            $s->execute();
         }
         catch (PDOException $e)
         {
            $error='Ошибка при добавлении автора. ';
            include 'error.html.php';
            exit();
         }


        $authorid = $pdo->lastInsertId();
        if ($_POST['password'] != '')
        {
        $password = md5($_POST['password'] . 'int_joke');
        try
        {
        $sql = 'UPDATE author SET
        password = :password
        WHERE id = : id' ;
        $s = $pdo->prepare($sql);
        $s->bindValue(':password', $password);
        $s->bindValue(':id', $authorid);
        $s->execute() ;
        }
        catch (PDOException $e)
        {
        $error = 'Ошибка при назначении пароля для автора.';
        include 'error.html.php';
        exit() ;
    }
    }

    if (isset($_POST['roles']))
    {
        foreach ($_POST['roles'] as $role)
        {
        try
        {
            $sql = 'INSERT INTO authorrole SET
            authorid = :authorid,
            roleid = :roleid';
            $s = $pdo->prepare($sql);
            $s->bindValue(':authorid', $authorid);
            $s->bindValue(':roleid', $role);
            $s->execute () ;
        }
        catch (PDOException $e)
        {
            $error = 'Ошибка при назначении роли для автора.';
            include 'error.html.php';
            exit() ;
        }
        }
        }
         header('Location: .');
         exit();
    }
    if (isset($_POST['action']) and $_POST['action']=='Редактировать')
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
        try
        {
            $sql='SELECT id, name, email FROM author WHERE id=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
           $error='Ошибка при извлечении информации об авторе. ';
           include 'error.html.php';
           exit();
        }
        $row=$s->fetch();
        $pageTitle='Редактировать автора';
        $action='editform';
        $name=$row['name'];
        $email=$row['email'];
        $id=$row['id'];
        $button='Обновить информацию об авторе';
        try
        {
            $sql = 'SELECT roleid FROM authorrole WHERE authorid = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $id);
            $s->execute () ;
        }
            catch (PDOException $e)
            {
            $error = 'Ошибка при получении списка назначенных ролей.';
            include 'error.html.php';
            exit();
            }
            $$selectedRoles = array();
            foreach ($s as $row)
            {
            $selectedRoles[] = $row['roleid'];
            }
            try{
            $result = $pdo->query('SELECT id, description FROM role');
            }
            catch (PDOException $e)
            {
            $error = 'Ошибка при получении списка ролей.';
            include 'error.html.php';
            exit();
            }
            foreach ($result as $row)
            {
            $roles[] = array(
            'id' => $row['id'],
            'description' => $row['description'],
            'selected' => in_array($row['id'], $selectedRoles));

        }
        include 'form.html.php';
        exit();
    }

    if (isset($_GET['editform']))
    {
        include $_SERVER['DOCUMENT_ROOT']. '/welcome_with_php/includes/db.inc.php';
         try
         {
            $sql='UPDATE author SET name=:name, email=:email WHERE id=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->bindValue(':name', $_POST['name']);
            $s->bindValue(':email', $_POST['email']); 
            $s->execute();
         }
         catch (PDOException $e)
         {
            $error='Ошибка при обновлении информации об авторе. ';
            include 'error.html.php';
            exit();
            //
            if ($_POST['password'] != '')
                {
                $password = md5($_POST['password'] . 'int_joke');
                try
                {
                $sql = 'UPDATE author SET
                password = :password
                WHERE id = :id';
                $s = $pdo->prepare($sql);
                $s->bindValue(': password', $password) ;
                $s->bindValue(':id', $_POST['id']);
                $s->execute ();
                }
                catch (PDOException $e){
                $error = 'Ошибка при назначении пароля автору.';
                include 'error.html.php';
                exit();
                }
            }
                try
                {
                $sql = 'DELETE FROM authorrole WHERE authorid = :id';
                $s = $pdo->prepare($sql) ;
                $s->bindValue(':id', $_POST['id']);
                $s->execute () ;
                }
                catch (PDOException $e)
                {
                $error = 'Ошибка при удалении неактуальных записей о ролях
                автора.';
                include 'error.html.php';
                exit() ;
                }
                if (isset($_POST['roles']))
                {
                foreach ($_POST['roles'] as $role)
                {
                try
                {
                $sql = 'INSERT INTO authorrole SET
                authorid = :authorid,
                roleid = :roleid';
                $s = $pdo->prepare($sql);
                $s->bindValue(':authorid', $_POST['id']);
                $s->bindValue(':roleid', $role);
                $s->execute () ;
                }
                catch (PDOException $e){
                $error = 'Ошибка при назначении автору заданных ролей.';
                include 'error.html.php';
                exit();
                }
            }
            }

                header('Location: .');
                exit();
        }
    }
    include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
    try
    {
        $result=$pdo->query('SELECT id, name from author');
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении атворов из базы данных!';
        include 'error.html.php';
        exit();
    }

    foreach ($result as $row)
    {
        $authors[]=array('id'=>$row['id'], 'name'=>$row['name']);
    }

    include 'authors.html.php';

    if (isset($_POST['action']) and $_POST['action']=='Удалить')
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/db.inc.php';
        try{
            $sql='DELETE FROM authorrole WHERE authorid = :id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error='Ошибка при удалении ролей автора.';
            include 'error.html.php';
            exit();
        }

        try{
            $sql='SELECT  id FROM joke WHERE authorid=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error='Ошибка при получении списка шуток, которые нужно удалить. ';
            include 'error.html.php';
            exit();
        }

        $result=$s->fetchAll();
        try
        {
            $sql='DELETE FROM jokecategory WHERE jokeid=:id';
            $s=$pdo->prepare($sql);
            foreach($result as $row)
            {
                $jokeid=$row['id'];
                $s->bindValue(':id', $jokeid);
                $s->execute();
            }
        }
        catch (PDOException $e)
        {
            $error='Ошибка при удалении записей о категориях шуток';
            include 'error.html.php';
            exit();
        } 

        try{
            $sql='DELETE   FROM joke WHERE authorid=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error='Ошибка при удалении шуток, принадлежащих атвору. ';
            include 'error.html.php';
            exit();
        }

        try
        {
            $sql='DELETE FROM author WHERE id=:id';
            $s=$pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error='Ошибка при удалении автора.';
            include 'error.html.php';
            exit();
        }

        header('Location: .');

        exit();
}
?>