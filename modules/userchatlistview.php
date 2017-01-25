<?php

require_once "/verification.php";

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = {$activeUser['id']} ORDER BY id DESC");

if (mysqli_num_rows($result) == 0){
    echo "<div class='nochats'>";
    echo "You have no saved chats. You can create a new chat pressing the button below or access an existing one entering the token above.";
    echo $activeUser['id'];
    echo "</div>";
}

$i = 0;
while ($relation = mysqli_fetch_array($result)) {

    $relation_chat = $relation['chat'];

    $chatresult = mysqli_query($con, "SELECT * FROM chats WHERE id = $relation_chat");
    $chatrow = mysqli_fetch_array($chatresult);

    // DEPRECATED
    $chat_id = $chatrow['id'];
    $chat_token = $chatrow['token'];
    $chat_name = $chatrow['name'];
    $chat_language = $chatrow['language'];

    // NEW
    $chat = $chatrow;
    $isSaved = True;

    include "chatview.php";

    $i++;
}

?>