<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    
    </style>
</head>
<body>
<div class="page form">
    <form action="kaiintouroku_act.php" method="post">
    <h1>会員登録</h1>
    <p><input type="text" name="name" placeholder="name"></p>
    <p><input type="text" name="id" placeholder="id"></p>
    <p><input type="datetime" name="pw" placeholder="password"></p>
    <!-- <p><input type="text" name="hindo" placeholder="現在の頻度"></p> -->
    <!-- <p><input type="text" name="mokuhyou" placeholder="目標頻度"></p> -->

    <div>以前の頻度<input type="number" name="kaisuu2" value="3" id="kaisuu2"><select name="hindo2" id="hindo2">
                <option value="1">日</option>
                <option value="7" selected>週</option>
                <option value="30">月</option>
                <option value="365">年</option>
                </select>
            </div>
            <input type="number" name="syokihindo" value="" id="syokihindo" style="display: none;">
            <div>目標頻度<input type="number" name="kaisuu" value="3" id="kaisuu"><select name="hindo" id="hindo">
                <option value="1">日</option>
                <option value="7" selected>週</option>
                <option value="30">月</option>
                <option value="365">年</option>
                </select>
            </div>
            <input type="number" name="mokuhyou" value="" id="mokuhyou" style="display: none;">

    <p><input class="btn" type="submit" value="登録"></p>
    
    <div>
        <a href="login.php" class="gray">アカウントをお持ちの方はこちら</a>
    </div>
    
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
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
</script>
</body>
</html>