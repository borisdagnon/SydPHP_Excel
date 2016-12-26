/**
 * Cet document jQuery/ajax qui permet d'appeler la page PHP VHU.php pour procéder à la mise à jour
 */
	$("#submit").on('click', function( e ){
        e.preventDefault();

		var $url="ajax/VHU.php";
		$("#maj_success").hide("slow");
		$("#maj_fail").hide("slow");
	$("#display").show("slow");
	
		
	
	
			var formData = {
													   		
			};	
							
			var filterDataRequest = $.ajax(
    		{
												
        		type: "POST", 
        		url: $url,
        		dataType: "json",
				encode          : true,
        		data: formData
        	   
			});

			
			filterDataRequest.done(function(data)
			{
				
$i=0;
				if ( data.success)
				{		

$(data.live).each(function(index, value){
$i++;
/*
$("<tr><td>"+$i+"        "+value[0]+"</td>").appendTo("#non_Exist");
$("<td>"+value[1]+"</td>").appendTo("#non_Exist");
$("<td>"+value[2]+"</td>").appendTo("#non_Exist");
$("<td>"+value[3]+"</td>").appendTo("#non_Exist");
$("<td>"+value[4]+"</td>").appendTo("#non_Exist");
$("<td>"+value[5]+"</td>").appendTo("#non_Exist");
$("<td>"+value[6]+"</td>").appendTo("#non_Exist");
$("<td>"+value[7]+"</td>").appendTo("#non_Exist");
$("<td>"+value[8]+"</td>").appendTo("#non_Exist");
$("<td>"+value[9]+"</td></tr>").appendTo("#non_Exist");*/

$("#non_Exist").append("<tr><td>"+value[0]+"</td>");

			});
$("#non_Exist").append("</tr></table>");

					$("#display").hide("slow");
			
					$("#maj_success").show("slow");

$("#non_Exist").show();
				}
				else
				{
					$("#maj_fail").show("slow");
				}
				
					
				});
			filterDataRequest.fail(function(jqXHR, textStatus)
			{
				
     			if (jqXHR.status === 0){alert("Not connect.n Verify Network.");$("#display").hide("slow");}
    			else if (jqXHR.status == 404){alert("Requested page not found. [404]");$("#display").hide("slow");}
				else if (jqXHR.status == 500){alert("Internal Server Error [500].");$("#display").hide("slow");}
				else if (textStatus === "parsererror"){alert("Requested JSON parse failed.");$("#display").hide("slow");}
				else if (textStatus === "timeout"){alert("Time out error.");$("#display").hide("slow");}
				else if (textStatus === "abort"){alert("Ajax request aborted.");$("#display").hide("slow");}
				else{alert("Uncaught Error.n" + jqXHR.responseText);$("#display").hide("slow");}
			});
		
	});
   
	