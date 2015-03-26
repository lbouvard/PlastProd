$( document ).ready(function() {

	var $ligne = $('#protonomenclature');
	var $conteneur = $('table#tabliste');
	var index = 0;

	$('#selfournisseur').attr("disabled","disabled");
	$('#selectmateriau').attr("disabled","disabled");
	$('#btnajouter').attr("disabled","disabled");


	// Pour chaque matière première, on ajoute un lien de suppression
	$conteneur.children('tr').each( function() {
		ajoutSuppressionLien($(this));
	});

	$('#selnomenclature').on( "change", function() {

		if( $(this)[0].value != '-1')
		{
			$("#selfournisseur").removeAttr("disabled");
			$("#codenomenclature")[0].value = $(this)[0].value;
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

    $('#btnajouter').on( "click", function() {
    	if( $('#selectmateriau option:selected')[0].value != -1 )
    		ajoutMateriau($conteneur);
    });

    $(document).on('click', '#btnannuler', function() {

		var url = $("#nomenclature_annuler").attr("data-path");
		$(location).attr('href',url);

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

	// La fonction qui ajoute une ligne de tableau
	function ajoutMateriau($conteneur) {

		// on remplace le __name__ avec l'index en cours
		var $prototype = $($ligne.attr('data-prototype').replace(/__name__/g, index));
		//tableau json des produits passé par symfony (variable )
		var matieres = $.parseJSON(listematiere);
		//index du tableau json
		var idproduit = -1;

		// On ajoute au prototype un lien pour pouvoir supprimer la matière première
		ajoutSuppressionLien($prototype);

		// On ajoute le prototype modifié à la fin du tableau
		$conteneur.append($prototype);

		//On recupère la valeur de l'option sélectionné et on recherche l'index du produit dans le json
		jQuery.each(matieres, function(index, value){
			if (value.idtProduit == $('#selectmateriau option:selected')[0].value) {
				idproduit = index;
				return;
			}
		});

		//On rempli les champs
		if( idproduit >= 0 ){
			$('#nomenclature_' + index + '_pcode').val(matieres[idproduit].codeProduit);
			$('#nomenclature_' + index + '_pnom').val(matieres[idproduit].nomProduit);
			$('#nomenclature_' + index + '_quantite').val(1);
			$('#nomenclature_' + index + '_pid').val(matieres[idproduit].idtProduit);
		}

		// Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
		index++;

		return false;
	}

});