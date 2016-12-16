<?php

require_once "verification.php";

if(!isset($_GET['token']) or ($_GET['token'] == "")) {
    header('Location: /home.php');
}else{
    // IMPORTANT! The token is user input.
    // Escape token string before using it to access the database.
    $chat_token = mysqli_real_escape_string($con, $_GET['token']);
}

$result = mysqli_query($con, "SELECT * FROM chats WHERE token = '$chat_token'");
$row = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 0){
    // No chatroom matches the given token.
    header('Location: /home.php#wrongtoken');
}

//print_r($row);

$chat_id = $row['id'];
$chat_name = $row['name'];
$chat_code = $row['code'];
$chat_language = $row['language'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codechat</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>
    <link href="css/prism.css" rel="stylesheet" />

    <style>

        body{
            margin:0;
            background-size: cover;
            background-attachment: fixed;
            background: #141E30; /* fallback for old browsers */
            background: -webkit-linear-gradient(to top, #141E30 , #243B55); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to top, #141E30 , #243B55); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        #everything{
            position:absolute;
            left:0;
            top:0;
            width:100%;
            height:100%;
        }

        .page{
            font-family:"droid sans mono";
            font-size: 14px;
            background:white;
            width:60em;
            min-height:80vh;
            color:black;
            margin-left:auto;
            margin-right:auto;
            margin-top:50px;
            box-shadow: 2px 2px 3px rgba(0,0,0,0.5);
        }

        .page code{

        }

        #pageheader{
            width:100%;
            height:20px;
            background:#243B55;
            color:white;
            border-bottom:2px solid #141E30;
            text-align: center;
        }

        #overheader{
            position:fixed;
            /*width:100%;*/
            height:50px;
            padding:1em;
            font-family:open sans;
            color:white;
            font-size:22px;
        }

        #editbutton{
            transition:0.2s cubic-bezier(.05,.29,0,1.43);
            position: fixed;
            right: 15px;
            bottom: 15px;
            z-index: 100;
            font-size: 14px;
            padding: .8em 1.5em;
            border-radius: 2px;
            font-family: open sans;
            color: white;
            background: rgba(255, 255, 255, 0.4);
            opacity: 0.5;
            cursor:pointer;
        }

        #editbutton:active{
            transtion:0.2s ease-out;
            transform:scale(0.9);
        }

        #editbutton:hover{
            opacity:1;
        }

        #messageArea{
            position:fixed;
            z-index:10;
            padding:0 1.5em;
            left:0;
            bottom:0;
            width:100%;
            height:6em; /* 10vh (shade) */
            overflow:hidden;
            font-family:open sans;
            font-size:14px;
            color:white;
            background: dimgrey; /* fallback for old browsers */
            background: -webkit-linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0)); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to top, rgba(0,0,0,0.75), rgba(0,0,0,0)); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        #messages{
            width:18%;
            position:absolute;
            bottom:10px;
        }

        .message{
            margin-bottom:5px;
        }

        .message .avatar{

        }

        .message .author{
            font-weight:bold;
            display:inline;
        }

        .message .content{
            display:inline;
        }

        #footer{
            bottom:0;
            height:100px;
        }

        #pageheader td{
            transition:0.2s;
            padding:1em;
            cursor:pointer;
            height:100%;
        }

        #pageheader td:hover{
            background: #336287;
        }

        #codeinput{
            transition:0.2s;
            height: 100%;
            resize: none;
            border: none;
            font-family: "droid sans mono";
            font-size: 14px;
            background: white;
            width: 55em;
            min-height: 80vh;
            color: black;
            margin-left: auto;
            margin-right: auto;
            color: rgb(54, 54, 54);
        }

        #codeinput:focus{
            outline:none;
            color:black;
        }

    </style>

</head>
<body>

<!-- REQUIRED SCRIPTS -->
<script src="scripts/jquery-1.7.1.min.js"></script>
<script src="scripts/prism.js"></script>

<div id="everything">

    <div id="overheader">
        ← New UI
    </div>

    <div id="editbutton" onclick="toggleEditable()">
        Edit
    </div>

    <div class="page">

        <table id="pageheader">
            <tr>
                <td class="pagebutton"><div style="width:150px; margin:0 auto;">UI.JAVA</div></td>
                <td class="pagebutton"><div style="width:150px; margin:0 auto;">USER.JAVA</div></td>
                <td class="newpage" width="20px">+</td>
            </tr>
        </table>

            <!-- CODE IS SHOWN HERE -->
            <pre class="line-numbers"><code id="maincode" class="language-python"><?php echo htmlspecialchars($chat_code) ?></code></pre>

    </div>

    <div id="footer">

    </div>

    <div id="messageArea">
        <div id="messages">

            <?php

            $result = mysqli_query($con, "SELECT * FROM messages WHERE chat = $chat_id");
            $messagecount = mysqli_num_rows($result);
            $i = 0;
            $lastMessage = 0;

            while ($message = mysqli_fetch_array($result)) {

                $i++;
                $lastMessage = $i;

                $author_id = $message['author'];
                $content = $message['content'];
                $time = strtotime($message['time']);

                $month = date("F", $time);
                $week = date("D", $time);
                $day = date("d", $time);
                $hour = date("H", $time);
                $minute = date("i", $time);

                $result2 = mysqli_query($con, "SELECT name FROM users WHERE id = $author_id");
                $author = mysqli_fetch_array($result2);

                $author_name = $author['name'];

                include "modules/messageview.php";

            }

            ?>

        </div>
    </div>

</div>

</body>

<script type="text/javascript">

    // The base code is the main code, preformatted, without syntax highlighting.
    var baseCode = $("#maincode").html();
    Prism.highlightAll();

    // Applied globally on all textareas with the "autoExpand" class
    $(document)
        .one('focus.autoExpand', 'textarea.autoExpand', function(){
            var savedValue = this.value;
            this.value = '';
            this.baseScrollHeight = this.scrollHeight;
            this.value = savedValue;
        })
        .on('input.autoExpand', 'textarea.autoExpand', function(){
            var minRows = this.getAttribute('data-min-rows')|0, rows;
            this.rows = minRows;
            rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
            this.rows = minRows + rows;
        });

</script>

<script type="text/javascript">

    var editable = false;
    var mainCode = $("#maincode");
    var editButton = $("#editbutton");

    function toggleEditable(){

        console.log("Toggling editability");

        var currentCode = mainCode.html();

        if (!editable){
            // Make the code editable.

            var inputHtml = "<textarea id='codeinput' class='autoExpand' spellcheck='false'>" + baseCode + "</textarea>";

            editButton.html("Save");
            mainCode.html(inputHtml);
            mainCode.focus();

        }else{
            // Make the code uneditable.

            var newCode = $("#codeinput").val();

            console.log(newCode);

            editButton.html("Edit");

            if(updateCode(newCode)){
                // Code update to server was successful.
                mainCode.html(newCode);

                // Set the new code as the base code BEFORE highlighting it.
                baseCode = newCode;

                // Highlight the new code.
                Prism.highlightAll();
            }else{
                alert("There was an error updating the code");
            }

        }

        editable = !editable;

    }

    function updateCode(newCode) {

        var successful = false;

        $.ajax({
            type: "POST",
            url: "backend/updatecode.php",
            async: false,
            data: {
                'chat_id': <?php echo $chat_id ?>,
                'code': newCode
            },
            dataType: "html", //expect html to be returned
            success: function (response) {
                console.log("Update was successful.");
                successful = true;
            }

        });

        return successful;

    }

</script>

</html>