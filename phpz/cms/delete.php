<?php
//POSTで取得
$id = $_GET["id"];

//DB
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}


$sql = 'DELETE FROM ec_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QueryError".$error[2]);
}else{
    header("Location: item_list.php");
    exit();
}


?>