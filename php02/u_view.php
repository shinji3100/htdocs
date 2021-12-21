<?php
//1.getでid値を取得
$id = $_GET["id"];
// echo $id;
// exit;
//2.DB接続
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした'.$e->getMessage());
}

//3.SELECT文
$sql = "SELECT * FROM gs_an_table WHERE id=:id";//条件つけるのにwhereをつける
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4.データ表示
$view="";
if($status==false){
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

<form method="post" action="update.php">
    <div class="jumbotron">
        <fieldset>
            <legend>フリーアンケート</legend>
            <label>名前:<input type="text" name="name" value="<?=$row["name"]?>"></label><br>
            <label>Email:<input type="text" name="email" value="<?=$row["email"]?>"></label><br>
            <label><textArea name="naiyou" rows="4" cols="40"><?=$row["naiyou"]?></textArea></label><br>
            <input type="hidden" name="id" value="<?=$row["id"]?>">
            <input type="submit" value="送信">
        </fieldset>
    </div>
</form>
    
</body>
</html>