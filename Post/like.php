<?php

if($_POST['poster1']){

$poster = $_POST['poster1'];

$cid = $_POST['id1'];

$rate = $_POST['r1'];

$rate = $rate + 1;

require ('connect.php');

mysqli_query($link , "UPDATE comment SET rating=rating+1 WHERE cid='$cid' AND associd='$poster'");

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