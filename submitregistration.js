$("#newchatform").submit(function (e) { 
 
 	 var validName = "FALSE";
 	 var validEmail = "FALSE";
	 var validUniqueEmail = "FALSE";
	 var validPassword = "FALSE";
 
	 if ($("#nameinput").val() == ""){
		 validName = "FALSE";
		 $("#namewarning").html("<b>!</b> Please enter your name");
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","220px");
	 }else if ($("#nameinput").val().length == 1){
		 validName = "FALSE";
		 $("#namewarning").html("<b>!</b> Your name must be longer than 1 character");
		 $("#namewarning").css("opacity","1");
		 $("#namewarning").css("width","360px");
	 }else if ($("#nameinput").val().length > 1){
		 validName = "TRUE";
		 $("#namewarning").css("opacity","0");
		 $("#namewarning").css("width","0px");
	 }
	 
	 if ($("#emailinput").val() == ""){
		 validEmail = "FALSE";
		 $("#emailwarning").html("<b>!</b> Please enter a valid email address");
		 $("#emailwarning").css("opacity","1");
		 $("#emailwarning").css("width","290px");
	 }else{
		 validEmail = "TRUE";
		 $("#emailwarning").css("opacity","0");
		 $("#emailwarning").css("width","0px");
	 }
	 
	 if ($("#passwordinput").val() == ""){
		 validPassword = "FALSE";
		 $("#passwordwarning").html("<b>!</b> Please enter a password");
		 $("#passwordwarning").css("opacity","1");
		 $("#passwordwarning").css("width","220px");
	 }else if ($("#passwordinput").val().length < 8){
		 validPassword = "FALSE";
		 $("#passwordwarning").html("<b>!</b> Your password must be at least 8 characters long");
		 $("#passwordwarning").css("opacity","1");
		 $("#passwordwarning").css("width","410px");
	 }else if ($("#passwordinput").val().length >= 8){
		 validPassword = "TRUE";
		 $("#passwordwarning").css("opacity","0");
		 $("#passwordwarning").css("width","0px");
	 }
	 
	 emailValue = $("#emailinput").val();
 	 var emailData = {email:emailValue};
 
 	 $.ajax({
		 	async:false,
			type: "POST",
			data: emailData,
			url: "sql_checkemail.php",             
			dataType: "html",   //expect html to be returned                
			success: function(response){                  
				if (response == 0){
					var validUniqueEmail = "TRUE";
					alert(validUniqueEmail);
				}
				else if (response == 1){
					var validUniqueEmail = "FALSE";
					$("#emailwarning").html("<b>!</b> This email address is already in use");
				    $("#emailwarning").css("opacity","1");
				    $("#emailwarning").css("width","300px");
				}
			}
	
		});	
	 
	 alert("Name = "+validName+"\nEmail = "+validEmail+"\nPassword = "+validEmail+"\nUnique = "+validUniqueEmail);
	if (validName == "FALSE" || validEmail == "FALSE" || validPassword == "FALSE" || validUniqueEmail == "FALSE"){
		e.preventDefault(); 
	}
	 
 });