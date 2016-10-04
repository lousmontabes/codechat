<?php

$con=mysqli_connect("localhost","root","admin","codechat");

$email = $_POST['email'];

$result = mysqli_query($con, "SELECT EXISTS(SELECT * FROM users WHERE email = '$email')");
$row = mysqli_fetch_array($result);

echo $row[0];

?>