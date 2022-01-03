
//SE NÃO GERAR O ID DA SESSÃO E SETAR ESSE ID NO setSessionId NADA VAI FUNCIONAR
//DEVE-SE GERAR A IDENTIFICAÇÃO DO USUÁRIO TAMBÉM
//SE FOR CARTÃO DE CRÉDITO DEVE-SE GERAR O TOKEN DO CARTÃO

var dir = window.location.href.split('/');
var urlC = (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');

$.ajax({
    url : urlC + 'valores_sessao_ajax',
    dataType : 'json',
    success: function(data){
    	
    	sessionStorage.setItem('valor_total', data['valor_total']);
    	sessionStorage.setItem('max_sem_juros', data['max_sem_juros']);
    	
        //console.log(data);
    }
});

$(window).load(function(){ //recebe codigo da dessão e seta o sessão id

    $.ajax({
        url : urlC + 'pagseguro_sessao_id_ajax',
        type : 'post',
        dataTyp : 'json',
        async : false,
        timeout: 20000,
        success: function(data){
        	
            //console.log(data);
            
            PagSeguroDirectPayment.setSessionId(data);            
        }
    });
});
	
$('[name=cardNumber]').keyup(function(){
	
	var number = $(this).val().replace(/[^\d]+/g,'');
	var bin = number.toString();
		
	if(number.length < 6){
	
		$('[name=cardNumber]').css({'background':'none'});
		
		sessionStorage.setItem('bandeira', '');
	}else if(sessionStorage.getItem('bandeira') == ''){
		
		//console.log(bin);
				
		PagSeguroDirectPayment.getBrand( {
			
		  	cardBin: bin,
		  	success: function(response) {
				
				//console.log(response);
				
			    bandeira = response['brand']['name'];
			    
			    $('[name=bandeira]').val(bandeira);
			    
			    sessionStorage.setItem('bandeira', bandeira);
			    
				$('[name=cardNumber]').css({'background':'url(https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/'+bandeira+'.png) no-repeat 97% center'}).attr('data-brand', bandeira);
		  	},
		  	error: function(response) {
				console.log(response);
		  	}
		});	
	}
});
	
$('[name=cardNumber]').blur(function(){
	
	var number = $(this).val().replace(/[^\d]+/g,'');
		
	if(number.length < 16){
	
		$('[name=cardNumber]').css({'background':'none'});
		sessionStorage.setItem('bandeira', '');
	}
});

$('[name=cardNumber]').not('.recorrente').blur(function(){
	
	var number = $(this).val().replace(/[^\d]+/g,'');
	
	setTimeout(function(){
	
		if(sessionStorage.getItem('bandeira') != '' && number.length == 16){
			
			PagSeguroDirectPayment.getInstallments({
				
		        amount: sessionStorage.getItem('valor_total'),
		        maxInstallmentNoInterest: sessionStorage.getItem('max_sem_juros'),
		        brand: $('[name="cardNumber"]').attr('data-brand'),

		        success: function(response){ 
		        	
		        	//console.log(response);
		        	
		        	$.ajax({
						type: 'POST',
						url: urlC+'parcelamento_ajax',
						data: {
							retorno: response
						},
					    success: function(data){
							$('.parcelamento-cartao').html(data);
							$('.dados-cartao').fadeIn();
					    },
						beforeSend: function(){
							$('.loader').fadeIn(100);
						},
						complete: function(){
							$('.loader').fadeOut(100);
						}
					});
		        },
		        error: function(response){ console.log(response); }
		    });
		}
	},1000);
});
	  
$('[name=cvv], [name=cardNumber], [name=expiration]').on('keyup blur',function(){  //criar token
	
	var number = $('[name=cardNumber]').val().replace(/[^\d]+/g,'');
	var cvv = $('[name=cvv]').val().replace(/[^\d]+/g,'');
	
	if(cvv.length == 3 && $('[name=cvv]').val() != '' && $('[name=cardNumber]').val() != '' && number.length == 16 && $('[name=expiration]').val() != ''){
		
		var expiracao = $('[name=expiration]').val();
		var expiracao = expiracao.split('/'); 
		
	    numCartao = $('[name=cardNumber]').val().replace(/[^\d]+/g,'');
	    cvvCartao = $('[name=cvv]').val();
	    expiracaoMes = expiracao[0];
	    expiracaoAno = '20'+expiracao[1];

	    PagSeguroDirectPayment.createCardToken({
	    	
	        cardNumber: numCartao,
	        cvv: cvvCartao,
	        expirationMonth: expiracaoMes,
	        expirationYear: expiracaoAno,

	        success: function(response){
	        	
	        	//console.log(response);
	        	
	        	$('[name=psToken]').val(response['card']['token']);
	        	
	        	identificador = PagSeguroDirectPayment.getSenderHash();
      			$('[name=psHash]').val(identificador);
      			
      			if($('[name=cardNumber]').hasClass('recorrente')){
					
					$('.dados-cartao').fadeIn();
				}
	        },
	        error: function(response){ console.log(response); }
		});

	}
});
	  
$('.gera-boleto').click(function(){ 
	
	identificador = PagSeguroDirectPayment.getSenderHash();
	
    $.ajax({
		type: 'POST',
		url: urlC+'pagseguro_boleto_ajax',
		data: {
			psHash: identificador
		},
	    success: function(data){
			$('.box-boleto').html(data);
	    },
		beforeSend: function(){
			$('.loader').fadeIn(100);
		},
		complete: function(){
			$('.loader').fadeOut(100);
		}
	});
});
	  
$('.gera-boleto-assinatura').click(function(){ 
	
	identificador = PagSeguroDirectPayment.getSenderHash();
	
    $.ajax({
		type: 'POST',
		url: urlC+'pagseguro_boleto_assinatura_ajax',
		data: {
			psHash: identificador
		},
	    success: function(data){
			$('.box-boleto').html(data);
	    },
		beforeSend: function(){
			$('.loader').fadeIn(100);
		},
		complete: function(){
			$('.loader').fadeOut(100);
		}
	});
});

	

	  
