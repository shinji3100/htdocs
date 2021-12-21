<?php
//1.getでid値を取得
$id = $_GET["id"];
// exit;
//2.DB接続
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした'.$e->getMessage());
}

//3.SELECT文
$sql = "SELECT * FROM kadai_table WHERE id=:id";//条件つけるのにwhereをつける
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

var_dump("$row");

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
    <form class="form2" action="hensyu_act.php" method="post" enctype="multipart/form-data">
            <p class="cms-thumb"><img src="" alt="" width="200" value="<?=$row['fname']?>"></p>
            <p>スクリーンショット</p>
            <div><input class="gray" type="file" name="fname" accept="image/*"></div>
            <p>url</p>
            <div><input type="text" name="url" value="<?=$row["url"]?>"></div>
            <span></span>
            <p>女優</p>
                <div>
                    <input type="radio" name="hyouka1" value="1">
                    <input type="radio" name="hyouka1" value="2">
                    <input type="radio" name="hyouka1" value="3">
                </div>
            <p>シチュ</p>
                <div>
                    <input type="radio" name="hyouka2" value="1">
                    <input type="radio" name="hyouka2" value="2">
                    <input type="radio" name="hyouka2" value="3">
                </div>
            <p>テク</p>
                <div>
                    <input type="radio" name="hyouka3" value="1">
                    <input type="radio" name="hyouka3" value="2">
                    <input type="radio" name="hyouka3" value="3">
                </div>
            <p>コメント</p>
                <div><textarea name="comment" id="" cols="30" rows="5" placeholder="コメントを入力"><?=$row["comment"]?></textarea></div>
            <input type="hidden" name="id" value="<?=$row["id"]?>">
            <input class="btn" type="submit" id="btn-update" value="投稿">
    
        </form>
    
</body>
</html>