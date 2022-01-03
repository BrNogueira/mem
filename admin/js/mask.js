
$(document).ready(function(){
	
	$(".periodo").mask("99? 99 99 99 99 99 99 99 99 99 99 99");
	$(".numero").mask("9?999999");
	$(".data_completa").mask("99/99/9999");
	$(".data_hora_mask").mask("99/99/9999 99:99");
	$(".peso").maskMoney({showSymbol:true, symbol:"", decimal:".", thousands:"", precision:3});
	$(".taxa").maskMoney({showSymbol:true, symbol:"", decimal:".", thousands:"", precision:5});
	$(".moeda_real").maskMoney({showSymbol:true, symbol:"", decimal:".", thousands:""});
	$(".moeda_real").focusout(function(){
		
		/*if($(this).val() == '0.00'){
			
			$(this).val('');
		}*/
		
		if($(this).val() == ''){
			
			$(this).val(0);
		}
	});
		
	$(".cpf-mask").focusin(function(){
		
		$(this).mask("999.999.999-99");
	});
	
	$(".rg-mask").focusin(function(){
		
		$(this).mask("99999999?99");
	});
	
	$(".cnpj-mask").focusin(function(){
		
		$(this).mask("99.999.999/9999-99");
	});
	
	$(".cnj-mask").focusin(function(){
		
		$(this).mask("999/9.99.9999999-9");
	});
	
	$(".themis-mask").focusin(function(){
		
		$(this).mask("9999999-99.999.9.99.9999");
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