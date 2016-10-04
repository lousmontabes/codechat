<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<?php $con=mysqli_connect("localhost","root","admin","codechat"); ?>
<?php $chat_id = 2 ?>

<input type="text" id="message">

<div id="display">CLICK ME</div>

<div id="responsecontainer">Imma load</div>

<script src="scripts/jquery-1.7.1.min.js"></script>
<script type="text/javascript">

 $(document).ready(function() {

    $("#display").click(function() {                
		
		message = document.getElementById("message").value;
		
      $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "testcode.php?message=" + message + "&chat_id=" + <?php echo $chat_id ?>,             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#responsecontainer").html(response); 
            //alert(response);
        }

    });
});
});

</script>

</body>
</html>