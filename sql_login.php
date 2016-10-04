<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
$password = htmlspecialchars(mysqli_real_escape_string($con, $_POST['password']));

$user_ip = $_SERVER['REMOTE_ADDR'];

$result = mysqli_query($con,"SELECT * FROM users WHERE email='$email'");

$row = mysqli_fetch_array($result);
$hash = $row['password'];
$user_id = $row['id'];

$rand = RAND(0,999999999);

if (password_verify($password, $hash)) {
	
	mysqli_query($con,"INSERT INTO sessions(user_id, rand, ip) VALUES ($user_id, $rand, '$user_ip')");
	$session_id = mysqli_insert_id($con);
	
	$user_hash = password_hash($user_id, PASSWORD_DEFAULT, array("cost" => 10));
	$rand_hash = password_hash($rand, PASSWORD_DEFAULT, array("cost" => 10));
	
    echo 'Password is valid! <br>';
	setcookie("session_id", $session_id, 0);
	setcookie("sUser", $user_hash, 0);
	setcookie("sSession", $rand_hash, 0);
	echo "welcome ".$_COOKIE['session_id'];

	header('Location: home.php');
	exit;
	
} else {
    echo 'Invalid password.';
	header('Location: login.php#wronglogin');
	exit;
}

exit;

?>