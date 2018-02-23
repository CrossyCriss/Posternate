<?php

date_default_timezone_set('Europe/Berlin');

//Set a cookie to stop people like spamming, also, prevent multiple clicks for comment like


error_reporting (E_ALL ^ E_NOTICE);
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

require ('connect.php');

function strip($input){
	if(get_magic_quotes_gpc()){
	$input = stripslashes($input);
	}
return $input;
}

$post = $_GET['view'];
if($post){
	$expire = time()+60*60*24*7;
	setcookie("VIEW", "$post", "$expire", "/");
}else header('Location: /');

$dbquery = mysqli_query($link , "SELECT * FROM post WHERE associd='$post'");
$row = mysqli_fetch_assoc($dbquery);
$dbuser = $row['creator'];
$dbtitle = $row['title'];
$dbdesc = $row['description'];
$dbcontent = $row['content'];
$dbthumb = $row['thumbnail'];
$dbdate  = $row['date'];
$dbview = $row['view'];
$dbrate = $row['rating'];

$cookie = $_COOKIE['VIEW'];




$query = mysqli_query($link , "SELECT `id` FROM `message` WHERE `to`='". mysqli_real_escape_string($link , $username) ."' AND `viewer_delete`='0' AND `opened`='0'");
$numrows = mysqli_num_rows($query);

?>
<!DOCTYPE html>
<html>

<head>

<meta name="description" content="<?php echo "$dbdesc - For more posts like this, sign up to Posternate and keep up to date"; ?>" />

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<script type="text/javascript" src="/jquery.js"></script>

<script type="text/javascript" src="script.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="/Images/favicon.ico">

<link href="/posts/style.css" rel="stylesheet" type="text/css">

<title>
<?php if($numrows){ echo "($numrows) "; }  echo "$dbtitle"; ?> - Posternate
</title>

</head>

<body>

<div id="topbar">
<div id="header">
<div class='tpadding'>
<input type="image" id="icon" title="Home" src="/Images/icon.png" onclick="location.href='/'" onmouseover=javascript:this.src='/Images/iconp.png'; onmouseout=javascript:this.src='/Images/icon.png';>
<?php
include('account.php');
include('search.php');
?>
</div>
</div>
</div>

<div id="container">

<div id="rside">
	<?php
	$return = ret($link, $dbuser, $dbtitle, $dbdesc);
	function ret($link, $dbuser, $dbtitle, $dbdesc){
	$end = 5;
	$query = mysqli_query($link , "SELECT creator, title, rating, thumbnail, associd FROM `post` WHERE creator LIKE '$dbuser' OR title LIKE '$dbtitle' OR description LIKE '$dbdesc' ORDER BY `date` DESC");
	if($query){
	while($row = mysqli_fetch_assoc($query)){
	$fetch[] = array(
	'creator' => $row['creator'],
	'title' => $row['title'],
	'rating' => $row['rating'],
	'id' => $row['associd'],
	'thumbnail' => $row['thumbnail'],
	);
	}
	return $fetch;
	}
	}
	
	if($return){
		echo '<div class="box">Related:</div>';
		$lastelement = end($return);
		foreach($return as $returned){
		//Image
		if($returned['thumbnail'] == 1){
			$timage = "/posts/data/thumbs/".$returned['id'].".png";
		}
		else
			$timage = "/posts/data/thumbs/default.png";
		//Text
		if($returned['rating'] >= 1){
			$rate = "+".number_format($returned['rating'])."";
		}
		else
			$rate = "".number_format($returned['rating'])."";
		if($returned==$lastelement){
		echo '<div class="cbox">
		<a href="/posts/?view='.$returned['id'].'"><img src="'.$timage.'" class="poimg" width="100" height="60" title="'.ucfirst($returned['title']).'" /></a>
		<div class="qtext">
		<p><a href="/posts/?view='.$returned['id'].'" title="'.ucfirst($returned['title']).'">'.ucfirst($returned['title']).'<br /></a></p>
		<p>By: <a href="/user/'.$returned['creator'].'">'.$returned['creator'].'<br /></a></p>
		<p>Rating: '.$rate.'</p>
		</div>
		</div>';
		}
		else echo '<div class="box">
		<a href="/posts/?view='.$returned['id'].'"><img src="'.$timage.'" class="poimg" width="100" height="60" title="'.ucfirst($returned['title']).'" /></a>
		<div class="qtext">
		<p><a href="/posts/?view='.$returned['id'].'" title="'.ucfirst($returned['title']).'">'.ucfirst($returned['title']).'<br /></a></p>
		<p>By: <a href="/user/'.$returned['creator'].'">'.$returned['creator'].'<br /></a></p>
		<p>Rating: '.$rate.'</p>
		</div>
		</div>';
		}
	}
	else echo '<div class="cbox"><div class="text">No related posts</div><div id="finished"></div></div>';

	?>
