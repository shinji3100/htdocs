<?php

session_start();

if(!isset($_GET["id"]) || $_GET["id"]==""){
    exit("ParamError");
}

$id = intval($_GET["id"]);

unset($_SESSION["cart"][$id]);

 header("Location: cart.php");
 exit();


?>