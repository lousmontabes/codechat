<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 9/11/16
 * Time: 11:20
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

$user_ip = $_SERVER['REMOTE_ADDR'];

mysqli_query($con,"INSERT INTO visits(page, ip) VALUES ('register.php', '{$user_ip}')");

?>