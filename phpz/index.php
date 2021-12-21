<?php
session_start();


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
    $view .= '<a href="item.php?id='.$res["id"].'">';
    $view .= '<p><img src="./img/'.$res["fname"].'"width="200"></p>';
    $view .= '<h3>'.$res["item"].'</h3>';
    $view .= '<p>¥'.$res["value"].'</p>';
    $view .= '</a>';
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
<h1>商品一覧</h1>
  <ul>
    <?=$view;?>
  </ul>
</body>
</html>
