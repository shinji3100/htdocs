<?php


session_start();
// if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
//   echo "LOGIN Error";
//   exit();
// }

//POSTで取得
$fname = $_FILES["fname"]["name"];
$u_name= $_POST["u_name"];
$syokihindo= $_POST["syokihindo"];
$mokuhyou= $_POST["mokuhyou"];
$baitai= $_POST["baitai"];
$dougu = $_POST["dougu"];
// exit("ok");
$upload = "./img/";

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
$sql = "UPDATE kadai_user_table SET fname=:fname, u_name=:u_name, syokihindo=:syokihindo,mokuhyou=:mokuhyou, baitai=:baitai, dougu=:dougu WHERE u_id=:u_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
$stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR);
$stmt->bindValue(':syokihindo', $syokihindo, PDO::PARAM_STR);
$stmt->bindValue(':mokuhyou', $mokuhyou, PDO::PARAM_STR);
$stmt->bindValue(':baitai', $baitai, PDO::PARAM_STR);
$stmt->bindValue(':dougu', $dougu, PDO::PARAM_STR);

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