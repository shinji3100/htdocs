<?php

session_start();
//POSTで取得
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//DB
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
}catch(PDOException $e){
    exit('DBError'.$e->getMessage());
}

//3.SELECT文
$sql = "SELECT * FROM gs_user_table WHERE user_id=:lid AND user_pw=:lpw";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid);
$stmt->bindValue(':lpw', $lpw);
$status = $stmt->execute();

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QueryError".$error[2]);
}

$val = $stmt->fetch();

if($val["id"] != ""){
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["user_name"] = $val['user_name'];
    
    header("Location: item_list.php");
}else{
    header("Location: login.php");
}
exit();

?>