//Admin JS Functions

	function deleteRecords()
	{           
	    var checked_items=0;
	    $('input[class=chkmsg]').each(function(u,v){
	        if($(v).attr('checked')=='checked')
	            checked_items=1;
	    });
	    
	    
	    if(!checked_items){
	        alert('Atleast select single record');
	        return false;
	    }
	    
	    if(!confirm('Do you want to delete this record(s)?')) 
	        return false;
	    
	    $('#delete_selected').click();
	}
    
    function activeRecords()
    {
        var checked_items=0;
        $('input[class=chkmsg]').each(function(u,v){
            if($(v).attr('checked')=='checked')
                checked_items=1;
        });
        
        
        if(!checked_items){
            alert('Atleast select single record');
            return false;
        }
              
        $('#activate_selected').click();
    }
    
    function deactiveRecords(){
        var checked_items=0;
        $('input[class=chkmsg]').each(function(u,v){
            if($(v).attr('checked')=='checked')
                checked_items=1;
        });
        
        
        if(!checked_items){
            alert('Atleast select single record');
            return false;
        }
              
        $('#deactivate_selected').click();
    }