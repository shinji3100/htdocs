<?php


session_start();

$_SESSION["name"] = "γγΎγγ";
$_SESSION["num"] = 100;

echo $_SESSION["name"];
echo $_SESSION['num'];

?>
