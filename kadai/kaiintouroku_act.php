<?php
session_start();
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name  = $_POST["name"];
$id = $_POST["id"];
$pw= $_POST["pw"];
$hindo= $_POST["hindo"];
$syokihindo= $_POST["syokihindo"];
$mokuhyou= $_POST["mokuhyou"];

$timestamp = strtotime("now");

// exit("ok");
//2. DB接続します
try {//try{}catch{}エラーを検知するための構文
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');//host:データベースのアドレス、localhost:自分のパソコンの中、root:mampのデフォルトでついているid、root:パスワード
} catch (PDOException $e) {
  exit('DBError!:'.$e->getMessage());
}
// exit("ok");

//３．データ登録SQL作成
$sql = "INSERT INTO kadai_user_table(id,u_name,u_id,u_pw,timestamp,syokihindo,mokuhyou)VALUES(NULL, :u_name, :u_id, :u_pw, :timestamp, :syokihindo, :mokuhyou);";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_name', $pw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':u_id', $id, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':u_pw', $pw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':timestamp', $timestamp, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':syokihindo', $syokihindo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':mokuhyou', $mokuhyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();//exucuteで実行


    

    // header(`Location: mypage.php?id=${$val["u_id"]}`);
    // var_dump($val['u_id']);

exit();
//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["u_name"] = $name;
    $_SESSION["u_id"] = $id;
  header("Location: mypage.php");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる
}
?>