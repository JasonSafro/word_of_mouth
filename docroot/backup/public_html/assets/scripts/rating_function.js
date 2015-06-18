function saveratings(rating,busId)
    {
        $.ajax({
                                type: "GET",
                                url : "<?php echo base_url(); ?>insert_ratings/insert_bus_ratings?rating=" + rating + "&busId=" + busId,
                                datatype:'text',
                                success : function(result) {
									if(result)
									{
										alert("Ratings Added!");
									}
									else
									{
									    alert("Please Login To give Ratings!");
									}
                                }
                        }); 
     /*   var xmlhttp=false;
        var currentUrl="<?php echo current_url();?>";
        
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText=="user_not_logged_in")
                {
                    alert("Please Login To give Ratings!");
                    
                    window.location.href=currentUrl;
                }
                else{
                    alert("Ratings Added!");
                    window.location.href=currentUrl;
                    //document.getElementById("rated").innerHTML=xmlhttp.responseText;
                }
                
            }
        }
        xmlhttp.open("GET","<?php echo base_url(); ?>insert_ratings/insert_bus_ratings?rating=" + rating + "&busId=" + busId,true);
        xmlhttp.send(""); */
    }