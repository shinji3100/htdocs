<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}



// $fname = $_FILES["fname"]["name"];
// $url = $_POST["url"];
// $hyouka1= $_POST["hyouka1"];
// $hyouka2= $_POST["hyouka2"];
// $hyouka3= $_POST["hyouka3"];
// $comment = $_POST["comment"];
$message = $_POST["message"];
// exit("ok");
// $upload = "./img/";

// $timestamp = strtotime("now");

// if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){

// }else{
//     echo "Update failed";
//     echo $_FILES['fname']['error'];
// }

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
$sql = "INSERT INTO kadai_chat_table(id,u_id,u_name,message,indate)VALUES(NULL,:u_id,:u_name,:message,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':u_name',   $_SESSION["u_name"],   PDO::PARAM_STR);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
// $stmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
// $stmt->bindValue(':strtotime', $strtotime, PDO::PARAM_STR);

$status = $stmt->execute();//exucuteで実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
  //５．index.phpへリダイレクト
  header("Location: chat.php");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる

}
?>