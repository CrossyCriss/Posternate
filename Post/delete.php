<?php

if($_POST['poster']){

$poster = $_POST['poster'];

$cid = $_POST['id'];

require_once('connect.php');

mysqli_query($link , "DELETE FROM comment WHERE cid='$cid' AND associd='$poster'");

mysqli_close($link);

}
else
	return false;

echo "Worked";

?>