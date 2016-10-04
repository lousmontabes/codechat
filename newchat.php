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
	font-size:36px;
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

option{
	font-size:16px;	
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

<div id="everything">

<div id="area">

<h1>Create a new chat</h1>

<form id="newchatform" action="sql_newchat.php" method="post">

<input id="nameinput" type="text" spellcheck="false" class="noborder" placeholder="Enter chat name" name="name"><div id="namewarning" class="warning"><b>!</b> Please choose a name for the chat</div><br>
<select class="noborder" name="language">
	<option value="Python">Python</option>
    <option value="Markup">Markup</option>
    <option value="clike">C-like</option>
    <option value="JavaScript">JavaScript</option>
    <option value="AppleScript">AppleScript</option>
    <option value="BASIC">BASIC</option>
    <option value="C">C</option>
    <option value="csharp">C#</option>
    <option value="cpp">C++</option>
    <option value="CSS">CSS</option>
    <option value="Fortran">Fortran</option>
    <option value="Git">Git</option>
    <option value="HTTP">HTTP</option>
    <option value="Java">Java</option>
    <option value="LaTeX">LaTeX</option>
    <option value="MATLAB">MATLAB</option>
    <option value="objectivec">Objective-C</option>
    <option value="Pascal">Pascal</option>
    <option value="Perl">Perl</option>
    <option value="PHP">PHP</option>
    <option value="Processing">Processing</option>
    <option value="Ruby">Ruby</option>
    <option value="SASS">SASS</option>
    <option value="SCSS">SCSS</option>
    <option value="Smalltalk">Smalltalk</option>
    <option value="SQL">SQL</option>
    <option value="Swift">Swift</option>
    <option value="VHDL">VHDL</option>
    <option value="vim">vim</option>
</select>

<input type="submit" class="bigbutton" value="Done">

</form>

</div>

</div>

<script>

 $("#newchatform").submit(function (e) { 
	 if ($("#nameinput").val() == ""){
		 e.preventDefault();
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","290px");
	 }
 });
 
</script>

</body>
</html>