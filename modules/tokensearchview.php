<div id="tokenArea">
    <input type="text" class="centered" id="tokenbar" placeholder="Enter token" onkeyup="updateResults(this.value)" spellcheck="false" autocomplete="off"/>
    <div id="tokenResult"></div>
</div>

<script>

    function updateResults(str){

        var tokenResult = $("#tokenResult");

        if(str.length == 7){
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
            tokenResult.removeClass("bounceDown");
            tokenResult.html("");
        }

    }

</script>