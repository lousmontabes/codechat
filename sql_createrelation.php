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
$result = mysqli_query($con, "INSERT INTO `relations`(`user`, `chat`) VALUES ($activeuser_id, $chat_id)");

if ($result){
    echo true;
}
else{
    echo false;
}

?>