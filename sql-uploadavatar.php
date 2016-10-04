<?php

require_once("verification.php");

$con=mysqli_connect("localhost","root","admin","codechat");

$path = $_FILES['avatar']['name'];
$extension = pathinfo($path,PATHINFO_EXTENSION);
$type = $_FILES['avatar']['type'];

$target_dir = "avatars/";
$target_file = $target_dir . $activeuser_id . ".gif";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

 // Check file size
if ($_FILES["avatar"]["size"] > 20000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
	
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        echo "Your profile picture has been updated.";
		
		$item_id = $activeuser_id;
		$extension = "gif";
		include_once("backend-resample.php");
		
		header("Location: profile.php?u=$activeuser_id");
		die();
		
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>