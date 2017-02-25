<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 25/2/17
 * Time: 11:30
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$userId = $_GET['user_id'];

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = $userId ORDER BY id DESC");

if (mysqli_num_rows($result) == 0){
    $data = [];
}

$i = 0;
while ($relation = mysqli_fetch_array($result)) {

    $relation_chat = $relation['chat'];

    $chatresult = mysqli_query($con, "SELECT * FROM chats WHERE id = $relation_chat");
    $chatrow = mysqli_fetch_array($chatresult);

    $data[$i] = $chatrow;

    $i++;
}

header('Content-Type: application/json');
echo json_encode($data);

?>