$( document ).ready(function() {

	var $prototype = $('<tr><td><input type="text" id="nomenclature___name___pcode" name="nomenclature[__name__][pcode]" readonly="readonly"/></td><td><input type="number" id="nomenclature___name___quantite" name="nomenclature[__name__][quantite]" required="required" /></td><td><input type="hidden" id="nomenclature___name___pid" name="nomenclature[__name__][id]" readonly="readonly"/></td></tr>');

	$('#selfournisseur').attr("disabled","disabled");
	$('#selectmateriau').attr("disabled","disabled");
	$('#btnajouter').attr("disabled","disabled");

	$('#selnomenclature').on( "change", function() {

		if( $(this)[0].value != '-1')
		{
			$("#selfournisseur").removeAttr("disabled");
		}
	});

    $('#selfournisseur').on( "change", function() {

    	if( $(this)[0].value != '-1')
    	{
    		$("#selectmateriau").removeAttr("disabled");
    		$("#btnajouter").removeAttr("disabled");

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

    function ajoutSuppressionLien($prototype) {
		
		$deleteLink = $('<td><a href="#" class="btn btn-danger">Supprimer</a></td>');

		$prototype.append($deleteLink);

		$deleteLink.click(function(e) {
			$prototype.remove();
			e.preventDefault();
			return false;
		});
  	}

});