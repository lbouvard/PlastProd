$(document).ready(function() {

	//sélection de la commande et affichage du résultat de recherche (voir prochaine fonction)
	$(document).on('change', '#selcommande', function() {

		if( $(this)[0].value != '-1')
		{
		    $.ajax({
				type: "POST",
				url: $("#resultatcommande").attr("data-path"),
				data: 'codeInterne=' + $(this)[0].value,
				cache: false,
				success: function(data){
					$('#resultatcommande').html(data);
				}
		    });
		}    
    });

	//recherche par numéro de commande interne
    $(document).on('click', '#appbundle_prod_rechercher', function() {

	     $.ajax({
			type: "POST",
			url: $("#rebut").attr("data-path"),
			data: 'codeInterne=' + $('#appbundle_prod_code')[0].value,
			cache: false,
			success: function(data){
				$('#rebut').html(data);
			}
	    });    
    });

    //création bon à jeter
  	$(document).on( 'click', "tr[name='prod']", function(){

	    $.ajax({
	        type: "POST",
	        url: $("#bonajeter").attr("data-path"),
	        data: 'id=' + $(this)[0].id,
	        cache: false,
	        success: function(data){
	           $('#bonajeter').html(data);
	        }
	    });    
    });

    //impression du bon à jeter
    $(document).on('click', '#imprimerbonrebut', function() {
		var restorepage = $('body').html();
		var printcontent = $('#cadrebon').clone();

		printcontent.addClass('landscape');

		$('body').empty().html(printcontent);

		window.print();

		$('body').html(restorepage);
    });

    //retour a la recherche par commande
    $(document).on('click', '#annulernom', function() {

		var url = $("#annulernom").attr("data-path");
		$(location).attr('href',url);

    });

});