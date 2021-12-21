<?php


session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

//POSTで取得
$rank= $_POST["rank"];
$nowrec= $_POST["nowrec"];
$hindo= $_POST["hindo"];
// exit("ok");

//DB
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

//UPDATE
$sql = "UPDATE kadai_user_table SET rank=:rank,nowrec=:nowrec, hindo=:hindo WHERE u_id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':rank', $rank, PDO::PARAM_STR);
$stmt->bindValue(':nowrec', $nowrec, PDO::PARAM_STR);
$stmt->bindValue(':hindo', $hindo, PDO::PARAM_STR);

$status = $stmt->execute();

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QuerryError".$error[2]);
}else{
    header("Location: mypage_list.php");
    exit();
}


?>