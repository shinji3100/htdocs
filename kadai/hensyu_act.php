<?php


session_start();
// if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
//   echo "LOGIN Error";
//   exit();
// }

//POSTで取得
$fname = $_FILES["fname"]["name"];
$url = $_POST["url"];
$hyouka1= $_POST["hyouka1"];
$hyouka2= $_POST["hyouka2"];
$hyouka3= $_POST["hyouka3"];
$comment = $_POST["comment"];
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
$sql = "UPDATE kadai_table SET name=:name, hyouka1=:hyouka1, hyouka2=:hyouka2, hyouka3=:hyouka3, comment=:comment WHERE id=:id";
$sql = "INSERT INTO kadai_table(id,u_id,url,hyouka1,hyouka2,hyouka3,comment,fname,indate)VALUES(NULL,:u_id,:url,:hyouka1,:hyouka2,:hyouka3,:comment,:fname, sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id',   $_SESSION["u_id"],   PDO::PARAM_STR);
$stmt->bindValue(':url',  $url,  PDO::PARAM_STR);
$stmt->bindValue(':hyouka1', $hyouka1, PDO::PARAM_INT);
$stmt->bindValue(':hyouka2', $hyouka2, PDO::PARAM_INT);
$stmt->bindValue(':hyouka3', $hyouka3, PDO::PARAM_INT);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':fname', $fname, PDO::PARAM_STR);

$status = $stmt->execute();

//
if($status==false){
    $error = $stmt->errorInfo();
    exit("QuerryError".$error[2]);
}else{
    header("Location: select.php");
    exit();
}


?>