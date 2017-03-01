<?php require_once "verification.php" ?>
<?php

if(!isset($_GET['token']) or ($_GET['token'] == "")) {
    header('Location: /main.php');
}else{
    // IMPORTANT! The token is user input.
    // Escape token string before using it to access the database.
    $chat_token = mysqli_real_escape_string($con, $_GET['token']);
}

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '$chat_token'");
$row = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 0){
    // No chatroom matches the given token.
    header('Location: /main.php#wrongtoken');
}

//print_r($row);

$chat_id = $row['id'];
$chat_name = $row['name'];
$chat_code = $row['code'];
$chat_language = $row['language'];

?>

<body>

<div id="everything">

<div id="area" style="opacity:0; margin-bottom:250px;">

    <div id="chatbanner">
        <?php include "modules/chatbanner.php" ?>
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
    $type = $message['type'];
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

<?php if ($type == 0){ // Message is code ?>
    <?php if (strpos($content,"\n")) {?>

    <div class="code">
    <pre class="line-numbers" style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
    </div>

    <?php }else{ ?>

    <div class="code">
    <pre style="margin-top:0; margin-bottom:0;"><code class="language-<?php echo strtolower ($chat_language) ?>"><?php echo htmlspecialchars($content) ?></code></pre>
    </div>

    <?php }?>
<?php }else if ($type == 1){ // Message is plain text ?>

    <?php echo htmlspecialchars($content) ?>

<?php } ?>

<br>

</div>

<?php

}

?>

</div>

</div>

<div class="centerarea">
    <textarea id="usercontrols" onclick="//blurBackground()" onblur="//restoreBackground()" spellcheck="false" placeholder="Reply in <?php echo $chat_language ?>"></textarea>
    <div id="bottomFade"></div>
</div>

<script type="text/javascript">

    ChatStatus = {
        UP_TO_DATE: 0,
        DELAYED: 1
    };

    MessageStatus = {
        AVAILABLE: 0,
        ENTER_PRESSED: 1,
        SENDING: 2,
        SENT_SUCCESSFULLY: 3,
        COOLDOWN: 4
    };

    var currentChat = <?php echo $chat_id ?>;
    var messageCount = <?php echo $messagecount ?>;
    var missedMessages = 0;
    var windowBlurred = false;
    var saved = false;
    var status = MessageStatus.AVAILABLE;

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
            $("#chatbanner").css("opacity",1);
            setTimeout('$("#chatbanner").removeClass("floating")', 400);

        }else if ($(window).scrollTop() <= 35){

            menuActive = false;

            // Parallax effect
            $("#chatbanner").css("margin-top", -($(window).scrollTop() / 2));

            // Token message disappearance effect
            $("#chatbanner").css("opacity",  -($(window).scrollTop()) / 35 + 1);

        }else if ($(window).scrollTop() > 35){

            menuActive = false;

            // Parallax effect
            //$("#chatbanner").css("margin-top",  anchor - ($(window).scrollTop()/ 2));


            // Restore message back to original position
            $("#chatbanner").css("margin-top", 0);

            // Hide message every time the user scrolls after 36px from the top
            $("#chatbanner").css("opacity", 0);

            // Remove animations
            setTimeout('$("#chatbanner").removeClass("bouncyEntranceFromTop")',400);

        }

    });

    function nl2br (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    // User pressed enter while focused on the input textarea.
    $('#usercontrols').keydown(function(e) {
        if(e.which == 13 && status == MessageStatus.AVAILABLE) {
            sendMessage();
            status = MessageStatus.COOLDOWN;
        }
    });

    function goToBottom(){
        $('html, body').animate({scrollTop:$(document).height()}, 'slow');
    }

    function refreshChat(){

        $.ajax({
            type: "GET",
            url: "sql_retrievemessages.php?chat_id=" + currentChat + "&lastMessage=" + messageCount,
            dataType: "html",   //expect html to be returned
            success: function(response){
                $("#area").append(response);
                setTimeout(Prism.highlightAll, 1);
            }

        });

    }

    function sendMessage() {

        message = document.getElementById("usercontrols").value;
        //pre_user_name = "";
        //user_name = user_name.split(' ').join('+');

        // Don't send message if text box is empty.
        if (message != "") {

            status = MessageStatus.SENDING;

            $.ajax({
                type: "GET",
                url: "sql_postcomment.php?message=" + encodeURIComponent(message) + "&chat_id=" + <?php echo $chat_id ?>
                                                                                  + "&user_id=" + <?php echo $activeuser_id ?>
                                                                                  + "&message_type=0",
                dataType: "html",   //expect html to be returned
                success: function (response) {
                    //$("#responsecontainer").html(response);
                    $('#usercontrols').val('');
                    //refreshChat();

                    // Move view to bottom of the chat
                    setTimeout(goToBottom, 100);

                    // Set message status to available after a cooldown of 100ms
                    setTimeout('status = MessageStatus.AVAILABLE', 100);

                }

            });

        }

    }

    function getMessageCount(){

        $.ajax({
            type: "GET",
            url: "sql_countmessages.php?chat_id=" + currentChat,
            dataType: "html",   //expect html to be returned
            success: function(response){

                if (response > messageCount){

                    if($(this).scrollTop() + $(window).height() < $(document).height()){
                        refreshChat();
                    }else{
                        refreshChat();
                        goToBottom();
                    }

                    // IF TAB IS NOT ACTIVE, SHOW (1) WITH THE NUMBER OF MESSAGES UNATTENDED
                    if (windowBlurred){
                        missedMessages++;
                        document.title = '(' + missedMessages + ') Codechat / <?php echo html_entity_decode($chat_name)?>';
                    }

                    messageCount = response;

                }

            }

        });

    }

    $(window).focus(function() {
        windowBlurred = false;
        missedMessages = 0;
        document.title = 'Codechat / <?php echo $chat_name?>';
    });

    $(window).blur(function() {
        windowBlurred = true;
    });

    function togglechatbanner(){

        if ($(window).scrollTop() > 35){

            if (menuActive) {
                menuActive = false;

                $("#chatbanner").css("opacity", 0);
                setTimeout('$("#chatbanner").removeClass("bouncyEntranceFromTop")', 400);

            }

            else {
                menuActive = true;
                anchor = $(window).scrollTop();

                $("#chatbanner").css("opacity", 1);
                $("#chatbanner").addClass("bouncyEntranceFromTop");

            }

        }else{

            $("#chatbanner").addClass("bouncy");
            setTimeout('$("#chatbanner").removeClass("bouncy")', 1000);

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

    function updateBanner(chatId){

        var chatBannerDiv = $("#chatbanner");

        console.log("Updating banner");
        console.log(chatId);

        $.ajax({
            type: "GET",
            url: "modules/chatbanner.php?chat_id=<?php echo $chat_id ?>&chat_name=<?php echo $chat_name?>",
            success: function(result){
                chatBannerDiv.html(result);
            }
        });

    }

</script>

</body>
</html>