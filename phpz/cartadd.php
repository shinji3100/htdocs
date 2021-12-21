<?php

session_start();

if(!isset($_POST["item"]) || $_POST["item"]==""){
    exit("ParamError:item");
}
if(!isset($_POST["value"]) || $_POST["value"]==""){
    exit("ParamError:value");
}
if(!isset($_POST["id"]) || $_POST["id"]==""){
    exit("ParamError:id");
}
if(!isset($_POST["num"]) || $_POST["num"]==""){
    exit("ParamError:num");
}

$id = intval($_POST["id"]);
$item = $_POST["item"];
$value = intval($_POST["value"]);
$num = intval($_POST["num"]);
$fname = $_POST["fname"]; 


$_SESSION["cart"][$id] = array($item,$value,$num,$fname);

header("Location: cart.php?id=" . $id);
exit();

?>