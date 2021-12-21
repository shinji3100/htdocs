<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}
// $id = $_GET["id"];
$timestamp = strtotime("now");
// while (true) {
//     $timestamp = strtotime("now");
//     sleep(1);
// }
// var_dump($timestamp);
try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

// $stmt = $pdo->prepare("SELECT * FROM kadai_table");
$stmt = $pdo->prepare("SELECT * FROM kadai_table WHERE u_id=:u_id ORDER BY id DESC");
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status = $stmt->execute();

$stmt2 = $pdo->prepare("SELECT AVG(onakin_rec) AS av FROM kadai_table WHERE u_id=:u_id");
$stmt2->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status2 = $stmt2->execute();
$res2 = $stmt2->fetch();

$stmt3 = $pdo->prepare("SELECT MAX(timestamp), COUNT(timestamp) FROM kadai_table WHERE u_id=:u_id");
$stmt3->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status3 = $stmt3->execute();
$res3 = $stmt3->fetch();

$stmt4 = $pdo->prepare("SELECT * FROM kadai_friend_table WHERE f_id=:f_id AND syounin = 0");
$stmt4->bindValue(':f_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status4 = $stmt4->execute();
$res4 = $stmt4->fetch();

$stmt5 = $pdo->prepare("SELECT * FROM kadai_user_table WHERE u_id=:u_id");
$stmt5->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status5 = $stmt5->execute();
$res5 = $stmt5->fetch();

$sql6 = "SELECT * FROM kadai_table 
        INNER JOIN kadai_user_table ON kadai_table.u_id = kadai_user_table.u_id
        -- INNER JOIN kadai_user_table ON kadai_comment_table.u_id = kadai_user_table.u_id
        WHERE kadai_user_table.u_id = :u_id";
$stmt6 = $pdo->prepare($sql6);
$stmt6->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status6 = $stmt6->execute();


$stmt7 = $pdo->prepare("SELECT * FROM kadai_table WHERE u_id=:u_id ORDER BY id DESC");
$stmt7->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status7 = $stmt7->execute();


$tourokukikan = ($timestamp - $res5["timestamp0"]) / 86400;

$level_score = ($res5["hindo"] - $res5["syokihindo"]) /86400;

$level = floor($tourokukikan * $level_score);
$nextlevel = ceil($tourokukikan * $level_score) - ($tourokukikan * $level_score);

$rec = $timestamp - $res3["MAX(timestamp)"];
// var_dump($res3["COUNT(timestamp)"]);
    $day3 = $rec / 86400;
    $hour3 = $rec  % 86400 / 3600;
    $minute3 = $rec  % 3600 / 60;
    $second3 = $rec  % 60;

$av =  floor(($res2["av"]  * $res3["COUNT(timestamp)"] + $rec) / ($res3["COUNT(timestamp)"]));
    $day2 = $av / 86400;
    $hour2 = $av % 86400 / 3600;
    $minute2 = $av % 3600 / 60;
    $second2 = $av % 60;

    // if($av < 86400){
    //   $color 2= "red";
    // }
    // else if($av >= 86400 * 3 && $av < 86400 * 7){
    //   $color2 = "green";
    // }
    // else if($av >= 86400 * 7){
    //   $color2 = "rainbow";
    // }
    // else{
    //   $color2 = "white";
    // }


$view3='<p class=" '.$color3.'">'.floor($day3)."日".floor($hour3)."時間".floor($minute3)."分".$second3."秒".'</p>';
$view2='<p class="rec '.$color2.'">'.floor($day2)."日".floor($hour2)."時間".floor($minute2)."分".$second2."秒".'</p>';

// $_SESSION["rec"] = $rec;
// $_SESSION["view3"] = $view3;
// $_SESSION["av"] = $av;
// $_SESSION["view2"] = $view2;

$view7="";
if($status7==false) {
  $error = $stmt7->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  while( $res7 = $stmt7->fetch(PDO::FETCH_ASSOC)){
    $view7 .= '<div class="item timeline">';
    $view7 .= '<a href="hensyu.php?='.$res7["id"].'">';
    $view7 .= '<div><img src="./img/'.$res7["fname1"].'"width="200"></div>';
    $view7 .= '</a>';
    $view7 .= '</div>';
  }
}

$view="";
$view4="";
if($status==false) {

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{

  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $day = $res["onakin_rec"] / 86400;
    // $hour_pre = $res["onakin_rec"]  - floor($day) * 86400;
    $hour = $res["onakin_rec"] % 86400 / 3600;
    $minute = $res["onakin_rec"] % 3600 / 60;

    if($res["onakin_rec"] < 86400){
      $color = "red";
    }
    else if($res["onakin_rec"] >= 86400 * 3 && $res["onakin_rec"] < 86400 * 7){
      $color = "green";
    }
    else if($res["onakin_rec"] >= 86400 * 7){
      $color = "rainbow";
    }
    else{
      $color = "white";
    }

    
    $view .= '<div class="toukou timeline">';
    $view .= '<a href="hensyu.php?='.$res["id"].'">';
    $view .= '<div class="mozaiku"><img src="./img/'.$res["fname1"].'"width="200"></div>';
    $view .= '<div class="migi">';
    $view .= '<p class="gray">'.$res["indate"].'</p>';
    // $view .= '<p class= "'.$color.'">'.floor($day)."日".floor($hour)."時間".floor($minute)."分".$res["onakin_rec"] % "60"."秒".'</p>';
    $view .= '<p class= "'.$color.'">'.floor($day)."日".floor($hour)."時間".'</p>';
    // $view .= '<p>'.($res["hyouka1"]+ $res["hyouka2"]+ $res["hyouka3"] )* "11".'</p>';
    $view .= '<p class="white comment">'.$res["comment"].'</p>';
    $view .= '<a href="mypage_delete.php?id='.$res["id"].'" class="gray sakuzyo">'.'[削除]'.'</a>';
    $view .= '</a>';
    $view .= '</div>';
    $view .= '</div>';

    // $view2 .=   ',{ label: "'.$res["indate"].'", y: '.$res["hyouka1"].' }';
  // { label: "２月", y: 59 },
  // { label: "３月", y: 80 },
  // { label: "４月", y: 81 },
  // { label: "５月", y: 56 },
  // { label: "６月", y: 55 },
  // { label: "７月", y: 48 }
  
  }
  // while( $result[] = $stmt->fetch(PDO::FETCH_ASSOC));
  // $result["hyouka1"] + $result["hyouka2"] + $result["hyouka3"];

  // $json = json_encode($res2);
}

// if($status==false) {

//   $error = $stmt->errorInfo();
//   exit("ErrorQuery:".$error[2]);

// }else{
//    while( $res4 = $stmt->fetch(PDO::FETCH_ASSOC)){
//     $view4 = '<img src="./img/'.$res4["fname"].'"width="200">';
//   }
// }
$deg = round($nextlevel * 158);
function gage(){
mb_http_output('UTF-8');
echo '<style type="text/css">';
echo<<<EOF


@keyframes gage{
  0%{stroke-dasharray:0 158;}
  99.9%,to{stroke-dasharray: round($nextlevel * 158) 158;}
}

EOF;
echo '</style>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mypage.css">
    <link rel="stylesheet" href="css/reset.css">
    <?php gage();?>
    <style>.mozaiku{-ms-filter: blur(6px);
	filter: blur(6px);}</style>
</head>
<body>
  <div class="page">
  <!-- <img class="header" src="./img/mozaiku.jpeg" alt="" > -->
  <div class="header">
    <div class="header_cover"></div>
  </div>
  <div class="profilegazou">

    <img src="img/<?=$res5["fname"]?>" width="100" height="100">
  </div>
  <h1>マイページ</h1>
  <a href="profile.php">
            <div class="circle">
              <img class="icon" src="img/settings.svg">
            </div>
          </a>
          <a href="login.php">
            <div class="circle">
              <img class="icon" src="img/log-out.svg">
            </div>
          </a>
          <a href="profile.php">
            <div class="circle">
              <img class="icon" src="img/users.svg">
            </div>
          </a>
  <div>
    <form action="mypage_act.php" method="post">
    <input id="rank_number" type="number" name="hindo" value="<?=$av;?>" style="display:none;">
    <input id="rank" type="text" name="rank" style="display:none;">
    <input id="tourokukikan" type="number" name="tourokukikan" value="<?=$tourokukikan;?>" style="display:none;">
    <input id="nowrec" type="text" name="nowrec" value="<?=floor($day2);?>日<?=floor($hour2);?>時間" style="display:none;">
    <input type="submit" value="更新">
    </form>
    <form action="friend_syounin.php?u_id=<?=$res4["u_id"]?>" method="post">
      <p><?=$res4["u_id"]?></p>
      <p><?=$res4["syounin"]?></p>
      <input type="radio" name="syounin" value="1">
      <input type="radio" name="syounin" value="2">
      <input type="submit" value="承認">
    </form>
    <div class="level">
      <div class="gage" style="
    stroke: rgb(186, 255, 83);
    stroke-width: 50;
    stroke-dasharray: <?=round($nextlevel * 158);?> 158; 
    transform: rotate(-90deg);
    animation:gage 1s forwards;">
      <svg width="100" height="100"><circle r="25" cx="50" cy="50"></svg>
    </div>
    <p>level<?=$level;?></p>
    </div>
    <p>
      次のレベルまで
      <?=round($nextlevel * 158);?>
      タイムスタンプ
      <?=$timestamp?>
      初期登録
      <?=$res5["timestamp0"]?>
      tタイムsたんぷー初期登録
      <?=$tourokukikan;?>
    </p>
    <p>

      <?=$level_score;?>
    </p>
    <?=$view3;?>
    <?=$view2;?>
  </div>
  <a href="mypage_ga.php">
        <div class="circle">
          <img class="icon" src="img/grid.svg">
        </div>
      </a>
      <!-- <a href="mypage_list.php">
        <div class="circle">
          <img class="icon" src="img/list.svg">
        </div>
      </a> -->

  <!-- <button id="ga">
    <img src="./img/grid.svg" >
  </button> -->
  <!-- <button id="list" >
    <img src="./img/list.svg" >
  </button> -->
  <div class="view">
  <!-- <div id="stage" style="height: 200px;"></div> -->
  <div class="mt440 list" >
      <?=$view?>
  </div>
  <div>
    <?=$view4?>
  </div>
  <!-- <div class="items ga" >
    <?=$view7;?>
  </div> -->
  </div>
  
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
        <div>
          <img class="icon" src="img/message-circle.svg">
        </div>
      </a>
      
      <a href="mypage_list.php">
        <div class="circle">
          <img class="icon" src="img/user.svg">
        </div>
      </a>
  </div>
  <footer class="footer">
    <div></div>
  </footer>
  </div>
</div>
    
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
<script>

//   const data = JSON.parse('<?=$json?>'); //JSON文字列→配列に変換
// console.log(data);
  //「月別データ」
var data = [
  { label: "１月", y: 65 },
  { label: "２月", y: 59 },
  { label: "３月", y: 80 },
  { label: "４月", y: 81 },
  { label: "５月", y: 56 },
  { label: "６月", y: 55 },
  { label: "７月", y: 48 }
];

var stage = document.getElementById('stage');
var chart = new CanvasJS.Chart(stage, {
  animationEnabled: true,
  title: {
    text: ""  //グラフタイトル
  },
  theme: "light2",  //テーマ設定
  data: [{
    type: 'line',  //グラフの種類
    dataPoints: data  //表示するデータ
  }]
});
chart.render();


const rank = $("#rank_number").val();
if(rank / 86400 < 1){
  $("#rank").val(69);
}
// for(i=0; i<=1; i++){
// }

// let count = 0;
//   $(document).ready(function(){
//     count++;
//     console.log(count);
//     if(count >= 2){
//       $('form').submit();
//     }
//   });
// $("#list").on('click',function(){
//   console.log("kintama");
//   $(".list").fadeOut();
//   $(".ga").fadeIn("slow");
// });
// $("button #ga").on('click',function(){
//   console.log("kintama");
//   $(".ga").fadeOut();
//   $(".list").fadeIn("slow");
// });
  
  
</script>
</body>
</html>
