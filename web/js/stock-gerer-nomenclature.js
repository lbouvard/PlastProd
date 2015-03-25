$( document ).ready(function() {

	$('#selnomenclature').on( "change", function() {

		if( $(this)[0].value != '-1')
		{
			$.ajax({
				type: "POST",
				url: $("#selfournisseur").attr("data-path"),
				data: 'id=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#selfournisseur').html(data);
				}
			});
		}
	});

    $(document).on('change', '#selectfournisseur', function() {

    	if( $(this)[0].value != '-1')
    	{
		    $.ajax({
				type: "POST",
				url: $("#selmateriau").attr("data-path"),
				data: 'id=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#selmateriau').html(data);
				}
		    }); 
		}   
    });

    $(document).on('change', '#selectmateriau', function() {

    	if( $(this)[0].value != '-1')
    	{
		    $.ajax({
				type: "POST",
				url: $("#formnomenclature").attr("data-path"),
				data: 'id=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#formnomenclature').html(data);
				}
		    }); 
		}   
    });

});