<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

if( isset ($_COOKIE['sUser']) == false ) {
    header('Location: register.php');
}

if( isset ($_COOKIE['sUser']) ){

$pre_sUser = htmlspecialchars($_COOKIE['sUser']);
$sUser = mysqli_real_escape_string($con,$pre_sUser);


$session_id = $_COOKIE['session_id'];
$result = mysqli_query($con,"SELECT * FROM sessions WHERE id = $session_id");
$row = mysqli_fetch_array($result);

if (password_verify($row['user_id'], $_COOKIE['sUser'])
	and password_verify($row['rand'], $_COOKIE['sSession'])) {
		
	$user_id = $row['user_id'];
	
	$userresult = mysqli_query($con,"SELECT id, name, email FROM users WHERE id = $user_id");
	$row = mysqli_fetch_array($userresult);

		// DEPRECATED
		$activeuser_name = $row['name'];
		$activeuser_id = $row['id'];

		// NEW
		$activeUser = $row;

}
else{
	header('Location: logout.php');
	exit;
}}

?>