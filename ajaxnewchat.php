<?php require_once "verification.php" ?>

<style>

	h1{
		font-family:open sans;
		margin:0;
		padding:0;
		font-weight:100;
		font-size:36px;
	}

	.newchatform{
	    width:19em;
		font-size:28px;
		font-weight:100;
		color:grey;
		overflow:hidden;
		padding: 1.5em;
		margin-left: auto;
		margin-right: auto;
	}

	.newchatform input, .newchatform select{
		transition:0.2s;
		font-family:open sans;
		margin-bottom:10px;
	}

	.newchatform select{
		border-bottom:none;
		margin-left:-4px;
	}

	.noborder{
		border:none;
		font-size:28px;
		font-weight:300;
		color:grey;
	}

	.noborder:hover, .noborder:hover,
	.noborder:focus, .noborder:focus{
		color:black;
	}

	.noborder:focus, .noborder select{
		outline:none;
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

    #tokeninput{
        transition:0.2s;
        font-size:18px;
        opacity:0.5;
		width: 100%;
    }

    #tokeninput:hover{
        opacity: 1;
    }

	.bigbutton:hover{
		transform: scale(1.05);
		color: white;
	}

	.bigbutton:active {
		transform: scale(1.01);
	}

	.inthemiddle {
		height: 600px;
	}

	.input-container {
		display: inline-block;
    	box-shadow: 1px 1px 2px;
	}

	.input-section {
		display: inline-block;
		padding: .5em 1.5em;
		border: 1px solid lightgrey;
	}

	.newchatform .noborder {
		font-size: 20px;
	}

</style>

<div id="everything">

    <div id="area" style="opacity:0; overflow:hidden">

        <div class="inthemiddle newchatform">

            <form id="newchatform" class="newchatform" action="sql_newchat.php" method="post">

				<div class="info-text">Create a new chat:</div>

                <div id="namewarning" class="warning"><b>!</b> Please enter a name for the chat</div><br>

				<div class="input-container">

					<div class="input-section">

		                <input id="nameinput" type="text" spellcheck="false" class="noborder" placeholder="Enter chat name" name="name">

					</div><div class="input-section">

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

					</div>

				</div>

                <input id="tokeninput" type="text" spellcheck="false" class="noborder" placeholder="Enter custom token (optional)" name="token">

                <input type="submit" class="bigbutton" value="Create chat">

            </form>

			<form id="existingchatform" class="newchatform" method="post">

				<div class="info-text">...or join an existing chat:</div>

                <div id="existingtokenwarning" class="warning"><b>!</b> Please enter a token</div><br>

				<div class="input-container">
					<div class="input-section">
                		<input id="existingtokeninput" type="text" spellcheck="false" class="noborder" placeholder="Enter token" name="token">
					</div>
				</div>

                <input type="submit" class="bigbutton" value="Join existing chat">

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

    $("#nameinput").keyup(function(){
        $("#tokeninput").val(toUpperCamelCase($("#nameinput").val()));
    });

     $(".newchatform").submit(function (e) {
         if ($("#nameinput").val().replace(/\s+/g, '') === ""){
             e.preventDefault();
             $("#namewarning").css("opacity","1").css("width","290px");
         }
     });

	 $("#existingchatform").submit(function (e) {
         if ($("#existingtokeninput").val().replace(/\s+/g, '') === ""){
             e.preventDefault();
             $("#existingtokenwarning").css("opacity","1").css("width","290px");
         } else {
			 updateAjax("#" + $("#existingtokeninput").val());
			 e.preventDefault();
		 }
     });

    function toUpperCamelCase(str) {

        camelized = str.replace(/(?:^|\s)\w/g, function(match) {
            return match.toUpperCase();
        });

        return camelized.replace(/\s+/g, '');

    }

</script>
