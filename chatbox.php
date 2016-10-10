<!doctype html>
<html>

<?php require_once "verification.php" ?>

<?php

if(!isset($_GET['token']) or ($_GET['token'] == "")) {
    header('Location: home.php');
}else{
    $chat_token = $_GET['token'];
	//$chat_id = $_GET['id'];
}

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '$chat_token'");
$row = mysqli_fetch_array($result);

//print_r($row);

$chat_id = $row['id'];
$chat_name = $row['name'];
$chat_code = $row['code'];
$chat_language = $row['language'];

?>

<head>
<meta charset="utf-8">
<title>Codechat / <?php echo html_entity_decode($chat_name)?></title>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link href="css/generic.css" rel="stylesheet" />
<link href="css/prism.css" rel="stylesheet" />
<link href="css/codemirror.css" rel="stylesheet" />
<link rel="stylesheet" href="css/3024-day.css">

<style>

#area{opacity:0; margin-bottom:250px;}

</style>

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>
<script src="libraries/Semantic-UI-CSS-master/semantic.min.js"></script>
<script src="scripts/prism.js"></script>

<div id="header">
    <a href="home.php">codechat</a> / <a onClick="showMenu()"><?php echo $chat_name ?></a>
    <span id="saveChatroomButton" class="unclicked" onclick="saveChatroom()">save</span>
    <div id="savePrompt" class="prompt">Save this chatroom to access it from the home screen anytime.</div>
    <span id="userinfo"><b><a style="border:none; opacity:1;" href="profile.php?u=<?php echo $activeuser_id?>"><?php echo $activeuser_name ?></a></b> (<a href="logout.php">Log out</a>)

<a href="profile.php?u=<?php echo $activeuser_id?>">
<div class="smallavatar" style="margin:0; margin-top:-20px;">

<?php 
if (file_exists("avatars/".$activeuser_id.".gif")) echo "<img src='avatars/".$activeuser_id .".gif'>";
else echo "<img src='images/placeholder". $activeuser_id % 5 .".gif'>";
?>

</div>
</a>

</span></div>

<div id="chatmenu">Token: <?php echo $chat_token?></div>

<div id="everything">

<div id="area">

<?php

$result = mysqli_query($con, "SELECT * FROM messages WHERE chat = $chat_id");
$messagecount = mysqli_num_rows($result);
$i = 0;
$lastMessage = 0;

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

<?php if (strpos($content,"\n")) {?>

<div class="code">
<pre class="line-numbers" style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
</div>

<?php }else{ ?>

<div class="code">
<pre style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
</div>

<?php } // DISPLAY LINE NUMBERS IF CODE HAS AT LEAST ONE LINE BREAK ?>

<br>

</div>

<?php

}

?>

</div>

</div>

<div class="centerarea">
    <textarea id="usercontrols" onclick="blurBackground()" onblur="restoreBackground()" spellcheck="false" placeholder="Reply in <?php echo $chat_language ?>"></textarea>
    <div id="bottomFade"></div>
</div>

<script type="text/javascript">

$(window).load(function() {
	setTimeout('$("#area").css("opacity",1)',20);
	setTimeout(Prism.highlightAll,1);
});

var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('#header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        /*$('#header').css("font-size","24px");
		$('#header').css("height","24px");
		$('#userinfo').css("padding","7px 20px");
		$('#userinfo').addClass("userinfo-small");
        $('#saveChatroomButton').css("top", "24px");
        $("#chatmenu").css("top","38px");*/
		
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            /*$('#header').css("font-size","36px");
			$('#header').css("height","50px");
			$('#userinfo').css("padding","20px");
			$('#userinfo').removeClass("userinfo-small");
            $('#saveChatroomButton').css("top", "33px");
			$("#chatmenu").css("top","68px");*/
        }
    }
    
    lastScrollTop = st;
}

function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

$('#usercontrols').keydown(function(e) {
    if(e.which == 13) {
        sendMessage();
    }
});

function goToBottom(){
	$('html, body').animate({scrollTop:$(document).height()}, 'slow');
}

function refreshChat(){

	$.ajax({
        type: "GET",
        url: "sql_retrievemessages.php?chat_id=" + <?php echo $chat_id ?> + "&lastMessage=" + messageCount,
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#area").append(response);
			setTimeout(Prism.highlightAll,1);
        }

    });

}

function sendMessage() {                
		
		message = document.getElementById("usercontrols").value;
		//pre_user_name = "";
		//user_name = user_name.split(' ').join('+');
		
      $.ajax({
        type: "GET",
        url: "sql_postcomment.php?message=" + encodeURIComponent(message) + "&chat_id=" + <?php echo $chat_id ?> + "&user_id=<?php echo $activeuser_id ?>",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            //$("#responsecontainer").html(response); 
			$('#usercontrols').val('')
            //refreshChat();
			setTimeout(goToBottom,100);

        }

    });
}

