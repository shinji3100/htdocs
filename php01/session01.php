<?php


session_start();

$_SESSION["name"] = "やまざき";
$_SESSION["num"] = 100;

echo $_SESSION["name"];
echo $_SESSION['num'];

?>
