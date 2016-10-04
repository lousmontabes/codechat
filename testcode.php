<?php 

$con=mysqli_connect("localhost","root","admin","codechat");

$message = $_GET['message'];
$chat_id = $_GET['chat_id'];

mysqli_query($con, "INSERT INTO messages(chat, author, content) VALUES ($chat_id, 1 , '$message')");

echo $message;
echo $chat_id;

?>