$(document).ready(function() {

	$(".submit").click(function(){
		var submit = $(this);
		var quantite = submit.parent().parent().find(".quantite").val();
		var Prix = submit.parent().parent().find(".Prix").val();
		var id = submit.parent().parent().find(".quantite").data("idstock");
		
		$.ajax("{{path('modifier_quantite_stock')}}",
		{
			method:"post",
			data:"id="+id+"&qte="+quantite+"&prix="+Prix,
			dataType:"json",
			success:function(data){
				if(data.success){
					alert(data.success);
				}else{
					alert(data.error);
				}
			},
			error:function(){
				
			}
		});
		
	});

	    //création bon à jeter
  	$(document).on( 'click', "tr[name='stock'] a", function(){

	    $.ajax({
	        type: "POST",
	        url: $("#flash").attr("data-path"),
	        data: { id: $(this)[0].id, quantite: $('#' + $(this)[0].id)[0].cells[4].firstChild.value, prix: $('#' + $(this)[0].id)[0].cells[3].firstChild.value },
	        cache: false,
	        success: function(data){
	           $('#flash').html(data);
	        }
	    });    
    });


});