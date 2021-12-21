<?php

session_start();

$view = '';
$sum = '';
foreach($_SESSION["cart"] as $key => $value){
    $view .= '<li>';
    $view .= '<p><img src="./img/'.$value[3].'"width="200"></p>';
    $view .= '<h2>'.$value[0].'</h2>';
    $view .= '<p>¥'.$value[1]*$value[2].'</p>';
    $view .= '<p>個数:'.$value[2].'</p>';
    $view .= '<a href="cartremove.php?id='.$key.'" class="btn-delete">削除</a>';
    $view .= '</li>';
    // $sum .= $value[1]*$value[2]
}


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

<h1>Cart</h1>
<!-- <p><?=$view;?></p> -->
<!-- <ul>
    <li>商品写真</li>
    <li>商品名</li>
    <li>金額</li>
    <li>数量</li>
    <li>削除</li>
</ul> -->
<ul>
    <?=$view;?>
</ul>
<ul>
    <li><a href="index.php">買い物を続ける</a></li>
    <li><a onclick="alert('外部決済サイトに移動')">レジに進む</a></li>
</ul>
    
</body>
</html>