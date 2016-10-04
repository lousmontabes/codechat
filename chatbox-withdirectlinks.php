<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Codechat</title>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<link href="css/generic.css" rel="stylesheet" />

<link href="css/prism.css" rel="stylesheet" />
<link href="css/codemirror.css" rel="stylesheet" />

<link rel="stylesheet" href="css/3024-day.css">

<style>

#area{opacity:0;}

.sender input{
	border:none;
	font-family:open sans;	
}

</style>

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<?php

$con=mysqli_connect("localhost","root","admin","codechat");

if((isset($_GET['id']) == false) or ($_GET['id'] == "")) {
    header('Location: home.php');
}else{
$chat_id = $_GET['id'];
}

if((isset($_GET['name']) == false) or ($_GET['name'] == "")) {
    header('Location: enter.php?id='.$chat_id);
}else{
$active_user_name = $_GET['name'];
}

$result = mysqli_query($con, "SELECT * FROM chats WHERE id = $chat_id");
$row = mysqli_fetch_array($result);

//print_r($row);

$chat_name = $row['name'];
$chat_code = $row['code'];

?>

<div id="fullcode"><!--<pre class='line-numbers'><code class='language-python'># -*- coding: utf-8 -*-</code></pre>-->

<textarea id="codearea"><?php echo $chat_code ?></textarea>

</div>

<script>

var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("codearea"), {
  mode:  "python",
  theme: "3024-day"
});

myCodeMirror.setSize("100%", "100%");

</script>

<script>

function copyMessage(i){
	linkToMessage = "codechat.co/chatbox.php?id=1&name=hey#message" + i;
	$("#senderName" + i).html("<input type='text' value='" + linkToMessage + "' size='55px' spellcheck='false'>");
}

</script>

<div id="header"><a href="home.php">codechat</a> / <?php echo $chat_name ?></div>

<div id="everything">

<div id="area">

<?php

$result = mysqli_query($con, "SELECT * FROM messages WHERE chat = $chat_id");
$messagecount = mysqli_num_rows($result);
$i = 0;

while ($message= mysqli_fetch_array($result)){
	
	$i++;
	
	$author_id = $message['author'];
	$user_name = $message['user_name'];
	$content = $message['content'];
	$time = $message['time'];
	
		$result2 = mysqli_query($con, "SELECT * FROM users WHERE id = $author_id");
		$author= mysqli_fetch_array($result2);
		
		$author_name = $author['name'];

?>

<div class="message" id="message<?php echo $i ?>">
<div class="sender">
<a href="#message<?php echo $i ?>"><span class="messagenumber" onClick="copyMessage(<?php echo $i ?>)"><?php echo $i ?></span></a> 
<span id="senderName<?php echo $i ?>"><?php echo $user_name ?></span>
</div>

<?php if (strpos($content,'<br />') == true) {?>

<div class="code">
<pre class="line-numbers"><code class="language-python"><?php echo $content ?></code></pre>
</div>

<?php }else{ ?>

<div class="code">
<pre><code class="language-python"><?php echo $content ?></code></pre>
</div>

<?php } // DISPLAY LINE NUMBERS IF CODE HAS AT LEAST ONE LINE BREAK ?>

<br>
<div class="time"><?php echo $time ?></div>

</div>

<?php

}

?>

</div>

</div>

<textarea id="usercontrols" spellcheck="false" placeholder="Reply as <?php echo $active_user_name ?>"></textarea>

<script type="text/javascript">

$(window).load(function() {
	setTimeout('$("#area").css("opacity",1)',20);
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
        $('#header').css("font-size","24px");
		$('#header').css("height","24px");
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('#header').css("font-size","36px");
			$('#header').css("height","50px");
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
        url: "sql_retrievemessages.php?chat_id=" + <?php echo $chat_id ?>,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#area").html(response); 
			setTimeout(Prism.highlightAll,1);
        }

    });	

}

function sendMessage() {                
		
		message = nl2br(document.getElementById("usercontrols").value);
		//pre_user_name = "";
		//user_name = user_name.split(' ').join('+');
		
      $.ajax({
        type: "GET",
        url: "sql_postcomment.php?message=" + encodeURIComponent(message) + "&chat_id=" + <?php echo $chat_id ?> + "&user_name=<?php echo $active_user_name ?>",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            //$("#responsecontainer").html(response); 
			$('#usercontrols').val('')
            refreshChat();
			setTimeout(goToBottom,100);
			
        }

    });
}

messageCount = <?php echo $messagecount ?>;

function getMessageCount(){
	$.ajax({
        type: "GET",
        url: "sql_countmessages.php?chat_id=" + <?php echo $chat_id ?>,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            if (response > messageCount){
				refreshChat();
				messageCount = response;
			}
			else{
				messageCount = response;
			}
        }

    });	

}

window.onload = function() {            
    
    setInterval(getMessageCount, 100);
	
}

</script>

</body>
</html>