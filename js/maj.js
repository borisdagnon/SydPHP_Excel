
	$("#submit").on('click', function( e ){
        e.preventDefault();

		var $url="ajax/maj.php";
		$("#maj_success").hide("slow");
		$("#maj_fail").hide("slow");
			
			var formData = {
													   		
			};	
							
			var filterDataRequest = $.ajax(
    		{
												
        		type: "POST", 
        		url: $url,
        		dataType: "json",
				encode          : true,
        		data: formData,	
			});
			filterDataRequest.done(function(data)
			{
				if ( data.success)
				{		
					$("#maj_success").show("slow");
				}
				else
				{
					$("#maj_fail").show("slow");
				}
				
					
				});
			filterDataRequest.fail(function(jqXHR, textStatus)
			{
				
     			if (jqXHR.status === 0){alert("Not connect.n Verify Network.");}
    			else if (jqXHR.status == 404){alert("Requested page not found. [404]");}
				else if (jqXHR.status == 500){alert("Internal Server Error [500].");}
				else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");}
				else if (textStatus === "timeout"){alert("Time out error.");}
				else if (textStatus === "abort"){alert("Ajax request aborted.");}
				else{alert("Uncaught Error.n" + jqXHR.responseText);}
			});
		
	});
   
	