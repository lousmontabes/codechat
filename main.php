<?php require_once "verification.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codechat</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>
    <link href="css/prism.css" rel="stylesheet" />

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
            transition:0.5s;
            width:25vw;
            text-align: center;
            height:60px;
            line-height: 68px;
            font-size: 18px;
            color:#2e6da4;
            background:transparent;
            position:fixed;
            font-family: geometos;
            z-index:10;
        }

        #leftcolumn{
            min-height:100vh;
            width:25vw;
            background: rgba(239, 239, 239, 1.00); /* #ebebeb */
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
            font-family: open sans;
        }

        #tokenbar:focus{
            outline:none;
            box-shadow:0 1px 2px #929292;
        }

        #userbar{
            margin-top:70px;
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
            cursor:pointer;
        }

        .card:hover .chatTitle{
            color: #2e6da4;
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

        .chatTitle{
            transition:0.1s;
        }

        .stats{
            font-size: 14px;
            list-style: none;
            color:grey;
        }

        li.highlighted{
            color:#2e6da4;
        }

        .card.highlighted{
            cursor:default;
        }

        .card.highlighted .chatTitle{
            color: #2e6da4;
        }

        .card.bold .chatTitle{
            font-weight: bold;
        }

        #newChatCard{
            cursor: pointer;
            transition:0.2s;
            background:transparent;
            box-shadow: none;
            border: 1px solid lightgray;
            text-align: center;
            font-size:22px;
            font-weight: 100;
            color:grey;
        }

        #newChatCard:hover, #newChatCard.highlighted{
            border-color: rgba(46, 109, 164, 0.5);
            color: #2e6da4;
        }

        #newChatCard.highlighted{
            background: rgba(46, 109, 164, 0.1);
        }

        .sender{
            font-family:open sans;
        }

        #loadingPage {
            background: url(images/spinner.gif);
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
            width: 75vw;
            opacity: 0.8;
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

        <?php include "modules/tokensearchview.php" ?>
        <div class="centered" id="createbutton">or <a>create a new chat</a></div>

        <div class="centered">
            <h2>Saved chatrooms:</h2>
        </div>

        <div id="chatrooms">
            <?php include "modules/userchatlistview.php" ?>
            <div class="card" id="newChatCard" onclick="newChatClicked()">+ New chat</div>
        </div>

    </div>

    <!-- CENTER COLUMN: AJAX zone -->
    <div id="centercolumn">
        <?php echo $_GET['token'] ?>
    </div>

    <script type="text/javascript">

        /*var currentChat = 0;
        var messageCount = {};
        var missedMessages = {};
        var saved = {};*/

        function updateAjax(source){

            var ajaxZone = $("#centercolumn");
            ajaxZone.html("<div id='loadingPage'></div>");

            $.ajax({
                type: "GET",
                url: source,
                success: function(result){
                    ajaxZone.html(result);
                }
            });

        }

        function showChat(token){
            currentChat = 0;
            updateURL(token);
            updateAjax("ajaxchatbox.php?token=" + token);
        }

        function highlightCard(i){
            $(".card.highlighted").removeClass("highlighted"); // Remove highlight from previous highlighted card.
            $("#card" + i).addClass("highlighted"); // Highlight new card.
        }

        function cardClicked(i, id){
            highlightCard(i);
            showChat(id);
        }

        function newChatClicked(){
            $(".card.highlighted").removeClass("highlighted"); // Remove highlight from previous highlighted card.
            $("#newChatCard").addClass("highlighted"); // Highlight new card.
            updateAjax("ajaxnewchat.php");
        }

        $("#leftcolumn").scroll(function(event) {

            if ($("#leftcolumn").scrollTop() <= 0) {

                $("#topbanner").css("background", "transparent");
                $("#topbanner").css("color", "#2e6da4");

            } else {

                $("#topbanner").css("background", "#2e6da4");
                $("#topbanner").css("color", "white");

            }

        });

        // CHAT AND AJAX NAVIGATION FUNCTIONS

        function updateURL(token){
            window.location.hash = token;
        }

        function isValidToken(str){
            return /^\w+$/.test(str);
        }

        if(window.location.hash) {

            var hash = getHashValue('#');

            if (hash.length == 7 && isValidToken(hash)){

                // The hash contains a valid token.
                showChat(hash);

            }

            /*if (hash == "h" && !saved[currentChat]){

                // The user has accessed this chatroom entering a token on the homescreen.
                // The chatroom hasn't been saved to the homescreen.

                displayMessage("Save this chatroom to access it from the home screen anytime.");
                window.location.hash = "";

            }*/

        }

        // GENERIC FUNCTIONS - SHOULD BE IN SEPERATE LIBRARY

        function getHashValue(key) {
            var matches = location.hash.match(new RegExp(key+'([^&]*)'));
            return matches ? matches[1] : null;
        }

    </script>

</body>
</html>