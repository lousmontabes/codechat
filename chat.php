<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Codechat</title>

<style>

::selection{
	text-shadow: none;
	background: #b3d4fc;
}

body{
	margin:0;	
}

code{
	font-family:droid sans mono;
}

.code{
	transition:0.5s;
	background:rgba(239,239,239,1.00);
	padding:3px 15px;	
	border:1px solid transparent;
	display:inline-block;
}

.code:hover{
	border:1px solid grey;	
}

#everything{
	font-family:open sans;
}

#header{
	height:50px;
	padding:17px;
	border-bottom:1px solid lightgrey;	
	font-size:36px;
	font-weight:300;
	color:grey;
	text-align:left;
	margin-bottom:10px;
	background:white;
}

#area{
	width:800px;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:250px;
}

.message{
	transition:0.3s;
	border: 1px solid transparent;
	padding: 10px;
	margin: 5px 0px;
	color:grey;	
}

.message:hover{
	border: 1px solid lightgrey;	
}

.message:hover .time{
	opacity:1;	
}

.sender{
	color:black;
	font-weight:600;
}

.time{
	transition:0.3s;
	opacity:0;
	position:relative;
	float:right;
	font-size:12px;
	bottom:10px;
}

#mine{
	text-align:right;	
}

#mine .time{
	float:left;	
}

#usercontrols{
	transition:0.2s;
	position:fixed;
	bottom:-150px;
	height:200px;
	width:100%;
	text-align:left;
	border-top:1px solid lightgrey;
	padding:20px;
	font-family:open sans;
	font-size:24px;
	color:grey;
}

#usercontrols:focus{
	bottom:0px;	
	outline:none;
	color:black;
}

.text{
	text-decoration:underline;	
}

#fullcode{
	position: fixed;
	right: 0;
	width: 490px;
	height: 100%;
	z-index: 100;
	background:rgba(239,239,239,1.00);
	font-size: 14px;

}

#fullcode::-webkit-scrollbar {
    width: 15px;
}
 
#fullcode::-webkit-scrollbar-track {

}
 
#fullcode::-webkit-scrollbar-thumb {
  background-color: grey;
  border:5px solid rgba(239,239,239,1.00);
  border-radius:15px;
}

#codearea{
	background:rgba(239,239,239,1.00);
	padding:20px;
}

</style>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<link href="css/prism.css" rel="stylesheet" />
<link href="css/codemirror.css" rel="stylesheet" />

<link rel="stylesheet" href="css/3024-day.css">

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>
<script src="scripts/codemirror.js"></script>
<script src="mode/python/python.js"></script>

<div id="fullcode"><!--<pre class='line-numbers'><code class='language-python'># -*- coding: utf-8 -*-</code></pre>-->

<textarea id="codearea"># WRITE YOUR CODE HERE</textarea>

</div>

<script>

var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("codearea"), {
  mode:  "python",
  theme: "3024-day"
});

myCodeMirror.setSize("100%", "100%");

</script>

<div id="everything">

<div id="header">codechat / Deja Vú</div>

<div id="area">

<div class="message">
<div class="sender">Albert Llobet Gibernau</div>
A veure, et passo el meu codi perque el puguis revisar:
<br><div class="time">11:03</div>
</div>

<div class="message" id="mine">
<div class="sender">Lluís Montabes</div>
Okay t'espero
<br><div class="time">11:03</div>
</div>

<div class="message">
<div class="sender">Albert Llobet Gibernau</div>

<div class="code">
<pre><code class='language-python'>import re
for test_string in ['555-1212', 'ILL-EGAL']:
    if re.match(r'^\d{3}-\d{4}$', test_string):
        print teststring, 'is a valid US local phone number'
    else:
        print test_string, 'rejected'</code></pre>
</div>
<br>
<div class="time">11:04</div>
</div>

<div class="message" id="mine">
<div class="sender">Lluís Montabes</div>
Fixa't que has cridat <i>textstring</i> en comptes de <i>text_string</i> a la 4a línia:<br><br>
<div class="code">
<pre>
<code class='language-python'>import re
for test_string in ['555-1212', 'ILL-EGAL']:
    if re.match(r'^\d{3}-\d{4}$', test_string):
        print <b>test_string</b>, 'is a valid US local phone number'
    else:
        print test_string, 'rejected'</code>
</pre>
</div>
<br>
<div class="time">11:04</div>
</div>

<div class="message">
<div class="sender">Albert Llobet Gibernau</div>
Hosti clar
<br><div class="time">11:03</div>
</div>

<div class="message">
<div class="sender">Xesco Díaz</div>
Sisi a mi m'havia passat algo semblant
<br><div class="time">11:03</div>
</div>

</div>

</div>

<textarea id="usercontrols" spellcheck="false" placeholder="Reply here..."></textarea>

</body>
</html>