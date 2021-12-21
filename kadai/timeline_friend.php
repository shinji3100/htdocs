<?php
session_start();

if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM kadai_table INNER JOIN kadai_friend_table ON kadai_table.u_id = kadai_friend_table.f_id INNER JOIN kadai_user_table ON kadai_friend_table.f_id = kadai_user_table.u_id WHERE kadai_friend_table.syounin = 1 AND kadai_friend_table.u_id = :u_id ORDER BY timestamp DESC");
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status = $stmt->execute();

$view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{

  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    $view .= '<div class="toukou">';
    $view .= '<a href="friend.php?f_id='.$res["u_id"].'">';
    $view .= '<div class="fname"><img src="./img/'.$res['fname'].'" width="50"></div>';
    $view .= '</a>';
    $view .= '<p class="acount_circle">'.$res["u_id"].'</p>';
    $view .= '<p class="gray">'.$res["indate"].'</p>';
    $view .= '<p class="mozaiku"><img src="./img/'.$res["fname1"].'"width="200"></p>';
    $view .= '<p class="white">'.$res["comment"].'</p>';
    $view .= '<a href="timeline_comment.php?id='.$res["id"].'">';
    $view .= '<ion-icon name="chatbubble-ellipses"></ion-icon>';
    $view .= '</a>';
    $view .= '</div>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>タイムライン</title>
  <link rel="stylesheet" href="css/style.css">
    <style>
        /* .acount_circle{
            width: 40px;
            height: 40px;
            border-radius:50%;
            background:rgb(186, 255, 83);
            color: white;
        } */
        .mozaiku{
            -ms-filter: blur(6px);
	filter: blur(6px);
        }
    </style>
</head>
<body>
<div class="page">
    <h1>タイムライン</h1>
    <a href="timeline.php">
            <div class="circle">
              <img class="icon" src="img/globe.svg">
            </div>
          </a>
        <div>
            <?=$view;?>
        </div>
    <div class="navi">
          <a href="timeline.php">
            <div class="circle">
              <img class="icon" src="img/home.svg">
            </div>
          </a>
    
          <a href="toukou2.php">
            <div>
              <img class="icon" src="img/edit.svg">
            </div>
          </a>
    <a href="chat.php">
        <div>
          <img class="icon" src="img/message-circle.svg">
        </div>
      </a>
          <a href="mypage_list.php">
            <div>
              <img class="icon" src="img/user.svg">
            </div>
          </a>
    </div>
    <footer></footer>
</div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>