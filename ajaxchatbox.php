<?php require_once "verification.php" ?>
<?php

if(!isset($_GET['token']) or ($_GET['token'] == "")) {
    header('Location: /home.php');
}else{
    // IMPORTANT! The token is user input.
    // Escape token string before using it to access the database.
    $chat_token = mysqli_real_escape_string($con, $_GET['token']);
}

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '$chat_token'");
$row = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 0){
    // No chatroom matches the given token.
    header('Location: /home.php#wrongtoken');
}

//print_r($row);

$chat_id = $row['id'];
$chat_name = $row['name'];
$chat_code = $row['code'];
$chat_language = $row['language'];

?>

<body>

<div id="chatmenu">Token: <?php echo $chat_token?></div>

<div id="everything">

<div id="area" style="opacity:0; margin-bottom:250px;">

    <div id="tokenmessage">
        This chatroom's token is <b><?php echo $chat_token?></b>. Share it with whoever you want to invite them in.
    </div>

    <div class="spacer" style="height:60px"></div>

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

    var currentChat = <?php echo $chat_id ?>;
    messageCount[currentChat] = <?php echo $messagecount ?>;
    missedMessages[currentChat] = 0;
    windowBlurred = false;
    saved[currentChat] = false;

    $(document).ready(function() {
        document.title = 'Codechat / <?php echo html_entity_decode($chat_name)?>';
        setTimeout(Prism.highlightAll,1);
        setTimeout('$("#area").css("opacity",1)',20);
        setInterval(getMessageCount, 100);
    });

    $(window).scroll(function(event){

        didScroll = true;

        if ($(window).scrollTop() == 0){

            menuActive = true;

            // Token message appears at the top of the chat
            $("#tokenmessage").css("opacity",1);
            setTimeout('$("#tokenmessage").removeClass("floating")', 400);

        }else if ($(window).scrollTop() <= 35){

            menuActive = false;

            // Parallax effect
            $("#tokenmessage").css("margin-top", -($(window).scrollTop() / 2));

            // Token message disappearance effect
            $("#tokenmessage").css("opacity",  -($(window).scrollTop()) / 35 + 1);

        }else if ($(window).scrollTop() > 35){

            menuActive = false;

            // Parallax effect
            //$("#tokenmessage").css("margin-top",  anchor - ($(window).scrollTop()/ 2));


            // Restore message back to original position
            $("#tokenmessage").css("margin-top", 0);

            // Hide message every time the user scrolls after 36px from the top
            $("#tokenmessage").css("opacity", 0);

            // Remove animations
            setTimeout('$("#tokenmessage").removeClass("bouncyEntranceFromTop")',400);

        }

    });

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
            url: "sql_retrievemessages.php?chat_id=" + <?php echo $chat_id ?> + "&lastMessage=" + messageCount[currentChat],
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

    function getMessageCount(){

        $.ajax({
            type: "GET",
            url: "sql_countmessages.php?chat_id=" + <?php echo $chat_id ?>,
            dataType: "html",   //expect html to be returned
            success: function(response){

                if (response > messageCount[currentChat]){

                    if($(this).scrollTop() + $(window).height() < $(document).height()){
                        //refreshChat();
                    }else{
                        //refreshChat();
                        goToBottom();
                    }

                    // IF TAB IS NOT ACTIVE, SHOW (1) WITH THE NUMBER OF MESSAGES UNATTENDED
                    if (windowBlurred){
                        //missedMessages[currentChat]++;
                        document.title = '(' + missedMessages[currentChat] + ') Codechat / <?php echo html_entity_decode($chat_name)?>';
                    }

                }

                messageCount[currentChat] = response;

            }

        });

    }

    $(window).focus(function() {
        windowBlurred = false;
        missedMessages[currentChat] = 0;
        document.title = 'Codechat / <?php echo $chat_name?>';
    });

    $(window).blur(function() {
        windowBlurred = true;
    });

    function toggleTokenMessage(){

        if ($(window).scrollTop() > 35){

            if (menuActive) {
                menuActive = false;

                $("#tokenmessage").css("opacity", 0);
                setTimeout('$("#tokenmessage").removeClass("bouncyEntranceFromTop")', 400);

            }

            else {
                menuActive = true;
                anchor = $(window).scrollTop();

                $("#tokenmessage").css("opacity", 1);
                $("#tokenmessage").addClass("bouncyEntranceFromTop");

            }

        }else{

            $("#tokenmessage").addClass("bouncy");
            setTimeout('$("#tokenmessage").removeClass("bouncy")', 1000);

        }

    }

<?php

    $result = mysqli_query($con, "SELECT * FROM relations WHERE user = $activeuser_id");
    while($row = mysqli_fetch_array($result)){
        if ($row['chat'] == $chat_id){
            ?>
saved[currentChat] = true;
$("#saveChatroomButton").html("remove");
$("#saveChatroomButton").addClass("clicked");
            <?php
        }
    }

?>

    function saveChatroom(){

        if(!saved[currentChat]){

            $("#saveChatroomButton").html("saving...");

            $.ajax({
                type: "GET",
                url: "sql_createrelation.php?chat_id=" + <?php echo $chat_id ?>,
                dataType: "html",   //expect html to be returned
                success: function(successful){
                    if(successful == "1"){
                        saved[currentChat] = true;
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
                        saved[currentChat] = false;
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

            /*displayMessage("Click on the name of the chatroom to reveal the token.");
            window.location.hash = "";*/
            
        }

        if (hash == "h" && !saved[currentChat]){

            // The user has accessed this chatroom entering a token on the homescreen.
            // The chatroom hasn't been saved to the homescreen.

            displayMessage("Save this chatroom to access it from the home screen anytime.");
            window.location.hash = "";

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