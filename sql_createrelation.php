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
$result = mysqli_query($con, "INSERT INTO `relations`(`user`, `chat`) VALUES ($activeuser_id, $chat_id)");

if ($result){
    echo true;
}
else{
    echo false;
}

?>