
$(function(){
	$('.fast-order-send-button').click(function(){
		$("#fast-order-product-name").html($(this).data('name'));
		
		var variant;
		var form_obj=$(this).closest("form.variants");
		if(form_obj.find('input[name=variant]:checked').size()>0)
				variant = form_obj.find('input[name=variant]:checked').val();
		if(form_obj.find('select[name=variant]').size()>0)
				variant = form_obj.find('select').val();   
		
		 $("#fast-order-product-id").val(variant);            
		
	}); 
});
	
