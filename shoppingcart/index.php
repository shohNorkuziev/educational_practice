<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/welcome_with_php/includes/magicquotes.inc.php';
$items=array(
array('id'=>'1', 'desc'=>'Англо-русский словарь',
'price'=>24.95),
array('id'=>'2', 'desc'=>'Практически новый парашют',
'price'=>1000),
array('id'=>'3', 'desc'=>'Песни группы Любэ (набор из 2 CD)',
'price'=>19.99),
array('id'=>'4', 'desc'=>'Просто JavaScript', 'price'=>39.95));
session_start();

if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = array();
}

//Кнопка купить
if (isset($_POST['action']) and $_POST['action'] =='купить')
{
    $_SESSION['cart'][]=$_POST['id'];
    header('Location: .');
    exit();
}

// Очистить корзину
if (isset($_POST['action']) and $_POST['action'] == 'Очистить корзину')
{
    unset($_SESSION['cart']);
    header('Location: ?cart');
    exit();
}
// Просмотреть корзину
if (isset($_GET['cart']))
{
    $cart = array();
    $total=0;
    foreach ($_SESSION['cart'] as $id)
    {
    foreach ($items as $product)
    {
        if ($product['id']==$id)
        {
            $cart[]=$product;
            $total+= $product['price'];
            break;
        }
    }
}
include 'cart.html.php';
exit();
}
include 'catalog.html.php';
?>