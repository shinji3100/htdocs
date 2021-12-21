<?php


session_start();
// if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
//   echo "LOGIN Error";
//   exit();
// }
$u_id = $_GET["u_id"];

//POSTで取得
$syounin = $_POST["syounin"];

if(move_uploaded_file($_FILES['fname']['tmp_name'], $upload.$fname)){

}else{
    echo "Update failed";
    echo $_FILES['fname']['error'];
}

//DB
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

//UPDATE
$sql = "UPDATE kadai_friend_table SET syounin=:syounin WHERE u_id=:u_id AND f_id=:f_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_STR);
$stmt->bindValue(':f_id', $_SESSION["u_id"], PDO::PARAM_STR);
$stmt->bindValue(':syounin', $syounin, PDO::PARAM_INT);
$status = $stmt->execute();

$sql2 = "INSERT INTO kadai_friend_table(u_id,f_id,syounin)VALUES(:u_id,:f_id,:syounin);";
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt2->bindValue(':f_id',  $u_id,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt2->bindValue(':syounin', $syounin, PDO::PARAM_INT);
$status2 = $stmt2->execute();//exucuteで実行

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QuerryError".$error[2]);
}else{
    header("Location: mypage_list.php");
    exit();
}


?>