<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 16/2/17
 * Time: 10:47
 */

include "../verification.php";

echo $chat_name;
echo $chat['id'];

$result = mysqli_query($con, "SELECT * FROM relations WHERE user = {$activeUser['id']} ORDER BY id DESC");

if (mysqli_num_rows($result) == 0){
    ?>
    <img src="../images/add.svg" width="20" onclick="saveChat(<?php echo $i ?>, <?php $chat['id']?>)">
    <?php
}else{
    $chatFound = false;
    while ($relation = mysqli_fetch_array($result) && !$chatFound) {
        $chatFound = ($relation['chat']['id'] == $chat_id);
    }

    if ($chatFound){
        ?>
        <img src="../images/remove.svg" width="15" onclick="removeChat(<?php echo $i ?>, <?php echo $chat['id'] ?>)">
        <?php
    }

}

?>
