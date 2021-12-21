<?php

session_start();

include('funcs.php');

$name = $_POST['name'];
$pass = $_POST['pass'];


if(
    !isset($name)  $name = ''
){
    exit('名前を入力してください');
}

if(
    !isset($pass)  $pass = ''
){
    exit('パスワードを入力してください');
}

$pdo = db_conn();

$sql = "SELECT * FROM users_table WHERE name=:name AND password=:password";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':password', $pass, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('ログインできませんでした:' . $error[2]);
}

//$valにsql文で抽出したレコードを代入
$val = $stmt->fetch();

var_dump($val);

//その中のidを起点にしてレコードが空でなければ処理を続ける

if($val['id'] != ''){

    $_SESSION['id'] = $val['id'];
    $_SESSION['S_id'] = session_id();
    $_SESSION['name'] = $val['name'];
    

    $redirect('cocoa.php');
    exit();
}else{
    $redirect('login_error.php');
}
exit();

?>