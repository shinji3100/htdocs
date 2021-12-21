<?php
session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}
$f_id = $_GET["f_id"];
if($_GET["f_id"] == ""){
  exit("getid");
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM kadai_user_table WHERE u_id = :u_id");
$stmt->bindValue(':u_id',$f_id, PDO::PARAM_STR);
$status = $stmt->execute();

$stmt2 = $pdo->prepare("SELECT * FROM kadai_user_table INNER JOIN kadai_friend_table ON kadai_user_table.u_id = kadai_friend_table.f_id WHERE kadai_user_table.u_id = :f_id AND kadai_friend_table.u_id = :u_id");
$stmt2->bindValue(':f_id',$f_id, PDO::PARAM_STR);
$stmt2->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status2 = $stmt2->execute();

if($status==false) {

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  $row = $stmt->fetch();
}

if($status2==false) {

  $error = $stmt2->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  $row2 = $stmt2->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>フレンド追加</title>
</head>
<body>
  <a href="timeline.php">
        <div>
          <img class="icon" src="img/arrow-left.svg">
        </div>
      </a>
<form action="friend_act.php" method="post">

<p><img src="./img/<?=$row["fname"]?>" width="200"></p>
<h1><?=$row["u_name"]?></h1>
<p><?=$row["u_id"]?></p>
<p>現在の頻度<?=$row["hindo"]?></p>
<p>目標頻度<?=$row["mokuhyou"]?></p>

<div id="friend" style="display: none">
  <img src="./img/user-check.svg" alt="">
</div>
<input type="hidden" value ="<?=$row["u_id"]?>" name="f_id">
<div class="sinsei" style="display: none"><input type="submit" value="フレンド申請" id="sinsei" style="display_none"></div>
<div class="torikesi" style="display: none">
  <a href="friend_delete.php?f_id=<?=$row["u_id"]?>">
  <input type="button" value="申請取消し" id="torikesi" style="display_none">
  </a>
</div>
<div class="sakuzyo" style="display: none">
  <a href="friend_delete.php?f_id=<?=$row["u_id"]?>">
  <input type="button" value="フレンド削除" id="sakuzyo" style="display_none">
  </a>
</div>
<input type="hidden" value ="<?=$row2["syounin"]?>" name="syounin" id="syounin">

</form>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
  if($("input[name='syounin']").val() == ""){

    $(".sinsei").fadeIn();
    // $("#torikesi").removeClass("display_none");
  }
  else if($("input[name='syounin']").val() == 0){

    // $("#sinsei").addClass("display_none");
    $(".torikesi").fadeIn();
  }
  else if($("input[name='syounin']").val() == 1){

    // $("#sinsei").addClass("display_none");
    $(".sakuzyo").fadeIn();
    $("#friend").fadeIn();
  }
  else{
    $(".torikesi").fadeIn();
  }
</script>
</body>
</html>
