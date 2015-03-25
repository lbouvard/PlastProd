$(document).ready(function() {

	//pour modifier le stock
  	$(document).on( 'click', "tr[name='stock'] a", function(){

  		var _quantite = $('#' + $(this)[0].id)[0].cells[4].firstChild.value;
  		var _oldquantite = $('#' + $(this)[0].id)[0].cells[4].firstChild.attributes['data-save'].value;
  		var _prix = $('#' + $(this)[0].id)[0].cells[3].firstChild.value;
  		var _operation = '';
  		var _valeur = 0;

  		//seulement si tout est ok
  		if( (_quantite >= 0 && !isNaN(_quantite) && _quantite != "") && ( _prix >= 0 && !isNaN(_prix) && _prix != "") )
  		{

  			 if( _quantite > _oldquantite ){
	  			_valeur = _quantite - _oldquantite;
	  			_operation = '+';
	  		}
	  		else if( _quantite < _oldquantite ){
	  			_valeur = _oldquantite - _quantite;
	  			_operation = '-';
	  		}
	  		else{
	  			_valeur = 0;
	  			_operation = '=';
	  		}

	  		//maj date-save et value a la nouvelle valeur de quantite
	  		$('#' + $(this)[0].id)[0].cells[4].firstChild.attributes['data-save'].value = _quantite;
			$('#' + $(this)[0].id)[0].cells[4].firstChild.value = _quantite;

	  		//opération ajax
		    $.ajax({
		        type: "POST",
		        url: $("#flash").attr("data-path"),
		        data: { id: $(this)[0].id, quantite: _quantite, prix: _prix, operation: _operation, valeur: _valeur},
		        cache: false,
		        success: function(data){    	
		        	$('#flash').html(data);
		        }
		    }); 
		}
    });

	
	//pour afficher les lignes d'un produit
	$(document).on( 'click', "tr[name='produit']", function() {

	    $.ajax({
	        type: "POST",
	        url: $("#lignesParProduit").attr("data-path"),
	        data: { id: $(this)[0].id },
	        cache: false,
	        success: function(data){
	           $('#lignesParProduit').html(data);
	        }
	    });
		
	});

});