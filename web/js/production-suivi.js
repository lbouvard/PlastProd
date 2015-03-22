$(document).ready(function() {

    $(document).on('click', '#appbundle_prod_rechercher', function() {

	     $.ajax({
			type: "POST",
			url: $("#suivi").attr("data-path"),
			data: 'codeInterne=' + $('#appbundle_prod_code')[0].value,
			cache: false,
			success: function(data){
				$('#suivi').html(data);
			}
	    });    
    });

});