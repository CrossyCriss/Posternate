<?php date_default_timezone_set('Europe/Berlin');
error_reporting (E_ALL ^ E_NOTICE);
require_once('connect.php');
session_start();

function strip($input){
	if(get_magic_quotes_gpc()){
	$input = stripslashes($input);
	}
	return $input;
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
	
	$form = "<div class='padding'>
	<form method='post' action='/posts/new/'>
	<table>
	<tr>
	<td><input type='text' name='title' placeholder='Title'></td>
	</tr>
	<tr>
	<td><input type='text' name='description' placeholder='Description'></td>
	</tr>
	<tr>
	<td><textarea name='content' placeholder='Content' rows='6'></textarea></td>
	</tr>
	<tr>
	<td><input type='submit' name='post' value='Post!'></td>
	</tr>
	</table>
	</form>
	</div>";


	if($_POST['post']){

		$title = strip($_POST['title']);
		$description = strip($_POST['description']);
		$content = strip($_POST['content']);

			if(strlen($title)>=5){

				if(strlen($description)>=10){

					if(strlen($content)>=20){
						//is real escape required for csearch and tsearch
						$csearch = str_replace(array('\'', '"', ',', ';', '<', '>', ' '), '', $username);
						$csearch = mysqli_real_escape_string($link , stripslashes($csearch));
						$tsearch = str_replace(array('\'', '"', ',', ';', '<', '>', ' '), '', $title);
						$tsearch = mysqli_real_escape_string($link , stripslashes($tsearch));
						$dbtitle = mysqli_real_escape_string($link , $title);
						$dbdescription = mysqli_real_escape_string($link , $description);
						$dbcontent = mysqli_real_escape_string($link , $content);
						$dbuser = mysqli_real_escape_string($link , strip($username));
						$associd = md5(uniqid().mt_rand());
						$date = date('Y-m-d H:i:s');

						$submit = mysqli_query($link , "INSERT INTO `post` VALUES (
								'', '$associd', '$dbuser', '$csearch', '$dbtitle', '$tsearch', '$dbdescription', '$dbcontent', '0', '$date', '0', '0'
								)");
						if($submit){
						header ('location:/');
						}
						else
							echo "Error";

					}
					else
						echo "Your post must contain at least 20 charecters.$form";

				}
				else
					echo "Your description must contain at least 10 charecters.$form";

			}
			else
				echo "Your title must contain at least 5 charecters.$form";

	}
	else
		echo $form;

?>
	
</div>
	
	
	

</div>
</body>

</html>