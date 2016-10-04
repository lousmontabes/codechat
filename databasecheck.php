<?php
/**
 * Created by PhpStorm.
 * User: lluismontabes
 * Date: 4/10/16
 * Time: 12:18
 */

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$con = new mysqli($server, $username, $password, $db);

echo "This is the database check page.";

echo $url;

echo $server;
echo $username;
echo $password;
echo $db;

?>