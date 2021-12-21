<?php

session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()){
  echo "LOGIN Error";
  exit();
}
$id = $_GET["id"];

try{
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root','root');
}catch(PDOException $e){
    exit('データベースに接続できませんでした。'.$e->getMessage());
}

// $stmt = $pdo->prepare("SELECT * FROM kadai_table");
$stmt = $pdo->prepare("SELECT * FROM kadai_user_table WHERE u_id=:u_id");
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_STR);
$status = $stmt->execute();


$view="";
if($status==false){
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{
    $row = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール</title>
</head>
<body>
    <form action="profile_act.php" method="post" enctype="multipart/form-data">
            <p class="cms-thumb"><img src="./img/<?=$row['fname']?>" alt="" width="200"></p>
            <div>プロフィール画像<input class="gray" type="file" name="fname" accept="image/*" value="<?=$row['fname']?>"></div>
            <div>ユーザー名<input type="text" name="u_name" value="<?=$row['u_name']?>"></div>
            <div>以前の頻度<input type="number" name="kaisuu2" value="3" id="kaisuu2"><select name="hindo2" id="hindo2">
                <option value="1">日</option>
                <option value="7" selected>週</option>
                <option value="30">月</option>
                <option value="365">年</option>
                </select>
            </div>
            <input type="number" name="mokuhyou" value="<?=$row["syokihindo"]?>" id="syokihindo" style="display: none;">
            <div>目標頻度<input type="number" name="kaisuu" value="3" id="kaisuu"><select name="hindo" id="hindo">
                <option value="1">日</option>
                <option value="7" selected>週</option>
                <option value="30">月</option>
                <option value="365">年</option>
                </select>
            </div>
            <input type="number" name="mokuhyou" value="<?=$row["mokuhyou"]?>" id="mokuhyou" style="display: none;">
            <div>主なオカズの媒体<input type="text" name="baitai" value="<?=$row["baitai"]?>"></div>
            <div>使用器具<input type="text" name="dougu" value="<?=$row["dougu"]?>"></div>
            <span></span>
            <!-- <input type="hidden" name="id" value="<?=$row["id"]?>"> -->
            <input class="btn" type="submit" id="btn-update" value="保存">
    
    </form>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        // $("#kaisuu").val();
        // $("#hindo").val();
        // console.log(Math.floor($("#hindo").val() / $("#kaisuu").val() * 86400));
        $('input[type=number]').change(function(){
            $("#syokihindo").val(Math.floor($("#hindo2").val() / $("#kaisuu2").val() * 86400));
            console.log($("#syokihindo").val(Math.floor($("#hindo2").val() / $("#kaisuu2").val() * 86400)));
        });
        $('select').change(function(){
            $("#syokihindo").val(Math.floor($("#hindo2").val() / $("#kaisuu2").val() * 86400));
            console.log($("#syokihindo").val(Math.floor($("#hindo2").val() / $("#kaisuu2").val() * 86400)));
        });
        $('input[type=number]').change(function(){
            $("#mokuhyou").val(Math.floor($("#hindo").val() / $("#kaisuu").val() * 86400));
        });
        $('select').change(function(){
            $("#mokuhyou").val(Math.floor($("#hindo").val() / $("#kaisuu").val() * 86400));
        });

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
    </script>
</body>
</html>