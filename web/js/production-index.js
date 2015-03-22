$(document).ready(function() {

   	//suivi prod produit
    $("tr[name='prod']").on( 'click', function(){

      $.ajax({
          type: "POST",
          url: $("#detailsprod").attr("data-path"),
          data: 'codeInterne=' + $(this)[0].id,
          cache: false,
          success: function(data){
             $('#detailsprod').html(data);
          }
      });    
    }); 

});