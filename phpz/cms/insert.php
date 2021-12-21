<?php

if(!isset($_POST["item"]) || $_POST["item"]==""){
    exit("ParameError!item!");
}

if(!isset($_POST["value"]) || $_POST["value"]==""){
    exit("ParameError!value!");
}

if(!isset($_POST["description"]) || $_POST["description"]==""){
    exit("ParameError!description!");
}

if(!isset($_FILES["fname"]["name"]) || $_FILES["fname"]["name"]==""){
    exit("ParameError!Files!");
}

$fname = $_FILES["fname"]["name"];
$item = $_POST["item"];
$value = $_POST["value"];
$description = $_POST["description"];

$upload = "../img/";

if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){

}else{
    echo "Update failed";
    echo $_FILES['fname']['error'];
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$sql = "INSERT INTO ec_table(id,item,value,fname,description,indate)VALUES(NULL, :item, :value, :fname, :description, sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':item',   $item,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':value',  $value,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();//exucuteで実行

if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
  header("Location: item.php");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる
}

?>