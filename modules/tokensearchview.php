<div id="tokenArea">
    <input type="text"
           class="centered"
           id="tokenbar"
           placeholder="Enter token"
           oninput="updateResults(this.value)"
           onsubmit="submitToken(this.value)"
           spellcheck="false"
           autocomplete="off"
           maxlength="7"
    />
    <div id="tokenResult"></div>
</div>

<script>

    var tokenBar = $("#tokenbar");
    var tokenResult = $("#tokenResult");

    function updateResults(str){

        if(str.length == 7){

            tokenBar.css("color","lightgray");

            tokenResult.css("height", "90px");
            tokenResult.css("opacity", 1);
            tokenResult.addClass("bounceDown");

            $.ajax({
                type: "GET",
                url: "/sql-getchatbytoken.php?token=" + str,
                success: function(result){
                    tokenResult.html(result);
                }
            });

        }
        else{

            tokenBar.css("color","black");

            tokenResult.css("height", "0");
            tokenResult.css("opacity", 0);
            tokenResult.removeClass("bounceDown");
            tokenResult.html("");

        }

    }

    tokenBar.bind("enterKey",function(e){

        tokenBar.blur();
        cardClicked(-1, tokenBar.value);

    });

    tokenBar.keyup(function(e){
        if(e.keyCode == 13) {
            $(this).trigger("enterKey");
        }
    });

</script>