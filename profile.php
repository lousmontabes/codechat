<!doctype html>
<html>

<?php require_once "verification.php" ?>

<?php

$current_profile = $_GET['u'];

$profilerow = mysqli_query($con,"SELECT * FROM users WHERE id = $current_profile");
$row = mysqli_fetch_array($profilerow);
	
	$currentprofile_name = $row['name'];
	$currentprofile_id = $row['id'];

?>

<head>
<meta charset="utf-8">
<title>Codechat / <?php echo $currentprofile_name ?></title>

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
}

.experience{
	font-size: 18px;
	color: #a5b3d4;	
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
	padding:20px 0px;
	margin-bottom:30px;	
}

#stats{
	display:block;
	float:none;
	border-radius:3px;
}

.language-rank{
	line-height:38px;
}

.messages-stat{
	margin-bottom:20px;
	color:#a5b3d4;
	font-size:46px;
}

.percent{
	margin-left:20px;
	width:650px;
	height:35px;
}

.colorPercent{
	background:#a5b3d4;
	height:100%;
	content:"";
}

.language{
	font-size:26px;
	color:#494949;
}

tr{
	transition:0.2s;
	opacity:0.8;	
}

tr:hover{
	opacity:1;	
}

#table-images{
	margin:30px 0px;	
}

#table-images td{
	text-align:center;
	font-size:24px;
	line-height:30px;
	color:grey;
}

#table-images tr{
	opacity:1;	
}

.bignumber{
	display:block;
	font-size:36px;
	font-weight:600;
	color:black;
	font-fmaily:droid sans mono;
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

$current_profile = $_GET['u'];

$result = mysqli_query($con,"SELECT * FROM profile_info WHERE user_id = $currentprofile_id");
$row = mysqli_fetch_array($result);
	
	$profile_experience = $row['experience'];
	$profile_description = $row['description'];

?>

<?php if ($activeuser_id != $currentprofile_id){ ?><br><br><?php } ?>

<div id="everything">

    <div id="area">
    
    	<?php if ($activeuser_id == $currentprofile_id){ ?>
        
        <div class="editProfile">This is your profile. <a href="editprofile.php">Customize</a></div>
        
        <?php } ?>
    
        <div id="info">
        
        	<?php 
			if (file_exists("avatars/".$currentprofile_id.".gif")) echo "<img src='avatars/".$currentprofile_id .".gif' class='bigavatar' style='float:left'>";
			else echo "<img src='images/placeholder". $currentprofile_id % 5 .".gif' class='bigavatar' style='float:left'>";
			?>
            
            <div style="padding:20px 0px;">
            <div class="bigname"><?php echo $currentprofile_name ?></div>
            <div class="experience"><?php echo $profile_experience ?></div>
            </div>
        
        </div>
              
        <div id="stats">
            
            <?php
			
			$result = mysqli_query($con,"SELECT * FROM user_stats WHERE user_id = $currentprofile_id;");
			$row = mysqli_fetch_array($result);
			
				$message_count = $row['messages'];
				$codelines_count = $row['codelines'];
				$chats_count = $row['chats'];
					
			$languages = array();
			
            $languagesrow = mysqli_query($con,"SELECT chat FROM messages WHERE author = $currentprofile_id");
            while ($row = mysqli_fetch_array($languagesrow)){
               
			   	$chat_id = $row['chat'];
			   
				$result = mysqli_query($con,"SELECT language FROM chats WHERE id = $chat_id");
            	$row = mysqli_fetch_array($result);
				
					array_push($languages, $row['language']);
					
			}
			
			$count = array_count_values($languages); //Counts the values in the array, returns associatve array
			arsort($count); //Sort it from highest to lowest
			$keys = array_keys($count); //Split the array so we can find the most occuring key
			
			$total = array_sum($count);
			$percentages = array();

			foreach($count as $language => $hits) {
			   
			   $percent = round($hits / $total * 100, 1);
			   $percentages[$language] = $percent;
			   
			}
			
			?>
            
            <table style="width:100%;" id="table-images">
        
                <tr>
                    <td><img src="images/speechbubble.svg" width="70"></td>
                    <td><img src="images/codelines.svg" width="70"></td>
                    <td><img src="images/chatscreated.svg" width="70"></td>
                </tr>
                
                <tr>
                    <td><span class="bignumber"><?php echo $message_count?></span> messages</td>
                    <td><span class="bignumber"><?php echo $codelines_count?></span> lines of code</td>
                    <td><span class="bignumber"><?php echo $chats_count?></span> chats created</td>
                </tr>
                
            </table>
            
            <table style="width:100%">
            <?php
			
			foreach ($keys as $key){
			
			?>
            
              <tr style="width:25%">
                <td><span class="language"><?php echo $key?></span></td>
                <td>
                    <div class="percent">
                        <div class="colorPercent" style="width:<?php echo $percentages[$key]."%"?>">
                        	<?php //echo $percentages[$key]."%"?>
                        </div>
                    </div>
                </td> 
              </tr>
            
            <?php
			}
			
			?>
			</table>
                 
        </div>  

    </div>
    
</div>

</body>
</html>