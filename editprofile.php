<!doctype html>
<html>

<?php require_once "verification.php" ?>

<?php

?>

<head>
<meta charset="utf-8">
<title>Codechat / <?php echo $activeuser_name ?></title>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<link href="css/generic.css" rel="stylesheet" />

<link href="css/prism.css" rel="stylesheet" />

<style>

.bigavatar{
	width:150px;
	border-radius:100px;
	margin-right:50px;	
}

.bigname{
	font-size: 48px;
	font-family:open sans;
}

.experience{
	font-size: 18px;
	color: #a5b3d4;
	width:559px;
	font-family:open sans;
}

.editProfile{
	margin-bottom:20px;
	opacity:0.8;
	font-size:14px;
}

.editProfile a{
	text-decoration:none;
	color:#7c8bae;
	transition:0.3s;
	border-bottom:1px solid #7c8bae;
}

.editProfile a:hover{
	color:black;
	border-color:black;	
}
#info{
	height:150px;
	margin-bottom:30px;
}

#description{
	margin-bottom:30px;	
	width:100%;
	font-family:open sans;
	font-size:16px;
	resize:vertical;
}

#stats{
	display:block;
	float:none;
	border-radius:3px;
	background:#FDFDFD;
	border:2px solid #E1E1E1;
	border-bottom:2px solid #C4C4C4;
	padding:40px;
}

.language-rank{
	line-height:38px;
}

.messages-stat{
	margin-bottom:20px;
	color:#a5b3d4;
	font-size:46px;
}

#saveChanges{
	background:#99D490;
	padding-right:10px;
	color:#425A3C;
}

</style>

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<?php include "header.php" ?>

<?php

$result = mysqli_query($con,"SELECT * FROM profile_info WHERE user_id = $activeuser_id");
$row = mysqli_fetch_array($result);
	
	$profile_experience = $row['experience'];
	$profile_description = $row['description'];

?>

<?php if ($activeuser_id != $activeuser_id){ ?><br><br><?php } ?>

<div id="everything">

    <div id="area">
    
    	<form id="updateProfile" action="sql_updateprofile.php" method="post" enctype="multipart/form-data">
    
    	<?php if ($activeuser_id == $activeuser_id){ ?>
        
        <div class="editProfile">You are customizing your profile. <a href="profile.php?u=<?php echo $activeuser_id?>">Go back</a></div>
        
        <?php } ?>
    
        <div id="info">
        
        	<?php 
			if (file_exists("avatars/".$activeuser_id.".gif")) echo "<img src='avatars/".$activeuser_id .".gif' class='bigavatar' style='float:left'>";
			else echo "<img src='images/placeholder". $activeuser_id % 5 .".gif' class='bigavatar' style='float:left'>";
			?>
                       
            <div style="padding:20px 0px;">
            <div class="bigname"><?php echo $activeuser_name ?></div>
            <input type="text" name="experience" class="experience" value="<?php echo $profile_experience ?>" placeholder="Studies / Occupation / Etc" maxlength="55"></input>
			<br><br>Update profile picture: 
        	<input type="file" name="avatar">
            </div>
        
        </div>
        <br><br>
        
        <!--<textarea id="description"  name="description" placeholder="Describe yourself. Accepts HTML, so feel free to get creative!"><?php //echo $profile_description?></textarea>-->

	<input type="submit" value="Save changes" class="bigbutton">

	</form>

    </div>
    
</div>

</body>
</html>