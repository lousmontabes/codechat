<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Codechat</title>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<link href="css/generic.css" rel="stylesheet" />

<link href="css/prism.css" rel="stylesheet" />
<link href="css/codemirror.css" rel="stylesheet" />

<link rel="stylesheet" href="css/3024-day.css">

<style>

a{
	text-decoration:none;	
}

.chat{
	transition:0.2s;
	width:100%;
	margin-bottom:10px;
	font-size:36px;
	color:grey;
	cursor:pointer;
	font-weight:100;
}

.chat:hover{
	color:black;	
}

.language{
	font-size:14px;
	margin-left:1px;	
	font-weight:400;
}

.round{
	transition:0.2s;
	height:50px;
	width:50px;
	line-height:50px;
	text-align:center;
	font-size:36px;
	font-weight:100;
	color:grey;
	border:1px solid grey;
	border-radius:25px;
	display:inline-block;
	float:left;
	left:0;
	top:10px;
	margin-right:10px;
}

#newchat{
	margin-left:-60px;
    margin-bottom:200px;
}

#newchat:hover .round{
	color:black;
	border-color:black;	
}

#divisor{
	content:"";
	border-top:1px solid grey;
	margin:30px 0px;
	width:200px;
}

#header{
	background:white;
	border-bottom:1px solid lightgrey;
}

</style>

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<?php require_once "verification.php" ?>

<?php include "header.php" ?>

	<div id="everything" style="padding-top:0">

		<div id="searcharea">

			<form action="chatbox.php#h" method="get">
				<input type="text" class="bigsearchbar" placeholder="Enter chatroom token" spellcheck="false" name="token">
			</form>

		</div>

		<div id="area">

		<?php

		$result = mysqli_query($con, "SELECT * FROM relations WHERE user = $activeuser_id ORDER BY id DESC");

		if (mysqli_num_rows($result) == 0){
			echo "<h1 class='nochats'>
                <span style='color:orange'>alert</span>(<span class='codeline'>'You have no saved chats.'</span>)</h1>
                <br><br>
                You can create a new chat by clicking the button below or enter a token above to join an existing one.";
		}

		while ($relation = mysqli_fetch_array($result)){

			$relation_chat = $relation['chat'];

			$chatresult = mysqli_query($con, "SELECT * FROM chats WHERE id = $relation_chat");
			$chatrow = mysqli_fetch_array($chatresult);

			$chat_id = $chatrow['id'];
			$chat_token = $chatrow['token'];
			$chat_name = $chatrow['name'];
			$chat_language = $chatrow['language'];

		?>

		<a href="c/<?php echo $chat_token ?>">
			<div class="chat">
				<div class="title"><?php echo $chat_name ?></div>
				<div class="language"><?php echo $chat_language ?></div>
			</div>
		</a>

		<?php

		}

		?>

		<div id="divisor"></div>

		<div id="newchat">

			<div class="round">+</div>

			<a href="newchat.php">
				<div class="chat">
					<div class="title">New chat</div>
				</div>
			</a>

		</div>

		</div>

	</div>

</body>
</html>