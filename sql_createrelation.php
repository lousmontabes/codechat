<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/9/16
 * Time: 11:17
 */

require_once("verification.php");

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$chat_id = $_GET['chat_id'];
$alreadyExists = false;

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = $activeuser_id");

if (mysqli_num_rows($result) == 0){
    $alreadyExists = false;
}else{
    while ($relation = mysqli_fetch_array($result) && !$alreadyExists) {

        $relation_chat = $relation['chat'];
        $found = ($chat_id == $relation_chat);

    }
}

if(!$alreadyExists){

    $result = mysqli_query($con, "INSERT INTO `relations`(`user`, `chat`) VALUES ($activeuser_id, $chat_id)");

    if ($result){
        echo true;
    }
    else{
        echo false;
    }

}

?>