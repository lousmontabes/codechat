<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic
&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

<link href="css/generic.css" rel="stylesheet" />

<link href="css/prism.css" rel="stylesheet" />
<link href="css/codemirror.css" rel="stylesheet" />

<link rel="stylesheet" href="css/3024-day.css">

<style>

#parallel code{
	display:inline-block;
	color: black;
	font-family: droid sans mono;
	direction: ltr;
	text-align: left;
	white-space: pre;
	word-spacing: normal;
	word-break: normal;
	line-height: 12px;
	padding:17px;

	-moz-tab-size: 4;
	-o-tab-size: 4;
	tab-size: 4;

	-webkit-hyphens: none;
	-moz-hyphens: none;
	-ms-hyphens: none;
	hyphens: none;
	font-size:16px;
}

</style>

</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<script src="scripts/prism.js"></script>

<div class="message" style="display:inline-block;">

<div class="code">
<pre class="line-numbers"><code class="language-python">def acro(frase):<br />
<br />
    words = frase.split(" ")<br />
    nParaules = len(words)<br />
    acronim = ""    <br />
    <br />
    i = 0    <br />
    <br />
    for i in range(0, nParaules):<br />
<br />
        paraula = words[i]<br />
        inicial = paraula[0].upper()<br />
        i = i + 1<br />
        <br />
        acronim = acronim + inicial + "."<br />
        <br />
    return acronim<br />
<br />
print acro("Hola que tal")</code></pre>
</div>


<br>
<div class="time">2015-10-01 01:46:41</div>

</div>

<div class="message" id="parallel"  style="display:inline-block;">

<div class="code">
<pre class="line-numbers"><code>def acro(frase):<br />
<br />
    words = frase.split(" ")<br />
    nParaules = len(words)<br />
    acronim = ""    <br />
    <br />
    i = 0    <br />
    <br />
    for i in range(0, nParaules):<br />
<br />
        paraula = words[i]<br />
        inicial = paraula[0].upper()<br />
        i = i + 1<br />
        <br />
        acronim = acronim + inicial + "."<br />
        <br />
    return acronim<br />
<br />
print acro("Hola que tal")</code></pre>
</div>


<br>
<div class="time">2015-10-01 01:46:41</div>

</div>


</body>
</html>