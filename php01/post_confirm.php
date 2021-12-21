<?php
// $a = "ABC";

// echo $a;

// $b = "あいう";
// echo $b;

// $c = '<h1>123</h1>';
// echo $c;


function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

$name = $_POST["name"];
$mail = $_POST["mail"];
$age = $_POST["age"];
$tel = $_POST["tel"];

$a = "";
echo $a;
$br = "<br>";

if($name == ""){
    $a .= "名前未入力".$br;
}
if($mail == ""){
    $a .= "MAIL未入力";
}


?>
<html>
<head>
<meta charset="utf-8">
<title>POST（受信）</title>
</head>
<body>
<h1><?= $a ?></h1>
お名前：<?php echo $name; ?>
EMAIL：<?= $mail ?>
年齢:<?= $age ?>
電話番号:<?= $tel ?>
<ul>
<li><a href="index.php">index.php</a></li>
</ul>
</body>
</html>