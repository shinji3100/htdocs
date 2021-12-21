<?php

session_start();
// if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
//   echo "LOGIN Error";
//   exit();
// }


$date= $_POST["date"];
$time= $_POST["time"];
$fname = $_FILES["fname"]["name"];
$url = $_POST["url"];
$manzokudo= $_POST["manzokudo"];
$comment = $_POST["comment"];
// exit("ok");
$upload = "./img/";

$timestamp = strtotime("now");

if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){

}else{
    echo "Update failed";
    echo $_FILES['fname']['error'];
}

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBError!:'.$e->getMessage());
}
// exit("ok");

//３．データ登録SQL作成

$stmt3 = $pdo->prepare("SELECT FROM kadai_user_table WHERE u_id=:u_id");
$stmt3->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status3 = $stmt3->execute();
$res3 = $stmt3->fetch();
$houkoku = $res3["nowrec"];
$houkoku .= '行きました';

$sql2 = "INSERT INTO kadai_comment_table(id,u_id,url,u_name,message,indate)VALUES(NULL,:u_id,:u_name,:message,sysdate());";
$stmt2 = $pdo->prepare($sql);
$stmt2->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt2->bindValue(':u_name',   $_SESSION["u_name"],   PDO::PARAM_STR);
$stmt2->bindValue(':message', $houkoku, PDO::PARAM_STR);
// $stmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);
// $stmt->bindValue(':strtotime', $strtotime, PDO::PARAM_STR);
$status2 = $stmt2->execute();//exucuteで実行

$sql = "INSERT INTO kadai_table(toukou_no,id,u_id,url,manzokudo,comment,fname1,date,time,timestamp,onakin_rec) 
SELECT COALESCE(MAX(toukou_no)+1,1),NULL,:u_id,:url,:manzokudo,:comment,:fname,:date,:time,$timestamp,COALESCE($timestamp - MAX(timestamp),0)
FROM kadai_table WHERE u_id = :u_id;";
// $sql = "INSERT INTO kadai_table(toukou_no,id,u_id,url,hyouka1,hyouka2,hyouka3,comment,fname,indate,timestamp)VALUES(0,NULL,:u_id,:url,:hyouka1,:hyouka2,:hyouka3,:comment,:fname,sysdate(),:timestamp);";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':url',  $url,  PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':time', $time, PDO::PARAM_INT);
$stmt->bindValue(':manzokudo', $manzokudo, PDO::PARAM_INT);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
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
  header("Location: mypage_list.php");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる

}
?>
