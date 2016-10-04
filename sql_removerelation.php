<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 30/9/16
 * Time: 11:17
 */

require_once("verification.php");
$con = mysqli_connect("localhost","root","root","codechat");

$chat_id = $_GET['chat_id'];
$result = mysqli_query($con, "DELETE FROM `relations` WHERE (user = $activeuser_id) AND (chat = $chat_id) ");

if ($result){
    echo true;
}
else{
    echo false;
}

?>