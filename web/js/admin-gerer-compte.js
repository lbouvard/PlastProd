$( document ).ready(function() {

	$('#selsociete').on( "change", function() {

		if( $(this)[0].value != '-1')
		{
			$.ajax({
				type: "POST",
				url: $("#selcontact").attr("data-path"),
				data: 'id=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#selcontact').html(data);
				}
			});
		}
	});

    $(document).on('change', '#selectcontact', function() {

    	if( $(this)[0].value != '-1')
    	{
		    $.ajax({
				type: "POST",
				url: $("#formutilisateur").attr("data-path"),
				data: 'id=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#formutilisateur').html(data);
				}
		    }); 
		}   
    });
});