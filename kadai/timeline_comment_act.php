<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

$id = ($_GET["id"]);


$comment2 = $_POST["comment2"];
// exit("ok");

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBError!:'.$e->getMessage());
}
// exit("ok");

//３．データ登録SQL作成
// $sql = "INSERT INTO kadai_table(id,u_id,u_name,rank,text,indate,indate) 
// SELECT COALESCE(MAX(toukou_no)+1,1),NULL,:u_id,:url,:hyouka1,:hyouka2,:hyouka3,:comment,:fname,sysdate(),$timestamp,COALESCE($timestamp - MAX(timestamp),0)
// FROM kadai_table WHERE u_id = :u_id;";
$sql = "INSERT INTO kadai_comment_table(id,t_id,u_id,u_name,comment2,indate)VALUES(NULL,:t_id,:u_id,:u_name,:comment2,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':t_id',   $id,   PDO::PARAM_STR);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':u_name',   $_SESSION["u_name"],   PDO::PARAM_STR);
$stmt->bindValue(':comment2', $comment2, PDO::PARAM_STR);

$status = $stmt->execute();//exucuteで実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
  //５．index.phpへリダイレクト
  header("Location: timeline_comment.php?id=$id");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる

}
?>