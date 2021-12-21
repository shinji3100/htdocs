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
// WHERE kadai_user_table.rank = (SELECT COALESCE(rank) FROM kadai_user_table WHERE u_id = $_SESSION["u_id"])"
// (SELECT COALESCE(rank) FROM kadai_user_table WHERE u_id = $_SESSION["u_id"])

$sql = "SELECT * FROM kadai_user_table 
        INNER JOIN kadai_chat_table ON kadai_user_table.u_id = kadai_chat_table.u_id
        WHERE kadai_user_table.rank = (SELECT rank FROM kadai_user_table WHERE kadai_user_table.u_id = :u_id)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
// $stmt = $pdo->prepare("SELECT * FROM kadai_user_table WHERE rank = 0");
$status = $stmt->execute();


$view="";
if($status==false) {

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{

  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
      $view .= '<div class="left '.$res["u_id"].'">';
      $view .= '<div class="soto">';
      $view .= '<p class="u_name">'.$res["u_name"].'</p>';
    $view .= '<a href="friend.php?f_id='.$res["u_id"].'">';
    $view .= '<div class="fname"><img src="./img/'.$res['fname'].'" width="50"></div>';
    $view .= '</a>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="left '.$res["u_id"].'">';
    $view .= '<div class="naka">';
    $view .= '<p class="indate">'.$res["indate"].'</p>';
    $view .= '<p class="message">'.$res["message"].'</p>';
    $view .= '</div>';
    // $view .= '<p><img src="./img/'.$res["fname"].'"width="200"></p>';
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
  <title>グループチャット</title>
  <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="css/reset.css">
    <style>
        #chat_area{
        width: 80%;
        height: 70%;
        padding: 7px 0 14px;
        box-sizing: border-box;
        background-color: #EEE;
        margin: 0 auto;
        background-color: #cebde2;
        /* background:linear-gradient(to right, red, orange , yellow, green, cyan, blue, violet); */
        /*横向きのスクロール禁止*/
        overflow-x: hidden;
        /*縦向きのスクロール許可*/
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
        /*IE、Edgeでスクロールバーを非表示にする*/
        -ms-overflow-style: none;
    }
    </style>
</head>
<body>
    <!-- <div class="header"></div> -->
<div class="page">

    <div id= "chat_area">
        <ul id= "chat-ul">
            <?=$view;?>
        </ul>
    </div>
    
    <form action="chat_act.php" method="post">
        <textarea name="message" id="textarea" cols="30" rows="10"></textarea>
        <input type="submit" value="送信">
    </form>
    <div class="navi">
          <a href="timeline.php">
            <div>
              <img class="icon" src="img/home.svg">
            </div>
          </a>
    
          <a href="toukou2.php">
            <div>
              <img class="icon" src="img/edit.svg">
            </div>
          </a>

           <a href="chat.php">
        <div class="circle">
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

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>

    const chat_area = document.getElementById('chat_area');
    chat_area.scroll(0, chat_area.scrollHeight - chat_area.clientHeight);
    
    //textareaの要素取得
        let textarea = document.getElementById('textarea');
        //textareaのデフォルトの要素の高さを取得
        let ch = textarea.clientHeight;

        //textareaのinputイベント
        textarea.addEventListener('input', ()=>{
            //textareaの高さを再設定（デフォルトの高さから計算するため）
            textarea.style.height = ch + 'px';
            //textareaの入力内容の高さを取得
            let sh = textarea.scrollHeight;
            //textareaの高さに入力内容の高さを設定
            textarea.style.height = sh + 'px';
        });

        const u_id  = '.' + '<?=$_SESSION["u_id"];?>';
        $(`${u_id}`).removeClass("left");
        $(`${u_id}`).addClass("right");
        // let sato = document.getElementsByClassName('sato4');
        // console.log(sato);
        // sato.classList.add('right');
        // $(".sato4").addClass("right");
</script>
</body>
</html>