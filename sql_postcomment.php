<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$chat_id = $_GET['chat_id'];
$user_id = $_GET['user_id'];
$message = mysqli_real_escape_string($con, $_GET['message']);

$code_lines = substr_count( $_GET['message'], "\n" ) + 1;

echo $message;

mysqli_query($con, "INSERT INTO messages(chat, author, content) VALUES ($chat_id, $user_id, '$message')");
mysqli_query($con, "UPDATE user_stats SET messages= messages + 1,codelines= codelines + $code_lines WHERE user_id = $user_id");

echo $message;
echo $chat_id;

?>