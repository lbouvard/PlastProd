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

});