<?php
session_start();

if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}

if(!isset($_GET["id"]) || $_GET["id"]==""){
    exit("ParamError");
}else{
    $id = ($_GET["id"]);
}

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}
// WHERE kadai_user_table.rank = (SELECT COALESCE(rank) FROM kadai_user_table WHERE u_id = $_SESSION["u_id"])"
// (SELECT COALESCE(rank) FROM kadai_user_table WHERE u_id = $_SESSION["u_id"])

$sql = "SELECT * FROM kadai_table 
        INNER JOIN kadai_comment_table ON kadai_table.id = kadai_comment_table.t_id
        INNER JOIN kadai_user_table ON kadai_comment_table.u_id = kadai_user_table.u_id
        WHERE kadai_table.id = :id";

$sql2 = "SELECT * FROM kadai_table 
        WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
// $stmt = $pdo->prepare("SELECT * FROM kadai_user_table WHERE rank = 0");
$status = $stmt->execute();

$stmt2 = $pdo->prepare($sql2);
$stmt2->bindValue(':id', $id, PDO::PARAM_STR);
// $stmt = $pdo->prepare("SELECT * FROM kadai_user_table WHERE rank = 0");
$status2 = $stmt2->execute();

if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  $row = $stmt2->fetch();
}

$view="";
if($status==false) {
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
    // $row = $stmt->fetch();
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<div class="comment '.$res["u_id"].'">';
    // $view .= '<a href="friend.php?f_id='.$res["u_id"].'">';
    // $view .= '<div><img src="./img/'.$res['fname'].'" width="50"></div>';
    // $view .= '</a>';
    // $view .= '<p>'.$res["u_name"].'</p>';
    // $view .= '<p>'.$res["indate"].'</p>';
    $view .= '<div><img src="./img/'.$res['fname'].'" width="50" height="50"></div>';
    $view .= '<div class="yoko>';
    $view .= '<p class="u_name">'.$res["u_name"].'</p>';
    $view .= '<p class="indate gray">'.$res["indate"].'</p>';
    $view .= '<p class="comment2">'.$res["comment2"].'</p>';
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
    <link rel="stylesheet" href="css/comment.css">
    <link rel="stylesheet" href="css/reset.css">
    <style>
        
    /* #chat_area{
        width: 300px;
        height: 230px;
        padding: 7px 0 14px;
        box-sizing: border-box;
        background-color: #EEE;
        margin: 0 auto;
        background-color: #81AECF;
        overflow-x: hidden;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: none;
    } */
    /* .right{
        background: #000;
        color: white;
    }
    .left{
        color: black;
    } */

 .mozaiku{
     -ms-filter: blur(6px);
	filter: blur(6px);
 }
    </style>
</head>
<body>
<div class="page">
<div class="toukou">
    <p class="mozaiku"><img src="./img/<?=$row["fname1"]?>" width="200"></p>
    <div><p><?=$row["comment"]?></p></div>
    <div><p><?=$row["url"]?></p></div>
</div>
    <!-- <div id= "chat_area"> -->
        <!-- <ul id= "chat-ul"> -->
            <div class="manko">
                <?=$view;?>

            </div>
        <!-- </ul> -->
        <div class="sousin">
            <form id="text" action="timeline_comment_act.php?id=<?=$id?>" method="post">
                <textarea name="comment2" id="textarea" cols="30" rows="3"></textarea>
            <button>
                <div class="circle">
                  <img class="icon" src="img/send.svg">
                </div>
            </button>
                
            </form>
        </div>
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
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>

    // const chat_area = document.getElementById('chat_area');
    // chat_area.scroll(0, chat_area.scrollHeight - chat_area.clientHeight);
    
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