</div>



<div id="side">
<div class="posts">
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
	<a href='<?php echo "/user/".htmlentities($username, ENT_QUOTES).""; ?>' class='font dtext'>My channel</a>
	<a href='/message' class='font dtext'><?php echo "Messages"; if($numrows){ echo " ($numrows)"; } ?></a>
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

<?php

if($cookie !== $post){
$add = mysqli_query($link , "UPDATE `post` SET `view`=view + 1 WHERE `associd`='$post'");
}

	if($dbrate >= 1){
		$dbrate =  "+".number_format($dbrate)."";
	}
	else
		$dbrate = "".number_format($dbrate)."";
	
	$timestamp = strtotime($dbdate);
	$diff = time() - $timestamp;
	
	if($diff < 60){
		$time = "".$diff." second".(($diff == 1)?'':'s')." ago";
	}
		elseif($diff < 3600){
			$diff = floor($diff / 60);
			$time = "".$diff." minute".(($diff == 1)?'':'s')." ago";
		}
			elseif($diff < 86400){
				$diff = floor($diff / 3600);
				$time = "".$diff." hour".(($diff == 1)?'':'s')." ago";
			}
				elseif($diff < 604800){
					$diff = floor($diff / 86400);
					$time = "".$diff." day".(($diff == 1)?'':'s')." ago";
				}
					else
						$time = date('jS F Y', strtotime($dbdate));

if($dbthumb == 1){
		$timage = "/posts/data/thumbs/".$post.".png";
	}
	else
		$timage = "/posts/data/thumbs/default.png";
		

echo "<div class='box'><img src='".$timage."' class='poimg' width='120' height='80' title='".ucfirst($dbtitle)."' />
<span class='ttext'><p><a class='rtext'>".ucfirst($dbtitle)."</a><br /></P>
<p>".ucfirst($dbdesc)."<br /></p>
<p>By: </a><a class='ltext' href='/user/".htmlentities($dbuser, ENT_QUOTES)."'>$dbuser</a></p></span>
<span class='rttext'>
<p>".$time."<br /></p>
<p>".number_format($dbview)." view".(($dbview == 1)?'':'s')."<br /></p>
<form id='like'><input type='submit' name='dbminus' value='' class='dbminus'><input type='submit' name='dbplus' value='' class='dbplus'><input type='hidden' name='poster' value='$post'></form> $dbrate
</span>
</div>
<div id='post'>
<p>".nl2br(ucfirst($dbcontent))."</P>
</div>";

?>
<?php
function secure($link , $input){
	if(get_magic_quotes_gpc()){
		$input = stripslashes($input);
	}
		$result = mysqli_real_escape_string($link , $input);
		return $result;
}
	
if(isset($_POST['comment'])){
$comment = $_POST['comment'];
if($comment == ""){
$error = '"You haven\'t typed anything"';
}
else
	if(strlen($comment) <= 200){
		if($username){
			$getuser = secure($link , $username);
			$getcomment = secure($link , $comment);
			$cid = md5(uniqid().mt_rand());
			$date = date('Y-m-d H:i:s');
			$submit = mysqli_query($link , "INSERT INTO comment VALUES ('', '$post', '$cid', '$getuser', '$getcomment', '0', '$date')");
			if($submit){
			$error = '"Your comment posted successfully"';
			}
			else
				$error = '"Your comment didn\'t post"';
		}
		else
			$error = '"You must log in to post comments"';
	}
	else
		$error = '"Your comment is too long"';
}
if($error){
	echo "<div class='cbox'>Comments:</div>
<form method='post'>
<div class='cbox'><textarea name='comment' id='comment' placeholder=$error></textarea><input type='submit' class='cpbutton' value='Post'></div>
</form>";
}
else
	echo "<div class='cbox'>Comments:</div>
<form method='post'>
<div class='cbox'><textarea name='comment' id='comment' placeholder='Click here to comment'></textarea><input type='submit' class='cpbutton' value='Post'></div>
</form>";

require_once('loader.php');

mysqli_close($link);

?>
</div>



</div>
</body>

</html>