<?php
//POSTで取得
$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
$naiyou = $_POST["naiyou"];


//DB
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

//UPDATE
$sql = "UPDATE gs_an_table SET name=:name, email=:email, naiyou=:naiyou WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QuerryError".$error[2]);
}else{
    header("Location: select.php");
    exit();
}


?>