<?php date_default_timezone_set('Europe/Berlin');
date_default_timezone_set('Europe/Berlin');
error_reporting (E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
if($username){}else header('Location: /accounts/signin');
require ('connect.php');

if (isset($_POST['check'])){
$values = $_POST['check'];
foreach($values as $value){
mysqli_query($link , "UPDATE message SET viewer_delete='1', opened='1' WHERE id='$value' LIMIT 1");
}
header("location: /message/");
}
?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<script type="text/javascript" src="/jquery.js"></script>

<script type="text/javascript" src="script.js"></script>

<script type="text/javascript">
function mark(msgid){
	$.post("open.php", { messageid:msgid }, function(data){
		$('#open_'+msgid).addClass('read');
	});
}
</script>

<link rel="shortcut icon" type="image/x-icon" href="/Images/favicon.ico">

<link href="/message/style.css" rel="stylesheet" type="text/css">

<title>
Posternate - Message
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


	<?php date_default_timezone_set('Europe/Berlin');
	echo "<div class='dmenu'>
	<a href='/accounts/settings' class='font dtext'>Account settings</a>
	<a href='/accounts/signout' class='font dtext'>Sign out</a>
	<a href='/user/".htmlentities($username, ENT_QUOTES)."' class='font dtext'>My channel</a>
	<a href='/message/new/' class='font dtext'>New message</a>
	</div>";
	?>
	
	<div class='smenu'>
	<table>
	<tr>
	<td><a class='stext'>Search:</a></td>
	<td><a class='stext'>Posts</a></td><td><input type='radio' name='1' class='rad' title='Search Posts' checked onclick="document.sform.action = '/search';"></td>
	<td><a class='stext'>Accounts</a></td><td><input type='radio' name='1' class='rad' title='Search Accounts' onclick="document.sform.action = '/search/accounts';"></td>
	</tr>
	</table>
	</div>
<div class='mainmsg'>Inbox</div>
<div id='top'></div>
<?php date_default_timezone_set('Europe/Berlin'); require_once('process.php'); ?>
</div>
</div>
</body>

</html>