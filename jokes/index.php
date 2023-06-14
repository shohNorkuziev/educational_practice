<?php 
    try
    {
        $sql='SELECT joke.id, joketext, name, email from joke INNER JOIN AUTHOR ON JOKE.authorid=author.id';
        $result=$pdo->query($sql);
    }
    catch (PDOException $e)
    {
        $error='Ошибка при извлечении шуток: '. $e->getMessage();
        include 'error.html.php';
        exit();
    }
    while ($row=$result->fetch())
    {
        $jokes[]=array(
            'id'=>$row['id'],
            'text'=>$row['joketext'],
            'name'=>$row['name'],
            'email'=>$row['email']
        );
    }
    include 'jokes.html.php';
?>