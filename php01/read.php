

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<p>書き込みました</p>

<table border="1" cellspacing="0" cellpadding="5" bordercolor="black">
    <tr>
        <th style="background-color:black; border-right:1px solid gray; border-left:1px solid gray; color:white;">日時</th>
        <th style="background-color:black; border-right:1px solid gray; border-left:1px solid gray; color:white;">名前</th>
        <th style="background-color:black; border-right:1px solid gray; border-left:1px solid gray; color:white;">EMAIL</th>
        <th style="background-color:black; border-right:1px solid gray; border-left:1px solid gray; color:white;">年齢</th>
        <th style="background-color:black; border-left:1px solid gray; color:white;">TEL</th>
    </tr>
    <?php
        //文字作成
        $str = date("Y-m-d H:i:s");
        $str .= ",".$_POST["name"];
        $str .= ",".$_POST["mail"];
        $str .= ",".$_POST["age"];
        $str .= ",".$_POST["tel"];

        //File書き込み
        $file = fopen("data/data2.txt","a");	// ファイル読み込み
        fwrite($file, $str."\r\n");
        fclose($file);


        $file = "data/data2.txt";
        $fp = fopen($file, 'r');
        while (!feof($fp)){
            
            $txt = fgets($fp);
            $array = explode(",", $txt);
            echo "<tr><td>".$array[0]."</td>";
            echo "<td>".$array[1]."</td>";
            echo "<td>".$array[2]."</td>";
            echo "<td>".$array[3]."</td>";
            echo "<td>".$array[4]."</td></tr>";
            
        }
        fclose($fp);

    ?>

</table>

<ul>
    <li><a href="kadai.php">戻る</a></li>
</ul>

</body>
</html>