<?php require_once "verification.php" ?>

<style>

h1{
	font-family:open sans;
	margin:0;
	padding:0;
	font-weight:100;
	font-size:36px;	
}

#newchatform{
    width:11.5em;
    height:300px;
	font-size:28px;
	font-weight:100;
	color:grey;
	overflow:hidden;
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

<div id="everything">

    <div id="area" style="opacity:0; overflow:hidden">

        <div class="inthemiddle" id="newchatform">

            <form id="newchatform" action="sql_newchat.php" method="post">

                <div id="namewarning" class="warning"><b>!</b> Please choose a name for the chat</div><br>
                <input id="nameinput" type="text" spellcheck="false" class="noborder" placeholder="Enter chat name" name="name">

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

                <input id="tokeninput" type="text" spellcheck="false" class="noborder" placeholder="Enter custom token (optional)" name="token">

                <input type="submit" class="bigbutton" value="Done">

            </form>

        </div>

    </div>

</div>

<script>

    $(document).ready(function(){

        // Change tab title
        document.title = 'Codechat / New chat';

        // Focus on the name input as soon as the page has loaded.
        $("#nameinput").focus();

        // Fade-in effect
        setTimeout('$("#area").css("opacity",1)',20);

    });

     $("#newchatform").submit(function (e) {
         if ($("#nameinput").val() === ""){
             e.preventDefault();
             $("#namewarning").css("opacity","1").css("width","290px");
         }
     });
 
</script>