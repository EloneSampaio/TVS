$(document).ready(function(){
    open();
     $('.multiselect').multiselect();
  $('.datepicker').datepicker();  
    
  

});



function open(){
    
    	
	$(document).on('click', '#novocl', function(){ 
            var id = $(this).attr('rel');
        console.log(id);
	
		var link="http://localhost/Tvs/views/cliente/novo"
		
		// show a loader image
		$('#loaderImage').show();

		// read and show the records after 1 second
		// we use setTimeout just to show the image loading effect when you have a very fast server
		// otherwise, you can just do: $('#pageContent').load('update_form.php?user_id=" + user_id + "', function(){ $('#loaderImage').hide(); });
		setTimeout("$('#pageContent').load('"+link+"', function(){ $('#loaderImage').hide(); });",1000);
		
	});
    
}