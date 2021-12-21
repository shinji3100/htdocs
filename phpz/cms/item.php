
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
    <title>Document</title>
</head>
<body>
<h1>商品登録画面</h1>
    <form action="insert.php" method="post" enctype="multipart/form-data">
        <p class="cms-thumb"><img src="" alt="" width="200"></p>
        <dl>
        <dt>画像</dt>
        <dd><input type="file" name="fname" accept="image/*"></dd>
        <dt>商品名</dt>
        <dd><input type="text" name="item" placeholder="商品名を入力"></dd>
        <dt>金額</dt>
        <dd><input type="text" name="value" placeholder="金額を入力"></dd>
        <dt>商品紹介文</dt>
        <dd><textarea name="description" id="" cols="30" rows="10" placeholder="商品紹介文を入力"></textarea></dd>
        </dl>

        <ul>
            <li>
                <input type="submit" id="btn-update" value="登録">
            </li>
            <li>
                <a href="item_list.php">一覧へ</a>
            </li>
        </ul>
    </form>


    <script src="js/jquery-3.6.0.min.js"></script>
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
    
    </script>
</body>
</html>