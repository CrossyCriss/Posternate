<?php

if($_POST['poster2']){

$poster = $_POST['poster2'];

$cid = $_POST['id2'];

$rate = $_POST['r2'];

$rate = $rate - 1;

require ('connect.php');

mysqli_query($link , "UPDATE comment SET rating=rating-1 WHERE cid='$cid' AND associd='$poster'");

mysqli_close($link);

}
else
	return false;

if($rate >= 1){
		$rate =  "+".number_format($rate)."";
	}
	else
		$rate = "".number_format($rate)."";

echo $rate;

?>