<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php htmlout($pageTitle); ?></title>
    <style type="text/css">
        textarea{
            display: block;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1><?php htmlout($pageTitle); ?></h1>
 <form action="?<?php htmlout($action); ?>" method="post">
    <div>
        <label for="joketext">Введите сюда свою шутку: </label>
        <textarea name="joketext" id="joketext" cols="40" rows="10">
            <?php htmlout($text); ?>
        </textarea>
    </div>
    <div>
        <label for="author">
            Автор:
        </label>
        <select name="author" id="author">
            <option value="">Выбрать</option>
            <?php foreach($authors as $author): ?>
            <option value="<?php htmlout($authorid['id']); ?>"><?php 
                if ($author['id']==$authorid)
                {
                    echo 'selected';
                }
                ?>
                <?php htmlout($author['name']); ?></option>
                <?php endforeach; ?>
        </select>
    </div>
    <fieldset>
        <legend>Категории:</legend>
        <?php foreach($categories as $category): ?>
            <div><label for="category<?php htmlout($category['id']); ?>">
            <input type="checkbox" name="categories[]" id="category<?php htmlout($category['id']); ?>"
            value="<?php htmlout($category['id']); ?>"
            <?php if ($category['selected'])
            {
                echo 'checked';
            } ?>><?php htmlout($category['name']); ?></label></div>
            <?php endforeach; ?>
    </fieldset>
    <div><input type="submit" value="Добавить"></div>
 </form>   
</body>
</html>