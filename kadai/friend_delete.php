<?php
session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}
$f_id = $_GET["f_id"];

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$sql = 'DELETE FROM kadai_friend_table WHERE u_id=:u_id AND f_id = :f_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$stmt->bindValue(':f_id', $f_id, PDO::PARAM_STR);
$status = $stmt->execute();


if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  header("Location: friend.php?f_id=$f_id");
    exit();
}

?>