<?php

// try{
//     $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
// }catch(PDOException $e){
//     exit('DBError'.$e->getMessage());
// }

// $sql = "SELECT indate FROM kadai_table WHERE u_id=:lid AND u_pw=:lpw";
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':lid', $lid);
// $stmt->bindValue(':lpw', $lpw);
// $status = $stmt->execute();

// INSERT INTO kadai_table()SELECT COALESCE(MAX(toukou_no)+1,1)

// $timestamp = strtotime("now");
// var_dump($timestamp);

$array = array(
	"name" => "あらゆ" ,
	"gender" => "男" ,
	"blog" => array(
		"name" => "SYNCER" ,
		"published" => "2014-06-10" ,
		"url" => "https://syncer.jp/" ,
	),
);
var_dump($array);
echo $array;
?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    console.log(<?=$array?>)
</script>

