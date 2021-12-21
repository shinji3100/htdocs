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
$sql = "SELECT * FROM kadai_user_table WHERE u_id=:lid AND u_pw=:lpw";
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

if($val["id2"] != ""){
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["u_name"] = $val['u_name'];
    $_SESSION["u_id"] = $val['u_id'];

    // header(`Location: mypage.php?id=${$val["u_id"]}`);
    // var_dump($val['u_id']);
    header('Location: mypage_list.php');
}else{
    header("Location: login.php");
}
exit();

?>