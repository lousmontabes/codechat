<?php

$con=mysqli_connect("localhost","root","admin","codechat");

$chat_id = $_GET['id'];

$result = mysqli_query($con, "SELECT * FROM chats WHERE id = $chat_id");
$row = mysqli_fetch_array($result);

$chat_name = $row['name'];
$chat_code = $row['code'];
$chat_language = $row['language'];

echo "Chat: ".$chat_name;
echo "Language: ".$chat_language;

?>