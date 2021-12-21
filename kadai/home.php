<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .page{
            text-align: center;
            color: white;
            position: relative;
        }
        .semen{
            position:absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .logo{
            position:absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .button{
            display:flex;
            justify-content:center;
            flex-direction: column;
        }
        .button{
            width: 100px;
            margin:0 auto;
            bottom: 0;
            background-color: #white;
            border:none;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="semen"><img src="./img/1918169.png" ></div>
        <div class="logo"><img src="./img/Group 3logo.svg" width="300"></div>
        <!-- <img src="./img/plus.svg" alt="" class="white"> -->
        <a href="login.php">
        <div class="button">
            <button class="button">
                <p>ログイン</p>
            </button>
            </a>
            <button class="button">
                <p>新規登録</p>
            </button>
        </div>
    </div>
</body>
</html>