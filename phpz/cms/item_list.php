<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM ec_table");
$status = $stmt->execute();

$view="";
if($status==false) {

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{

  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    $view .= '<li>';
    $view .= '<p><img src="../img/'.$res["fname"].'"width="200"></p>';
    $view .= '<h2>'.$res["item"].'</h2>';
    $view .= '<p>¥'.$res["value"].'</p>';
    $view .= '</a>'.'<a href="delete.php?id='.$res["id"].'">'.'[削除]'.'</a>';
    $view .= '</li>';
  }

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
<h1>管理画面</h1>
<ul>
    <?=$view?>
</ul>

<li>
  <a href="item.php">商品登録</a>
</li>
    
<script src="js/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

</body>
</html>

<!-- <li>
        <p><img src="../img/"width="200"></p>
        <h2></h2>
        <p></p>
        <a href="#" class="btn-delete">削除</a>
    </li> -->