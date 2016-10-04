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

h1{
	font-family:open sans;
	margin:0;
	padding:0;
	font-weight:100;
	font-size:36px;	
}

#newchatform{
	font-size:28px;
	font-weight:100;
	color:grey;	
	margin-top:20px;
}

#newchatform input, #newchatform select{
	transition:0.2s;
	font-family:open sans;
	margin-bottom:10px;
}

#newchatform select{
	border-bottom:none;	
	margin-left:-4px;
}

.noborder{
	border:none;
	font-size:28px;
	font-weight:300;
	color:grey;	
}

#newchatform input:hover, #newchatform select:hover,
#newchatform input:focus, #newchatform select:focus{
	color:black;
}

#newchatform input:focus, #newchatform select{
	outline:none;
}

.bigbutton{
	background:transparent;
	border:1px solid lightgrey;
	border-bottom:1px solid lightgrey;
	padding:5px 30px;
	border-radius:30px;
	display:block;
	font-family:open sans;
	font-weight:100;
	font-size:26px;
	color:grey;
	margin-top:10px;
}

.bigbutton:hover{
	border-color:grey;	
}

.warning{
	transition:0.2s;
	background:#E9797B;
	display:inline-block;
	padding:5px 10px;
	border-radius:6px;
	font-size:16px;
	font-weight:600;
	color:white;
	opacity:0;
	overflow:hidden;
	white-space:nowrap;
	width:0px;
}

.warning b{
	background:white;
	color:#E9797B;
	display:inline-block;
	border-radius:8px;
	text-align:center;
	line-height:16px;
	width:16px;
	height:16px;
}

</style>

</head>

<body>

<?php

if((isset($_GET['id']) == false) or ($_GET['id'] == "")) {
    header('Location: home.php');
}else{
$chat_id = $_GET['id'];
}

?>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<?php require_once "verification.php" ?>
<?php include "header.php" ?>

<div id="everything">

<div id="area">

<h1>Entering group chat</h1>

<form id="newchatform" action="chatbox.php" method="get">

<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<input id="nameinput" type="text" spellcheck="false" class="noborder" placeholder="Enter your name" name="name"><br>

<input type="submit" class="bigbutton" value="Done">

</form>

<div id="namewarning" class="warning"><b>!</b> Please enter your name</div>

</div>

</div>

<script>

 $("#newchatform").submit(function (e) { 
	 if ($("#nameinput").val() == ""){
		 e.preventDefault();
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","210px");
	 }
 });
 
</script>

</body>
</html>