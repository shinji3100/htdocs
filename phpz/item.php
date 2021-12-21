<?php
session_start();


if(!isset($_GET["id"]) || $_GET["id"]==""){
    exit("ParamError");
}else{
    $id = intval($_GET["id"]);
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM ec_table WHERE id=:id");
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();


$view="";
if($status==false) {

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{

  $row = $stmt->fetch();
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
<form action="cartadd.php" method="post">

<p><img src="./img/<?=$row["fname"]?>" width="200"></p>
<h1><?=$row["item"]?></h1>
<p>¥<?=$row["value"]?></p>
<p>個数 : <input type="number" value="1" name="num"></p>
<input type="submit" value="カートに入れる">


<p><?=$row["description"]?></p>
<input type="hidden" name="item" value="<?=$row["item"]?>">
<input type="hidden" name="value" value="<?=$row["value"]?>">
<input type="hidden" name="id" value="<?=$row["id"]?>">
<input type="hidden" name="fname" value="<?=$row["fname"]?>">
</form>
  <ul>
    <?=$view;?>
  </ul>
</body>
</html>
