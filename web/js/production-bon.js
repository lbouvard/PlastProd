$(document).ready(function() {

    $(document).on('click', '#appbundle_prod_bontirer', function() {

    	if( $('#selnomenclature')[0].value != '-1' ){
		    $.ajax({
				type: "POST",
				url: $("#bonatirer").attr("data-path"),
				data: { id: $('#selnomenclature')[0].value, code: $('#selnomenclature')[0][$('#selnomenclature')[0].selectedIndex].text },
				cache: false,
				success: function(data){
					$('#bonatirer').html(data);
				}
		    });
		}    
    });


    $(document).on('click', '#imprimernom', function() {
		var restorepage = $('body').html();
		var printcontent = $('#cadrebon').clone();

		printcontent.addClass('landscape');

		$('body').empty().html(printcontent);

		window.print();

		$('body').html(restorepage);
    });

    $(document).on('click', '#annulernom', function() {

		var url = $("#annulernom").attr("data-path");
		$(location).attr('href',url);

    });

});