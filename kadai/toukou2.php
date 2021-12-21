<?php
// date_default_timezone_set('Asia/Tokyo');

// $y = date(Y);
// $m = date(m);
// $d = date(d);
// $h = date(H);

// if($h >= 24){
//     $h -= 24;
//     $d .=  1;
//     var_dump($h);
//     var_dump($d);
// }

?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>チャットボットフォーム</title>
      <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/mypage.css">
    <link rel="stylesheet" href="css/reset.css">
      <style>
          #textarea{
              height: 20px;
              width: 100px;
          }
      </style>
  </head>
  <div calss="page">
      <a href="mypage_list.php">
        <div>
          <img class="icon" src="img/arrow-left.svg">
        </div>
      </a>
  
      <!-- <p>お疲れ様です<?=$u_name;?>さん</p>
      <p id="time">行った時間を入力して下さい</p>
      <p id="sukusyo">行った時のスクーリーンショットがあれば添付して下さい</p>
      <p id="url">オカズのurlがあれば添付して下さい</p>
      <p id="hyouka">満足度を教えて下さい</p>
      <p id="comment">コメントをどうぞ</p> -->

    <div id= "chat_area">
        <ul id= "chat-ul"></ul>
    </div>

<!--入力場所，送信ボタン-->
    <div id= "input-field">
        <!-- <input type= "text" id= "chat-input"> -->
        
    </div>

      </ul>
      <form action="toukou_act.php" method="post" enctype="multipart/form-data">

        <!-- <div id="indate" > -->
        <div id="indate" style="display: none">
          <p>抜いた時刻を入力してください</p>
            <!-- <input type="datetime-local" name="indate" id="indate2"> -->
            <input type="date" name="date" id="date">
            <input type="time" name="time" id="time">
            <!-- <input type="number" value="<?=$y?>">年<input type="number" value="<?=$m?>">月<input type="number" value="<?=$d?>">日<input type="number" value="<?=$h?>">時 -->
        </div>
            <!-- <input type="time" name="time" id="time" style="display: none"> -->
        <!-- </div> -->
        <!-- <input type="text" name="comment" id="textarea"> -->
        <div id="url" style="display: none">
            <p>オカズのurlがあれば貼り付けてくだい</p>
            <span></span>
            <textarea name="url" id="url2"></textarea>
        </div>
        <div id="sukusyo" style="display: none">
            <p>行った時のスクショをテンプしてください</p>
            <p class="cms-thumb"><img src="" alt="" width="200"></p>
            <input type="file" name="fname" accept="image/*" id="sukusyo2">
        </div>
        <div id="manzokudo" style="display: none">
            <p>満足度を教えてください</p>
            <textarea name="manzokudo" id="manzokudo2"></textarea>
        </div>
        <div id="comment" style="display: none">
            <p>最後にコメントをどうぞ</p>
            <textarea name="comment" id="comment2"></textarea>
        </div>
        <input type= "button" value= "Send" id= "button" onclick= "btnFunc()">
        <input type="submit" id="submit" style="display: none">
      </form>

      <form name="mainForm">
            <input type="text" size="30" name="text1" id="focus" onKeyDown="return next_text(1);"><br>
            <input type="text" size="30" name="text1" onKeyDown="return next_text(2);"><br>
            <input type="text" size="30" name="text1" onKeyDown="return next_text(0);"><br>
        </form>

        <div class="navi">
      <a href="timeline.php">
        <div>
          <img class="icon" src="img/home.svg">
        </div>
      </a>

      <a href="toukou.php">
        <div class="circle">
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
  <footer class="footer">
    <div></div>
  </footer>
</div>
      <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
      

      <script type="text/javascript">
      let count =0;
      function btnFunc() {
          count++;
          console.log(count);
            switch(count){
                
                case 1:
                    $('#indate').fadeOut();
                    // $('#time').fadeOut();
                    $('#url').fadeIn();
                    $("#url2").focus();
                    break;
                    
                case 2:
                    $('#url').fadeOut();
                    $('#sukusyo').fadeIn();
                    $("#sukusyo2").focus();
                    break;

                case 3:
                    $('#sukusyo').fadeOut();
                    $('#manzokudo').fadeIn();
                    $("#manzokudo2").focus();
                    break;

                case 4:
                $('#manzokudo').fadeOut();
                $('#button').fadeOut();
                $('#comment').fadeIn();
                $('#submit').fadeIn();
                $("#comment2").focus();
                break;

            }
      }
            $('#indate').fadeIn();
        $("#date").focus();
            function next_text( idx )
            {
                if( window.event.keyCode == 13 ){        // 13は0x0d(CRキー)
                    // 次のテキストボックスへ飛ばす処理をここにかく
                    document.mainForm.text1[ idx ].focus() ; 
                    return false ;
                }
                return true ;
            }
            // window.addEventListener('load', () => {
            // const now = new Date();
            // now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            // document.getElementById('indate').value = now.toISOString().slice(0, -1);
            // });
            $('input[type=file]').change(function(){

        var file = $(this).prop('files')[0];

        if (!file.type.match('image.*')){
            $(this).val('');
            $('.cms-thumb > img').html('');
            return;
        }
        var reader = new FileReader();
        reader.onload = function(){
            $('.cms-thumb > img').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
    });

    $("#url2").change(function(){
        const url = $("#url2").val();
        console.log(url);
        // return url;
        $("span").html(`<img src="http://capture.heartrails.com/200x100?${url}">`);
    });
    $("#time").change(function(){
        console.log($("#time").val());
    });
            
        </script>
  </body>
  </html>
