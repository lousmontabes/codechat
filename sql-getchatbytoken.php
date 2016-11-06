<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 6/11/16
 * Time: 2:45
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '{$_GET['token']}'");
$row = mysqli_fetch_array($result);

$chat = $row;
$i = 0;

if (mysqli_num_rows($result) > 0){
    include "modules/chatview.php";
}else{
    echo "<div class='card'>No chat matched this token</div>"
}

?>