messageCount = <?php echo $messagecount ?>;
var missedMessages = 0;
var windowBlurred = false;

function getMessageCount(){

	$.ajax({
        type: "GET",
        url: "sql_countmessages.php?chat_id=" + <?php echo $chat_id ?>,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            if (response > messageCount){
                if($(this).scrollTop() + $(window).height() < $(document).height()){
                    refreshChat();
                }else{
                    refreshChat();
                    goToBottom();
                }
				messageCount = response;
				
				// IF TAB IS NOT ACTIVE, SHOW (1) WITH THE NUMBER OF MESSAGES UNATTENDED
				if (windowBlurred){
					missedMessages++;
					document.title = '(' + missedMessages + ') Codechat / <?php echo $chat_name?>';
				}
				
			}
			else{
				messageCount = response;
			}
        }

    });	

}

window.onload = function() {
    setInterval(getMessageCount, 100);
};

$(window).focus(function() {
	windowBlurred = false;
    missedMessages = 0;
	document.title = 'Codechat / <?php echo $chat_name?>';
});

$(window).blur(function() {
    windowBlurred = true;
});

var menuActive = false;

function showMenu(){
	
	if (menuActive){
		menuActive = false
		$("#chatmenu").css("height","0px");
        toggleBackgroundOpacity(1);
	}
		
	else{
		menuActive = true
		$("#chatmenu").css("height","100px");
        toggleBackgroundOpacity(0.5);
	}
		
}

var saved = false;

<?php

    $result = mysqli_query($con, "SELECT * FROM relations WHERE user = $activeuser_id");
    while($row = mysqli_fetch_array($result)){
        if ($row['chat'] == $chat_id){
            ?>
saved = true;
$("#saveChatroomButton").html("remove");
$("#saveChatroomButton").addClass("clicked");
            <?php
        }
    }

?>

function saveChatroom(){

    if(!saved){

        $("#saveChatroomButton").html("saving...");

        $.ajax({
            type: "GET",
            url: "sql_createrelation.php?chat_id=" + <?php echo $chat_id ?>,
            dataType: "html",   //expect html to be returned
            success: function(successful){
                if(successful == "1"){
                    saved = true;
                    $("#saveChatroomButton").html("remove");
                    $("#saveChatroomButton").removeClass("clicked");
                    $("#saveChatroomButton").addClass("clicked");
                }
                else{
                    console.log("There was an error saving the chatroom.")
                }
            }

        });

    }else{

        $("#saveChatroomButton").html("removing...");

        $.ajax({
            type: "GET",
            url: "sql_removerelation.php?chat_id=" + <?php echo $chat_id ?>,
            dataType: "html",   //expect html to be returned
            success: function(successful){
                if(successful == "1"){
                    saved = false;
                    $("#saveChatroomButton").html("save");
                    $("#saveChatroomButton").addClass("unclicked");
                    $("#saveChatroomButton").removeClass("clicked");
                }
                else{
                    console.log("There was an error removing the chatroom.")
                }
            }

        });

    }

}

    function blurBackground(){

        $("#area").css("opacity", 0.5);
        //$("#area").css("margin-top", "-190px");

    }

    function restoreBackground(){

        $("#area").css("opacity", 1);
        //$("#area").css("margin-top", "0px");

    }

    function getHashValue(key) {
        var matches = location.hash.match(new RegExp(key+'([^&]*)'));
        return matches ? matches[1] : null;
    }

    function showPrompt(){
        $("#savePrompt").css("opacity",1);
        $("#savePrompt").css("width","500px");
    }

    function hidePrompt(){
        $("#savePrompt").css("opacity",0);
        $("#savePrompt").css("width","0px");
    }

    if(window.location.hash) {

        var hash = getHashValue('#');

        if (hash == "c"){
            // The user has accessed this chatroom automatically after creating it.
            displayMessage("Click on the name of the chatroom to reveal the token.");
            window.location.hash = "";
        }

        if (hash == "h" && !saved){
            // The user has accessed this chatroom entering a token on the homescreen.
            // The chatroom hasn't been saved to the homescreen.
            displayMessage("Save this chatroom to access it from the home screen anytime.");
        }

    }


    function displayMessage(message){

        $("#savePrompt").html(message);

        setTimeout("showPrompt()", 500);
        setTimeout("hidePrompt()", 3500);

    }

</script>

</body>
</html>