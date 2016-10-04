<?php

$con = mysqli_connect("localhost","root","root","codechat");

$chat_id = $_GET['chat_id'];
$lastMessage = $_GET['lastMessage'];

$result = mysqli_query($con, "SELECT language FROM chats WHERE id = $chat_id");
$chat = mysqli_fetch_array($result);

$chat_language = $chat['language'];

// Retrieves up to 9000 (presumably unreachable number) messages added after the last message.
$result = mysqli_query($con, "SELECT * FROM messages WHERE chat = $chat_id LIMIT $lastMessage, 12");

$i = $lastMessage;

while ($message = mysqli_fetch_array($result)){
	
	$i++;
    $lastMessage = $i;
	
	$author_id = $message['author'];
	$content = $message['content'];
	$time = strtotime($message['time']);
	
		$month = date( "F", $time);
		$week = date( "D", $time);
		$day = date( "d", $time);
		$hour = date( "H", $time);
		$minute = date( "i", $time);
	
		$result2 = mysqli_query($con, "SELECT * FROM users WHERE id = $author_id");
		$author= mysqli_fetch_array($result2);
		
		$author_name = $author['name'];

?>

    <div class="avatar">

    <?php
    if (file_exists("avatars/".$author_id.".gif")) echo "<img src='avatars/".$author_id .".gif'>";
    else echo "<img src='images/placeholder". $author_id % 5 .".gif'>";
    ?>

    </div>
    <div class="message" id="message<?php echo $i ?>">
    <div class="sender">
    <a href="profile.php?u=<?php echo $author_id?>">
    <?php echo $author_name ?>
    </a>

    <a href="#message<?php echo $i ?>"><span class="messagenumber">#<?php echo $i ?></span></a>
    </div>
   
<?php if (strpos($content,'<br />')) {?>

    <div class="code">
    <pre class="line-numbers" style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
    </div>

<?php }else{ ?>

    <div class="code">
    <pre style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
    </div>

<?php } // DISPLAY LINE NUMBERS IF CODE HAS AT LEAST ONE LINE BREAK ?>

<br>
<div class="time">
<?php 

if ($time >= strtotime("today"))
    echo "Today, ".$hour.":".$minute;
		
else if ($time >= strtotime("yesterday"))
    echo "Yesterday, ".$hour.":".$minute;
	
else
	echo $month." ".$day.", ".$hour.":".$minute;

?>
</div>

</div>

<?php

}

?>