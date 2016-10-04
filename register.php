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

#splash{
	width:1200px;
	margin-left:auto;
	margin-right:auto;
	background:url(images/clouds-airplane1.jpg);
	height:489px;
	margin-top:-80px;
	line-height:409px;
	text-align:center;
	color:white;
	font-size:16px;
	text-shadow: 1px 1px #893e77;
	font-family:droid sans mono;
}

#splash h1{
	font-family:open sans;
	font-size:70px;
	text-shadow: 0px 2px #893e77;
	-webkit-text-stroke-width: 1px;
   -webkit-text-stroke-color: #893e77;
   font-weight:400;
   margin-bottom:-350px;
}

.greenglow{
	text-shadow: 1px 2px #54A7FF;
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

if( isset ($_COOKIE['sUser']) ) {
    header('Location: home.php');
}

?>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<div id="header">codechat</div>

<div id="everything">

<div id="splash">
<h1>Share code in real time</h1>
print (<span class="greenglow">"Collaborate, share & review without missing a thing. As simple as chatting."</span>)
</div>

<div id="area">

<h1>Register</h1>

<form id="newchatform" action="sql_register.php" method="post">

<input type="text" id="nameinput" spellcheck="false" class="noborder" placeholder="Name" name="name"><div id="namewarning" class="warning"><b>!</b> Please enter your name</div><br>
<input type="email" id="emailinput" spellcheck="false" class="noborder" placeholder="Email Address" name="email"><div id="emailwarning" class="warning"><b>!</b> Please enter a valid email address</div><br>
<input type="password" id="passwordinput" spellcheck="false" class="noborder" placeholder="Password" name="password"><div id="passwordwarning" class="warning"><b>!</b> Please enter a password</div>

<input type="submit" class="bigbutton" value="Done">

</form>

<script>

 $("#newchatform").submit(function (e) { 
 
 	 var validName = "FALSE";
 	 var validEmail = "FALSE";
	 var validPassword = "FALSE";
 
	 if ($("#nameinput").val() == ""){
		 validName = "FALSE";
		 $("#namewarning").html("<b>!</b> Please enter your name");
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","210px");
	 }else if ($("#nameinput").val().length == 1){
		 validName = "FALSE";
		 $("#namewarning").html("<b>!</b> Your name must be longer than 1 character");
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","363px");
	 }else if ($("#nameinput").val().length > 1){
		 validName = "TRUE";
		 $("#namewarning").css("opacity","0");
		 $("#namewarning").css("width","0px");
	 }
	 
	 if ($("#emailinput").val() == ""){
		 validEmail = "FALSE";
		 $("#emailwarning").html("<b>!</b> Please enter a valid email address");
		 $("#emailwarning").css("opacity","1");
		 $("#emailwarning").css("width","290px");
	 }else{
		 validEmail = "TRUE";
		 $("#emailwarning").css("opacity","0");
		 $("#emailwarning").css("width","0px");
	 }
	 
	 if ($("#passwordinput").val() == ""){
		 validPassword = "FALSE";
		 $("#passwordwarning").html("<b>!</b> Please enter a password");
		 $("#passwordwarning").css("opacity","1");
		 $("#passwordwarning").css("width","216px");
	 }else if ($("#passwordinput").val().length < 8){
		 validPassword = "FALSE";
		 $("#passwordwarning").html("<b>!</b> Your password must be at least 8 characters long");
		 $("#passwordwarning").css("opacity","1");
		 $("#passwordwarning").css("width","410px");
	 }else if ($("#passwordinput").val().length >= 8){
		 validPassword = "TRUE";
		 $("#passwordwarning").css("opacity","0");
		 $("#passwordwarning").css("width","0px");
	 }
	 
	 emailValue = $("#emailinput").val();
 	 var emailData = {email:emailValue};
	 
	if (validName == "FALSE" || validEmail == "FALSE" || validPassword == "FALSE"){
		e.preventDefault(); 
	}
	 
 });
 
 	function getHashValue(key) {
	  var matches = location.hash.match(new RegExp(key+'([^&]*)'));
	  return matches ? matches[1] : null;
	}
 
	if(window.location.hash) {
	  
	  function clearWarning(){
		 history.pushState("", document.title, window.location.pathname);
		 $("#emailwarning").css("opacity","0");
		 $("#emailwarning").css("width","0px");;  
	  }
	  
	  var hash = getHashValue('#');
	  
	  if (hash == "alreadyexists"){
		  $("#emailwarning").html("<b>!</b> This email address is already in use");
		  $("#emailwarning").css("opacity","1");
		  $("#emailwarning").css("width","290px");
	  }
	  
	  $("#emailinput").keyup(clearWarning);
	  
	}
 
</script>

<div id="divisor"></div>

<div id="newchat">
<a href="login.php">
<div class="chat">
<div class="title">Log in</div>
</div>
</a>

</div>

</div>

</div>

<div id="disclaimer" class="footer">Codechat (c). By Lluís Montabes.</div>

</body>
</html>