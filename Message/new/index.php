<?php date_default_timezone_set('Europe/Berlin');
error_reporting (E_ALL ^ E_NOTICE);
require_once('connect.php');
session_start();

function strip($input){
	if(get_magic_quotes_gpc()){
		$input = stripslashes($input);
	}
	return htmlentities($input, ENT_QUOTES);
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

	$query = mysqli_query($link , "SELECT `id` FROM `message` WHERE `to`='". mysqli_real_escape_string($link , $username) ."' AND `viewer_delete`='0' AND `opened`='0'");
	if($query){
	$numrows = mysqli_num_rows($query);
	}
?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<script type="text/javascript" src="/jquery.js"></script>

<script type="text/javascript" src="script.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="/Images/favicon.ico">

<link href="style.css" rel="stylesheet" type="text/css">

<title>
<?php date_default_timezone_set('Europe/Berlin'); if($numrows){ echo "($numrows) "; } ?>Posternate - Stay Posted
</title>

</head>

<body>

<div id="topbar">
<div id="header">
<div class='tpadding'>
<input type="image" id="icon" title="Home" src="/Images/icon.png" onclick="location.href='/'" onmouseover=javascript:this.src='/Images/iconp.png'; onmouseout=javascript:this.src='/Images/icon.png';>
<?php date_default_timezone_set('Europe/Berlin');
//header needs reform
include('account.php');
include('search.php');
?>
</div>
</div>
</div>

<div id="container">

<div id="side">
<div class="padding">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ad -->
<ins class="adsbygoogle"
     style="display:inline-block;width:160px;height:600px"
     data-ad-client="ca-pub-0669973737683175"
     data-ad-slot="8515540317"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
</div>

<div id="content">
	
	<div class='dmenu'>
	<a href='/accounts/signout' class='font dtext'>Sign out</a>
	<a href='/accounts/settings' class='font dtext'>Account settings</a>
	<a href='<?php date_default_timezone_set('Europe/Berlin'); echo "/user/".htmlentities($username, ENT_QUOTES).""; ?>' class='font dtext'>My channel</a>
	<a href='/message' class='font dtext'><?php date_default_timezone_set('Europe/Berlin'); echo "Messages"; if($numrows){ echo " ($numrows)"; } ?></a>
	</div>
	
	<div class='smenu'>
	<table>
	<tr>
	<td><a class='stext'>Search:</a></td>
	<td><a class='stext'>Posts</a></td><td><input type='radio' name='1' class='rad' title='Search Posts' checked onclick="document.sform.action = '/search';"></td>
	<td><a class='stext'>Accounts</a></td><td><input type='radio' name='1' class='rad' title='Search Accounts' onclick="document.sform.action = '/search/accounts';"></td>
	</tr>
	</table>
	</div>
<?php date_default_timezone_set('Europe/Berlin');
if(isset($_POST['recipient'])){
		$recipient = strip($_POST['recipient']);
	}
	else
		$recipient = strip($_GET['from']);

	$re = strip($_GET['subject']);
	if($re){
		$subject = 'Re: '.$re.'';
	}
	$form = "<div class='padding'>
	<form method='post' action='/message/new/'>
	<table>
	<tr>
	<td><input type='text' name='to' value='$recipient' placeholder='To'></td>
	</tr>
	<tr>
	<td><input type='text' name='subject' value='$subject' placeholder='Subject'></td>
	</tr>
	<tr>
	<td><textarea name='message' placeholder='Message' rows='8'></textarea></td>
	</tr>
	<tr>
	<td><input type='submit' name='send' value='Send'></td>
	</tr>
	</table>
	</form>
	</div>";

if($_POST['send']){
	function secure($input, $link){
		if(get_magic_quotes_gpc()){
			$input = stripslashes($input);
		}
		return mysqli_real_escape_string($link , $input);
	}

	$to = secure($_POST['to'], $link);
	$subject = secure($_POST['subject'], $link);
	$message = secure($_POST['message'], $link);
	$from = secure($username, $link);

	if($to){
	
		if($from){

			if($subject){

				if($message){

						if($from !== $to){

							$query = mysqli_query($link , "SELECT * FROM login WHERE username='$to'");
							$numrows = mysqli_num_rows($query);
							if($numrows == 1){

								$date = date('Y-m-d H:i:s');
								mysqli_query($link , "INSERT INTO message VALUES (
								'', '$to', '$from', '$subject', '$message', '0', '0', '0', '$date'
								)");

								$query = mysqli_query($link , "SELECT * FROM message WHERE `to`='$to' AND `subject`='$subject'");
								$numrows = mysqli_num_rows($query);
								if($numrows >= 1){
								echo "Your message has been sent!";
								}
								else
									echo "ERROR!";

							}
							else
								echo "The username you entered could not be found. $form";

						}
						else
							echo "You cannot send a message to yourself. $form";

				}
				else
					echo "You must enter a message. $form";

			}
			else
				echo "You must enter a subject. $form";
		
		}
		else
			echo "You must sign in to send a message. <a href='/accounts/signin/'>Sign in here.</a> $form";
		

	}
	else
		echo "You must enter a username. $form";

}
else
	echo $form;
?>
</div>

</div>
</body>

</html>