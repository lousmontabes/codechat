<?php require_once "verification.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codechat</title>

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
            min-width:300px;
            width:25vw;
            max-width:350px;
            text-align: center;
            height:60px;
            line-height: 68px;
            font-size: 18px;
            color:white;
            position:fixed;
            font-family: geometos;
            z-index:22;
            transition: color 0.4s;
            text-rendering: geometricPrecision;
        }

        #topbackground{
            background:#2e6da4;
            width: inherit;
            min-width: inherit;
            max-width: inherit;
            height:60px;
            z-index:21;
            position:fixed;
        }

        #leftcolumn{
            min-height:100vh;
            min-width:300px;
            width:25vw;
            max-width:350px;
            background: rgba(239, 239, 239, 1.00); /* #ebebeb */
            float:left;
            left:0;
            display:block;
            position:fixed;
            height:100%;
            overflow-y: scroll;
            z-index:20;
            transition: left 0.4s;
        }

        #leftcolumn::-webkit-scrollbar {
            display: none;
        }

        #centercolumn{
            min-height: 100vh;
            background: white;
            width: 75vw;
            max-width: 1000px;
            margin-left: 25vw;
            display: block;
        }

        .centered{
            margin-left: auto;
            margin-right: auto;
        }

        #leftcolumn .centered{
            width:80%;
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

        #tokenArea{
            margin: 1rem 1rem 0;
        }

        #tokenbar{
            box-sizing: border-box;
            width: 100%;
            border: 0;
            font-size: 1.2rem;
            padding: 0.75rem 1.25rem;
            border-radius: 3px;
            box-shadow: 0 1px 2px #1a3d5c;
            transition:0.2s;
            font-family: open sans;
        }

        #tokenbar:focus{
            outline:none;
            box-shadow:0 2px 3px #12293e;
        }

        #tokenArea .card{
            color:black;
            box-shadow:0 1px 2px #1a3d5c;
            margin:0;
        }

        #userbar{
            margin-top:70px;
        }

        #userbar i{
            font-weight:100;
            color:grey;
        }

        .card {
            transition:0.2s;
            /*box-shadow:0 1px 2px #aaa;*/
            /*background:white;*/
            user-select:none;
            animation:fly-in-from-left .5s 1s ease both;
            cursor:pointer;
            display:flex;
        }

        .leftside{
            transition:0.2s;
        }

        .card:hover{
            background:rgba(46,109,164,0.1);
        }

        .card:active .leftside{
            transform:scale(0.9);
        }

        .card:hover .chatTitle{
            color: #2e6da4;
        }

        .languageTag{
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
            /*background: linear-gradient(to right, rgba(255,255,255,0) 75%, rgba(255,255,255,1) 100%);*/
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

        #newChatCard {
            display: block;
            cursor: pointer;
            transition: 0.2s;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#efefef+0,efefef+100&0+0,1+25 */
            background: -moz-linear-gradient(top, rgba(239,239,239,0) 0%, rgba(239,239,239,1) 25%, rgba(239,239,239,1) 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(239,239,239,0) 0%,rgba(239,239,239,1) 25%,rgba(239,239,239,1) 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(239,239,239,0) 0%,rgba(239,239,239,1) 25%,rgba(239,239,239,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00efefef', endColorstr='#efefef',GradientType=0 ); /* IE6-9 */
            box-shadow: none;
            text-align: center;
            font-size: 22px;
            font-weight: 100;
            color: grey;
            padding: 1.5em 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            min-width: 300px;
            width: 25vw;
            max-width: 350px;
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

        #footer{
            width:100%;
            text-align:center;
            font-size:12px;
            padding-bottom: 1rem;
            display:none;
        }

        #footer a{
            transition:0.1s;
            color: #2e6da4;
            font-weight: bold;
            text-decoration: none;
        }

        #footer img{
            height:0.8em;
            margin-bottom:-0.1em;
        }

        #emptystatecontainer{
            height:90vh;
            display:flex;
            justify-content: center;
        }

        #emptystate{
            align-self: center;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #2e6da4;
            width:590px;
        }

        #emptystate h2{
            color: #2e6da4;
        }

        #chatListView{
            transition:0.1s;
            padding-bottom: 100px;
        }

        #toggleColumnButton{
            display:inline-block;
            position: fixed;
            left: 1.5em;
            cursor: pointer;
            transition: transform 0.1s;
        }

        #toggleColumnButton:active{
            transform: scale(0.8);
        }

    </style>

    <link href="css/generic.css" rel="stylesheet" />
    <link href="css/prism.css" rel="stylesheet" />

