<?php
require ('connect.php');
$open = $_POST['messageid'];
if(isset($open)){
mysqli_query($link , "UPDATE `message` SET `opened`='1' WHERE `id`='$open'");
}
?>