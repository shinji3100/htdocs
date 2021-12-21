<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

$f_id = $_POST["f_id"];

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$sql = "INSERT INTO kadai_friend_table(u_id,f_id)VALUES(:u_id,:f_id);";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':f_id',  $f_id,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();//exucuteで実行

if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
  header("Location: friend.php?f_id=$f_id");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる
}

?>
