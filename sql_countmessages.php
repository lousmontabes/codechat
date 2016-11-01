<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$chat_id = $_GET['chat_id'];

$result = mysqli_query($con, "SELECT id FROM messages WHERE chat = $chat_id");
$messagecount = mysqli_num_rows($result);

echo $messagecount;

?>