</head>
<body>

    <script src="scripts/jquery-1.7.1.min.js"></script>
    <script src="scripts/prism.js"></script>

    <div id="topbanner"><div id="toggleColumnButton" onclick="toggleLeftColumn()">☰</div>codechat</div>

    <!-- LEFT COLUMN: User bar, navigation, etc. -->
    <div id="leftcolumn">

        <div id="topbackground"></div>

        <div id="columnheader">
            <?php include "modules/userview.php" ?>
            <?php include "modules/tokensearchview.php" ?>
        </div>

        <div id="chatrooms">
            <div id="chatListView">
                <?php include "modules/userchatlistview.php" ?>
            </div>
            <div class="card" id="newChatCard" onclick="newChatClicked()">Join or create chat</div>
        </div>

        <div id="footer">
            <a>
                Send your <img src="images/pixelheart.svg">
            </a>
        </div>

    </div>

    <!-- CENTER COLUMN: AJAX zone -->
    <div id="centercolumn">

        <!-- Empty state screen -->

        <div id="emptystatecontainer">
            <div id="emptystate">
                <h1>The more the merrier</h1>
                <p>Start collaborating in your projects now!</p>
                <h2>How does it work?</h2>
                <ol>
                    <li>Create a chatroom. Choose the name and language.</li>
                    <li>Share the token with whoever you want to have access to your chatroom.</li>
                    <li>When you receive a token, enter it onto the field at the top of the page and get started.</li>
                </ol>
                <p>That's it!</p>
                <p>Happy collaborating!</p>
            </div>
        </div>

    </div>

    <script type="text/javascript">

        /*var currentChat = 0;
        var messageCount = {};
        var missedMessages = {};
        var saved = {};*/

        var leftColumnVisible = true;
        var ajaxZone = $("#centercolumn");
        var chatListView = $("#chatListView");

        function updateAjax(source){

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

        function cardClicked(i, token){
            highlightCard(i);
            showChat(token);
        }

        function newChatClicked(){
            $(".card.highlighted").removeClass("highlighted"); // Remove highlight from previous highlighted card.
            $("#newChatCard").addClass("highlighted"); // Highlight new card.
            updateAjax("ajaxnewchat.php");
        }

        $("#leftcolumn").scroll(function(event) {

            if ($("#leftcolumn").scrollTop() <= 0) {

                //$("#topbanner").css("background", "transparent");
                //$("#topbanner").css("color", "#2e6da4");

            } else {

                //$("#topbanner").css("background", "#2e6da4");
                //$("#topbanner").css("color", "white");

            }

        });

        function saveChat(cardId, chatId){

            $.ajax({
                type: "GET",
                url: "sql_createrelation.php?chat_id=" + chatId,
                success: function(result){
                    console.log("Chat saved successfully");
                    updateChatrooms();
                    updateBanner(chatId);
                }
            });

        }

        function removeChat(cardId, chatId){

            fadeCard(cardId);

            $.ajax({
                type: "GET",
                url: "sql_removerelation.php?chat_id=" + chatId,
                success: function(result){
                    console.log("Chat removed successfully");
                    fadeoutCard(cardId);
                    updateChatrooms();
                    updateBanner(chatId);
                }
            });

        }

        function updateChatrooms(){

            chatListView.css("opacity", 0);

            $.ajax({
                type: "GET",
                url: "getuserchatlist.php?user_id=<?php echo $activeUser['id'] ?>",
                success: function(result){
                    chatListView.html(result);
                    chatListView.css("opacity", 1);
                }
            });

        }

        // CHAT AND AJAX NAVIGATION FUNCTIONS

        function updateURL(token){
            window.location.hash = token;
        }

        function isValidToken(str){
            return /^\w+$/.test(str);
        }

        if(window.location.hash) {

            var hash = getHashValue('#');

            if (isValidToken(hash)){

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

        // GENERIC FUNCTIONS - SHOULD BE IN SEPARATE LIBRARY

        function getHashValue(key) {
            var matches = location.hash.match(new RegExp(key + '([^&]*)'));
            return matches ? matches[1] : null;
        }

        // DESIGN AND ANIMATION FUNCTIONS

        // Makes a card fade to 50% opacity
        function fadeCard(cardId){
            var card = $("#card" + cardId);
            card.css("opacity", 0.5);
        }

        // Makes a card disappear
        function fadeoutCard(cardId){
            var card = $("#card" + cardId);
            card.css("opacity", 0);
        }

        // Toggles left column
        function toggleLeftColumn(){

            var leftColumn = $("#leftcolumn");
            var topBanner = $("#topbanner");
            var centerColumn = $("#centercolumn");

            if(leftColumnVisible){
                leftColumn.css("left", "-100%");
                topBanner.css("color", "#2e6da4");
                centerColumn.css("margin-left", "auto");
                centerColumn.css("margin-right", "auto");
            }else{
                leftColumn.css("left", "0");
                topBanner.css("color", "white");
                centerColumn.css("margin-left", "25vw");
            }

            leftColumnVisible = !leftColumnVisible;

        }

        // topBackground fade effect
        $("#leftcolumn").scroll(function(){

            var topBackground = $("#topbackground");
            var scrolled = $("#leftcolumn").scrollTop();
            var max = 60;
            var opacity = 1;

            if (scrolled <= 0) opacity = 1;
            else if (scrolled > 0 && scrolled < max){
                opacity = -(scrolled / max) + 1;
                topBackground.css("background", "transparent");
            }
            else {
                opacity = 0;
                topBackground.css("background", "#2e6da4");
            }

            $("#userbar").css("opacity", opacity);

        });

    </script>

</body>
</html>
