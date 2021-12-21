<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    .page{
        position: relative;
    }
    h1{
        color: #fff;
    }
    /* form{
        text-align: center;
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-top:50%;
        margin-left:50%;
        transform: translateX(-50%);
        position: absolute;
    } */
    
    </style>
    <!-- アドレスバー等のブラウザのUIを非表示 -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- default（Safariと同じ） / black（黒） / black-translucent（ステータスバーをコンテンツに含める） -->
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<!-- ホーム画面に表示されるアプリ名 -->
<meta name="apple-mobile-web-app-title" content="TAP10">
<!-- ホーム画面に表示されるアプリアイコン -->
<link rel="apple-touch-icon" href="images/icons/icon-152x152.png">
</head>
<body>
<div class="page form">
    <form action="login_act.php" method="post">
    <h1>ログイン</h1>
    <p><input type="text" name="lid" placeholder="id"></p>
    <p><input type="datetime" name="lpw" placeholder="password"></p>
    <p><input class="btn" type="submit" value="ログイン"></p>
    
    
    <a href="kaiintouroku.php" class="gray">アカウントをお持ちでない方はこちら</a>
        
    
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</body>
</html>