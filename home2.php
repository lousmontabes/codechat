<?php require_once "verification.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codechat v2</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>

    <style>

        #leftcolumn{
            font-family:open sans;
        }

        body{
            margin:0;
        }

        h2{
            font-weight: normal;
            font-size:18px;
            color:gray;
        }

        #topbanner{
            width:100%;
            text-align: center;
            height:60px;
            line-height: 68px;
            font-size: 18px;
            background:#2e6da4;
            color:white;
            position:fixed;
            font-family: geometos;
            z-index:10;
        }

        #leftcolumn{
            min-height:100vh;
            width:25vw;
            background: #ebebeb;
            float:left;
            left:0;
            display:block;
            position:fixed;
            height:100%;
            overflow-y: scroll;
        }

        #leftcolumn::-webkit-scrollbar {
            display: none;
        }

        #centercolumn{
            min-height:100vh;
            width:75vw;
            margin-left:25vw;
            background:white;
            float:left;
            display:block;
        }

        .centered{
            margin-left: auto;
            margin-right: auto;
        }

        #leftcolumn .centered{
            width:20vw;
        }

        #userbar a{
            cursor:pointer;
            transition:0.5s;
            color:#2e6da4;
            opacity:0.5;
        }

        #createbutton{
            text-align:right;
        }

        #createbutton a{
            color:#2e6da4;
        }

        #leftcolumn a:hover{
            opacity:0.5;
        }

        nav a{
            font-size:20px;
        }

        #tokenbar{
            display:block;
            width:26rem;
            margin:1.5rem 1rem 0.25rem;
            border:0;
            font-size:1.2rem;
            padding:.75rem 1rem;
            border-radius:3px;
            box-shadow:0 1px 2px #aaa;
            transition:.5s, margin-bottom .15s;
        }

        #userbar{
            margin-top:90px;
        }

        #userbar i{
            font-weight:100;
            color:grey;
        }

        .card {
            padding:1.5rem;
            box-shadow:0 1px 2px #aaa;
            background:white;
            margin:0 1rem 1rem;
            border-radius:3px;
            user-select:none;
            animation:fly-in-from-left .5s 1s ease both;
            transform-origin:top left;
        }

        .tag{
            display:inline-block;
            background:lightgray;
            border-radius:3px;
            padding:3px 6px;
            font-size:10px;
            font-weight: 700;
            color:gray;
            margin:0px 4px;
        }

        .row{
            position:relative;
            white-space: nowrap;
            overflow:hidden;
        }

        .row:after {
            content:"";
            position:absolute;
            top:0;
            left:0;
            height:40px;
            width:100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 75%, rgba(255,255,255,1) 100%);
        }

        .stats{
            font-size: 14px;
            list-style: none;
            color:grey;
        }

        li.highlighted{
            color:#2e6da4;
        }

        .card.highlighted .chatTitle{
            color: #2e6da4;
        }

        .card.bold .chatTitle{
            font-weight: bold;
        }

        .sender{
            font-family:open sans;
        }

    </style>

    <link href="css/generic.css" rel="stylesheet" />
    <link href="css/prism.css" rel="stylesheet" />

</head>
<body>

<script src="scripts/jquery-1.7.1.min.js"></script>
<script src="scripts/prism.js"></script>

<div id="topbanner">codechat</div>

<!-- LEFT COLUMN: User bar, navigation, etc. -->
<div id="leftcolumn">

    <?php include "modules/userview.php" ?>

    <input type="text" class="centered" id="tokenbar" placeholder="Enter token"></input>
    <div class="centered" id="createbutton">or <a>create a new chat</a></div>

    <div class="centered">
        <h2>Saved chatrooms:</h2>
    </div>

    <div id="chatrooms">

        <?php include "modules/userchatlistview.php" ?>

        <div class="card">
            <div class="row">
                <b style="color:#2e6da4">Codechat devs 🔥</b>
                <div class="tag">CSS</div><div class="tag">HTML</div><div class="tag">JavaScript</div>
            </div>
            <div class="stats">
                <li class="highlighted">4 new messages</li>
                <li>78 messages</li>
                <li>4 users</li>
                <li>2 active right now</li>
            </div>
        </div>

        <div class="card">
            <div class="row">
                <b>Codechat backend  🖥</b>
                <div class="tag">PHP</div><div class="tag">Ruby</div>
            </div>
            <div class="stats">
                <li class="highlighted">1 new message</li>
                <li>34 messages</li>
                <li>4 users</li>
                <li>1 active right now</li>
            </div>
        </div>

        <div class="card">
            <div class="row">
                Levenshtein
                <div class="tag">Python</div>
            </div>
            <div class="stats">
                <li>5 messages</li>
                <li>2 users</li>
                <li>0 active right now</li>
            </div>

        </div>

        <div class="card">
            <div class="row">
                Algorísmica Avançada for Quim-senpai
                <div class="tag">Python</div>
            </div>
            <div class="stats">
                <li>8 messages</li>
                <li>4 users</li>
                <li>0 active right now</li>
            </div>
        </div>

    </div>

</div>

<!-- CENTER COLUMN: AJAX zone -->
<div id="centercolumn">

</div>

</body>
</html>