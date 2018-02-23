<?php
$to = mysqli_real_escape_string($link , $username);

$load = $_POST['value'];
if(isset($_POST['value'])){
	if(isset($_POST['load'])){
		$load = $load + 5;
	}
}
else $load = 5;

$return = retrieve($to, $load, $link);

if($return){
?>

	<form method='post' action='/message/new'>
	<input type='submit' value='New message' class='cbox margin right' title='Send a new message'>
	</form>

	<form method='post'>
	<input type='submit' class='cbox margin' value='Delete' title='Delete selected messages'>
	<table class='msgbox' cellpadding='8' cellspacing='0' width='100%'>
	<tr>
	<td class='checkboarder topmsg'><input type='checkbox' id='mcheck'></td><td class='from topmsg'><a class='msgc'>From</a></td><td class='subject topmsg'><a class='msgc'>Subject</a></td><td class='date topmsg'><a class='msgc date'>Received</a></td>
	</tr>
	
<?php
	//secure, make reply post, onclick tr expand, add profile images, add pagignation, make $num the total to fix bugs
	foreach($return as $returned){
	$timestamp = strtotime($returned['date']);
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
						$time = date('jS F Y', strtotime($returned['date']));
						//need to remove id and change to assoc
?>

	<tr class='hover'>
	<td class='tdtop checkboarder'><input type='checkbox' class='check' name='check[]' value='<?php echo $returned['id']; ?>'></td>
	<td class='tdtop msgc from'><a class='msgs' href='/user/<?php echo "".htmlentities($returned['from'], ENT_QUOTES).""; ?>'><?php echo "".$returned['from'].""; ?></a></td>
	<td class='tdtop subject'>
	<span class='toggle'>
	<a class='<?php if($returned['opened'] == 1){ echo "msg read"; }else echo "msg"; ?>' id='open_<?php echo $returned['id']; ?>' onclick='mark(<?php echo $returned['id']; ?>)'><?php if(strlen($returned['subject'])<40){echo ucfirst($returned['subject']);}else echo "".ucfirst(substr($returned['subject'], 0, 40))."..."; ?></a>
	</span>
	<div class='hidden msgc subject'>
	<?php echo "".nl2br(ucfirst(wordwrap($returned['message'], 40, "\n", true))).""; ?><br />
	<a class='msgs' href='/message/new/?from=<?php echo htmlentities($returned['from'], ENT_QUOTES); ?>&subject=<?php echo htmlentities($returned['subject'], ENT_QUOTES); ?>'>Reply</a><br />
	</div>
	</td>
	<td class='tdtop date'>
	<a class='msgc date'><?php echo $time; ?></a>
	</td>
	</tr>

<?php
	$nquery = mysqli_query($link , "SELECT * FROM `message` WHERE `to`='$to' AND `viewer_delete`='0'");
	$num = mysqli_num_rows($nquery);
	if($num !== 1){$suffix = 's';}else $suffix = '';
	}
	echo "	</table>
	</form>";

	if($num >= $load){
		echo "<form method='post'><input class='cbox margin' type='submit' name='load' value='Show more' title='Show more messages'><input type='hidden' name='value' value='$load'><span class='msgc'>$load messages shown </span></form>";
	}
	else
		echo "<div class='msgc num'>$num message$suffix</div>";
	}
	else
		echo "<div class='mainmsg'>You have no new messages<a class='right' href='/message/new'><input class='cbox' type='button' value='New message' title='Send a message'></a></div>";

function retrieve($to, $load, $link){
$query = mysqli_query($link , "SELECT * FROM `message` WHERE `to`='$to' AND `viewer_delete`='0' ORDER BY `date` desc LIMIT 0, $load");
while($row = mysqli_fetch_assoc($query)){
$fetch[] = array(
'id' => $row['id'],
'opened' => $row['opened'],
'from' => $row['from'],
'subject' => $row['subject'],
'message' => $row['message'],
'date' => $row['date']
);
}
return $fetch;
}
?>