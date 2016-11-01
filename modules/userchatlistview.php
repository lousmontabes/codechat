<?php

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = {$activeUser['id']} ORDER BY id DESC");

if (mysqli_num_rows($result) == 0){
    echo "<h1 class='nochats'>
                <span style='color:orange'>alert</span>(<span class='codeline'>'You have no saved chats.'</span>)</h1>
                <br><br>
                You can create a new chat by clicking the button below or enter a token above to join an existing one.";
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

    include "chatview.php";

    $i++;
}

?>