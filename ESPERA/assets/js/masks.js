$(document).ready(function(){
	
	/** MASCARAS **/
	$('.data-mask').focusin(function(){
		
		$(this).mask("99/99/9999");
	});
	
	$('.dia-mask, .mes-mask').focusin(function(){
		
		$(this).mask("99");
	});
	
	$('.ano-mask').focusin(function(){
		
		$(this).mask("9999");
	});
	
	$(".cpf-mask").focusin(function(){
		
		$(this).mask("999.999.999-99");
	});
	
	$(".cnpj-mask").focusin(function(){
		
		$(this).mask("99.999.999/9999-99");
	});
	
	$(".cep-mask").focusin(function(){
		
		$(this).mask("99999-999");
	});
	
	$(".uf-mask").focusin(function(){
		
		$(this).mask("aa");
	});
	
	$('.fone-mask').focusin(function(){
		
		$(this).mask("(99) 9999-9999?9");
	});
	
	$('.fone-mask').focusout(function(){
		
		var phone, element;
		
		element = $(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		
		if(phone.length > 10) {
			
            element.mask("(99) 99999-999?9");
        }else{
        	
            element.mask("(99) 9999-9999?9");
        }
	});
});
