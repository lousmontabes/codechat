<div id="header"><img src="images/logo.svg" id="logo"><a href="home.php">codechat</a> <span id="userinfo"><b><a style="border:none; opacity:1;" href="profile.php?u=<?php echo $activeuser_id?>"><?php echo $activeuser_name ?></a></b> (<a href="logout.php">Log out</a>)

<a href="profile.php?u=<?php echo $activeuser_id?>">
<div class="smallavatar" style="margin:0; margin-top:-20px;">

<?php 
if (file_exists("avatars/".$activeuser_id.".gif")) echo "<img src='avatars/".$activeuser_id .".gif'>";
else echo "<img src='images/placeholder". $activeuser_id % 5 .".gif'>";
?>

</div>
</a>

</span></div>