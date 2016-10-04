<?php 

$con=mysqli_connect("localhost","root","admin","newsmont");

$session_id = $_COOKIE['session_id'];

mysqli_query($con,"UPDATE sessions SET logout_time = (CURRENT_TIMESTAMP) WHERE id = $session_id");

setcookie("session_id", "", time()-3600);
setcookie("sUser", "", time()-3600);

header('Location: register.php');
exit;

?>