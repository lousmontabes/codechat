<?php

/*
 * This script handles the process of updating
 * the main code in a chat.
 *
 * Author: Lluís Montabes
 * Date: 16/12/2016 13:00
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$chat_id = $_GET['chat_id'];
//$user_id = $_POST['user_id'];
$code = mysqli_real_escape_string($con, $_GET['code']);

echo $chat_id;
echo $code;

$code_lines = substr_count( $_GET['code'], "\n" ) + 1;

mysqli_query($con, "UPDATE chats SET code = '{$code}' WHERE id = {$chat_id}");

?>