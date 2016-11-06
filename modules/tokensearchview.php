<div id="tokenArea">
    <input type="text"
           class="centered"
           id="tokenbar"
           placeholder="Enter token"
           oninput="updateResults(this.value)"
           spellcheck="false"
           autocomplete="off"
           maxlength="7"
    />
    <div id="tokenResult"></div>
</div>

<script>

    function updateResults(str){

        var tokenBar = $("#tokenbar");
        var tokenResult = $("#tokenResult");

        if(str.length == 7){

            tokenBar.css("color","lightgray");
            tokenBar.blur();

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

</script>