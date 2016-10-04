<?php

$con = mysqli_connect("localhost","root","root","codechat");

$chat_id = $_GET['chat_id'];

$result = mysqli_query($con, "SELECT * FROM messages WHERE chat = $chat_id");
$messagecount = mysqli_num_rows($result);

echo $messagecount;

?>