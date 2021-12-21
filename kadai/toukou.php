<?php
session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        p{
            margin:8px auto 4px;
        }
    </style>
</head>
<body>
<div class="page">
    <h1>新規投稿</h1>
        <form class="form2" action="toukou_act.php" method="post" enctype="multipart/form-data">
            <p class="cms-thumb"><img src="" alt="" width="200"></p>
            <p>スクリーンショット</p>
            <div><input class="gray" type="file" name="fname" accept="image/*"></div>
            <p>url</p>
            <div><input type="text" name="url" placeholder="urlを入力" id="url"></div>
            <span></span>
            <p>女優</p>
                <div>
                    <input type="radio" name="hyouka1" value="1">
                    <input type="radio" name="hyouka1" value="2">
                    <input type="radio" name="hyouka1" value="3">
                </div>
            <p>シチュ</p>
                <div>
                    <input type="radio" name="hyouka2" value="1">
                    <input type="radio" name="hyouka2" value="2">
                    <input type="radio" name="hyouka2" value="3">
                </div>
            <p>テク</p>
                <div>
                    <input type="radio" name="hyouka3" value="1">
                    <input type="radio" name="hyouka3" value="2">
                    <input type="radio" name="hyouka3" value="3">
                </div>
            <p>コメント</p>
                <div><textarea name="comment" id="" cols="30" rows="5" placeholder="コメントを入力"></textarea></div>
            
            <input class="btn" type="submit" id="btn-update" value="投稿">
    
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
          
          <a href="mypage.php">
            <div>
              <img class="icon" src="img/user.svg">
            </div>
          </a>
        </div>
        <footer></footer>
</div>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>

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

    $("#url").change(function(){
        const url = $("#url").val();
        console.log(url);
        // return url;
        $("span").html(`<img src="http://capture.heartrails.com/200x100?${url}">`);
    });
            

    
    
    </script>
</body>
</html>