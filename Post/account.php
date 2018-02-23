<?php

	if($username && $userid){
		$imagequery = mysqli_query($link , "SELECT `id` FROM `login` WHERE `username`='".mysqli_real_escape_string($link , $username)."' AND `thumbnail`='1'");
		$num = mysqli_num_rows($imagequery);
		if($num == 1){
			$image = "/user/data/image/$username.png";
		}
		else
			$image = "/user/data/image/default.png";

		echo "<input type='submit' class='font img' id='aarrow' value='' title='Settings' />
		<a class='font' href='/user/".htmlentities($username, ENT_QUOTES)."'>$username</a>
		<a href='/user/".htmlentities($username, ENT_QUOTES)."'>
		<img src='$image' id='proimg' width='32' height='32' />
		</a>";
	}
	else
		echo "<a class='font' href='/accounts/signin'>Sign In</a>
		<span class='line'>|</span>
		<a class='font' href='/accounts/signup'>Create Account</a>";
?>