$( document ).ready(function() {
  
  	if ( localStorage.getItem('mnuencours') != null && document.URL.indexOf('accueil') == -1 ){
  		$('#' + localStorage.getItem('mnuencours')).addClass('active');	
  	}
    else{
      $('#accueil').addClass('active');
    }
  		
  	$("#navbar li").on( 'click', function(){

  		//on supprime la classe active sur le menu précédement sélectionné (si disponible)
  		if ( localStorage.getItem('mnuencours') != null ){
  			$('#' + localStorage.getItem('mnuencours')).removeClass('active');
  		}

  		//on utilise le nouveau menu pour activer la classe active
  		var menu = $(this)[0].id; 
  		//$('#' + menu).addClass('active');
  		//on mémorise
  		localStorage.setItem("mnuencours", menu);

  	});

  	$("#mnuplatform li").on( 'click', function(){

  		//on supprime la classe active sur le menu précédement sélectionné (si disponible)
  		if ( localStorage.getItem('mnuencours') != null ){
  			$('#' + localStorage.getItem('mnuencours')).removeClass('active');
  		}

  		var menu = $(this)[0].id;
  		localStorage.setItem("mnuencours", menu);

  	});

    $(document).on('click', "tr[name='com']", function(){

      $.ajax({
          type: "POST",
          url: $("#details").attr("data-path"),
          data: 'id=' + $(this)[0].id,
          cache: false,
          success: function(data){
             $('#details').html(data);
          }
      });    
    });

    //page de connexion
    $('#connexionbtn').on('click', function () {

      var url = $(this).attr("data-path");
      $(location).attr('href',url);

    })

    //logout
    $('#deconnexionbtn').on('click', function () {

      var url = $(this).attr("data-path");
      $(location).attr('href',url);

    })

  	//commandes par client
  	$("tr[name='client']").on( 'click', function(){

	    $.ajax({
	        type: "POST",
	        url: $("#commandesParClient").attr("data-path"),
	        data: 'id=' + $(this)[0].id,
	        cache: false,
	        success: function(data){
	           $('#commandesParClient').html(data);
	        }
	    });    
    });

    //contact par société
    $("tr[name='societe']").on( 'click', function(){

      $.ajax({
          type: "POST",
          url: $("#contacts").attr("data-path"),
          data: 'id=' + $(this)[0].id,
          cache: false,
          success: function(data){
             $('#contacts').html(data);
          }
      });    
    }); 

    //Stock - Fournisseur
    $(document).on('click', '#btnajoutfournisseur', function() {
      var url = $("#btnajoutfournisseur").attr("data-path");
      $(location).attr('href',url);
    }); 

    //Stock - Matière première
    $(document).on('click', '#btnsupprimematiere', function() {
      var url = $("#btnsupprimematiere").attr("data-path");
      $(location).attr('href',url);
    });       

});