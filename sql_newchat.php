<?php 

require_once "verification.php";

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$name = htmlentities(mysqli_real_escape_string($con, $_POST['name']));
$token = trim(htmlentities(mysqli_real_escape_string($con, $_POST['token'])));
$language = $_POST['language'];

$customTokenSpecified = ($token != '');

if (!$customTokenSpecified){
    // Generate random 7 characters long string as a token.
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $tokenLength = 7;
    $token = substr(str_shuffle( $chars ), 0, $tokenLength);
}

// If the token coincides with another in the database, generate another random token.
$occurrences = -1;

while($occurrences != 0){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $tokenLength = 7;
    $token = substr(str_shuffle($chars), 0, $tokenLength);

    $result = mysqli_query($con, "SELECT * FROM chats WHERE token = '$token'");

    $occurrences = mysqli_num_rows($result);
}

mysqli_query($con, "INSERT INTO chats(token, creator, name, language) VALUES ('$token', 1, '$name' , '$language')");
$newchat_id = mysqli_insert_id($con);

mysqli_query($con, "UPDATE user_stats SET chats = chats + 1 WHERE user_id = $activeuser_id");

mysqli_query($con, "INSERT INTO `relations`(`user`, `chat`) VALUES ($activeuser_id, $newchat_id)");

header('Location: main.php#'.$token);
die();

?>