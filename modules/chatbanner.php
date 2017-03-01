<div class="bannerbox">

<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 16/2/17
 * Time: 10:47
 */

include "../verification.php";

if (!isset($chat_id)){
    $chat_id = $_GET['chat_id'];
}

if (!isset($chat_name)){
    $chat_name = $_GET['chat_name'];
}

echo $chat_name;

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = {$activeUser['id']} ORDER BY id DESC");

if (mysqli_num_rows($result) == 0){

    // User has no saved chats. Show save option.

    ?>
    <img src="../images/add.svg" width="20" onclick="saveChat(0, <?php echo $chat_id ?>)">
    <icon class="save"></icon>hi
    <?php
}else{

    // User does have saved chats. Look for the current one in their relations.

    $chatFound = false;
    while (($relation = mysqli_fetch_array($result)) && !$chatFound) {
        $chatFound = ($relation['chat'] == $chat_id);
    }

    if ($chatFound){

        // User has this chat in his saved chats. Show remove option.

        ?>
        <img src="../images/remove.svg" width="15" onclick="removeChat(0, <?php echo $chat_id ?>)">
        <?php
    }else{

        // User does not have this chat in his saved chats. Show add option.

        ?>
        <img src="../images/add.svg" width="20" onclick="saveChat(0, <?php echo $chat_id ?>)">
        <?php


    }

}

?>

</div>