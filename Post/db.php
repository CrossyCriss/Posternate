<?php

$post = $_POST['id'];
$option = $_POST['l'];
$cookie = $_COOKIE['POST'];
$expire = time()+60*60*24*7;
if(!isset($cookie)){
require_once('connect.php');
if($option == 1){
	mysqli_query($link , "UPDATE post SET rating=rating+1 WHERE associd='$post'");
}
else
	mysqli_query($link , "UPDATE post SET rating=rating-1 WHERE associd='$post'");
	mysqli_close($link);
	setcookie("POST", "$post", "$expire", "/");
}
?>