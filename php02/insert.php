<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name  = $_POST["name"];
$email = $_POST["email"];
$naiyou= $_POST["naiyou"];

// exit("ok");
//2. DB接続します
try {//try{}catch{}エラーを検知するための構文
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');//host:データベースのアドレス、localhost:自分のパソコンの中、root:mampのデフォルトでついているid、root:パスワード
} catch (PDOException $e) {
  exit('DBError!:'.$e->getMessage());
}
// exit("ok");

// // //３．データ登録SQL作成
// $sql = "INSERT INTO gs_an_table(id,name,email,naiyou,indate)VALUES(NULL, :name, :email, :naiyou, :indate,sysdate())-- :変数名,（バインド変数）,sqlの表のセルと連携する、置き換え文字";
// $stmt = $pdo->prepare($spl);
// $stmt->bindValue(':name', $name, PDO::PARAM_STR);//$nameに入っている値が:nameに代入される。SQLインジェクション防止のため、prepareとbindValueでコマンドの文字を無効化してから$sqlに値を渡している
// $stmt->bindValue(':email', $name, PDO::PARAM_STR);
// $stmt->bindValue(':naiyou', $name, PDO::PARAM_STR);
// $status = $stmt->execute();
//３．データ登録SQL作成
$sql = "INSERT INTO gs_an_table(id,name,email,naiyou,indate)VALUES(NULL, :name, :email, :naiyou, sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email',  $email,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();//exucuteで実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);//エラーインフォの文字列で読める部分(2番目)を表示
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");//header("Location: 飛ぶ場所")飛ばす、:のあと半角スペース
  exit();//実行を終わる

}
?>
