<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<script src="scripts/jquery-1.7.1.min.js"></script>

<?php

$email = "lluis.456@gmail.com";

?>

<script>

var emailData = {email:"<?php echo $email ?>"};
checkEmail(emailData);

function checkEmail(email){
	$.ajax({
        type: "POST",
		data: email,
        url: "sql_checkemail.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            if response == 0{
				// EMAIL DOESNT EXIST
			}
			else if response == 1{
				// EMAIL ALREADY EXISTS
			}
        }

    });	

}

</script>

</body>
</html>