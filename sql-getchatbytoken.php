<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 6/11/16
 * Time: 2:45
 */

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '{$_GET['token']}'");
while($row = mysqli_fetch_array($result)){
    print_r($row);
}

$chat = $row[0];
$i = 0;

include "modules/chatview.php"

?>