<?php

require_once("verification.php");

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$name = htmlspecialchars(mysqli_real_escape_string($con,$_POST['name']));
$experience = htmlspecialchars(mysqli_real_escape_string($con,$_POST['experience']));
$pre_description = htmlspecialchars(mysqli_real_escape_string($con,$_POST['description']));

$turned = array( '&lt;pre&gt;', '&lt;/pre&gt;', '&lt;b&gt;', '&lt;/b&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;', '&lt;ul&gt;', '&lt;/ul&gt;', '&lt;li&gt;', '&lt;/li&gt;', '&lt;ol&gt;', '&lt;/ol&gt;' );
$turn_back = array( '<pre>', '</pre>', '<b>', '</b>', '<em>', '</em>', '<u>', '</u>', '<ul>', '</ul>', '<li>', '</li>', '<ol>', '</ol>' );

$description = str_replace( $turned, $turn_back, $pre_description );

mysqli_query($con,"UPDATE `profile_info` SET `experience`='$experience',`description`='$description' WHERE user_id = $activeuser_id");

include_once("sql_uploadavatar.php");

header("Location: profile.php?u=$activeuser_id");
die();

?>