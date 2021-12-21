<?php
//文字作成
$str = date("Y-m-d H:i:s");
$str .= ",".$_POST["name"];
$str .= ",".$_POST["mail"];
$str .= ",".$_POST["age"];
$str .= ",".$_POST["tel"];

// テストはpost.phpから！
//File書き込み
$file = fopen("data/data.txt","a");	// ファイル読み込み
fwrite($file, $str."\r\n");
fclose($file);

// $file = fopen("./data/data.txt","a");
// r 読み込みのみでオープンします
// r+ 読み込み・書き込みようにオープンします
// w 書き込みのみでオープンします。内容をまず削除、ファイルがなければ作成
// w+ 読み込み・」書き込みようでオープンします。内容をまず削除、ファイルがなければ作成
// a 追加書き込み用のみでオープンします。ファイルがなければ作成
// a+ 読み込み・追加書き込み用でオープンします。ファイルがなければ作成。
// fwrite($file,"**書き込み文字列**");
// fclose($file);




?>


<html>
<head>
<meta charset="utf-8">
<title>File書き込み</title>
</head>
<body>

<h1>書き込みしました。</h1>
<h2>./data/data.txt を確認しましょう！</h2>

<ul>
<li><a href="input.php">戻る</a></li>
</ul>
</body>
</html>