<?php
date_default_timezone_set('Europe/Berlin');
require_once('connect.php');
error_reporting (E_ALL ^ E_NOTICE);
session_start();
echo "<div id='cboxh'>";
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
if($_POST['poster']){
	$post = $_POST['poster'];
	$load = $_POST['value'];
}
else
	$load = 0;
	$value = 1;

$return = retrieve($post, $value, $load, $link);
$count = $load;

$nquery = mysqli_query($link , "SELECT * FROM comment WHERE associd='$post'");
$num = mysqli_num_rows($nquery);

if($return){

	foreach($return as $returned){

	$count = $count + 1;

	if($load >= $num){
		$load = $num;
	}
	else
		$load = $count;
	
	if($returned['crate'] >= 1){
		$rate = "+".number_format($returned['crate'])."";
	}
	else
		$rate = "".number_format($returned['crate'])."";
			
	$timestamp = strtotime($returned['cdate']);
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
						$time = date('jS F Y', strtotime($returned['cdate']));
				
		if($count == $num){
			if($returned['cuser'] == $username){
				echo "<div id='sbcont'><form id='clike'><button class='cross'></button><input type='hidden' name='poster' value='$post'><input type='hidden' name='id' value='".$returned['cid']."'></form><div id='bbox'><a class='ltctext' href='/user/".htmlentities($returned['cuser'], ENT_QUOTES)."'>".$returned['cuser']." </a>$time<a class='rtctext'>".$rate."</a><br /><span class='otext'>".$returned['ccomment']."</span></div></div>";
			}
			else
				echo "<div id='sbcont'><form id='clike'><button class='minus'></button><button class='plus'></button><input type='hidden' name='poster' value='$post'><input type='hidden' name='rater' value='$rate'><input type='hidden' name='id' value='".$returned['cid']."'></form><div id='bbox'><a class='ltctext' href='/user/".htmlentities($returned['cuser'], ENT_QUOTES)."'>".$returned['cuser']." </a>$time<a class='rtctext'>".$rate."</a><br /><span class='otext'>".$returned['ccomment']."</span></div></div>";
		}
		else
			if($returned['cuser'] == $username){
				echo "<div id='sbcont'><form id='clike'><button class='cross'></button><input type='hidden' name='poster' value='$post'><input type='hidden' name='id' value='".$returned['cid']."'></form><div id='bbox'><a class='ltctext' href='/user/".htmlentities($returned['cuser'], ENT_QUOTES)."'>".$returned['cuser']." </a>$time<a class='rtctext'>".$rate."</a><br /><span class='otext'>".$returned['ccomment']."</span></div></div>";
			}
			else
				echo "<div id='sbcont'><form id='clike'><button class='minus'></button><button class='plus'></button><input type='hidden' name='poster' value='$post'><input type='hidden' name='rater' value='$rate'><input type='hidden' name='id' value='".$returned['cid']."'></form><div id='bbox'><a class='ltctext' href='/user/".htmlentities($returned['cuser'], ENT_QUOTES)."'>".$returned['cuser']." </a>$time<a class='rtctext'>".$rate."</a><br /><span class='otext'>".$returned['ccomment']."</span></div></div>";		
		
	}

	if($num >= $load + 1){
		echo "<div id='bbox'><div id='bcont'><button type='button' class='cbutton' type='submit' title='Show more messages'>Show more</button><form id='load'><input type='hidden' name='value' value='$load'><input type='hidden' name='poster' value='$post'></form></div></div>";
	}
	
}

function retrieve($post, $value, $load, $link){
$cquery = mysqli_query($link , "SELECT * FROM comment WHERE associd='$post' ORDER BY `date` desc LIMIT $load, $value");
while($row = mysqli_fetch_assoc($cquery)){
$fetch[] = array(
'ccomment' => $row['comment'],
'cuser' => $row['user'],
'crate' => $row['rating'],
'cdate' => $row['date'],
'cid' => $row['cid']
);
}
return $fetch;
mysqli_close($link);
}
echo "</div>";
?>