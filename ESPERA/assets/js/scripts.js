
var dir 		= window.location.href.split('/');
var urlC 		= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
var plus 		= (document.domain == 'localhost')?(1):(0);
var url 		= window.location.href;
var string 		= url.split('#'); 
var endereco	= string[0]; 
var hash 		= string[1]; 
var array 		= string[0].split('/'); 
var page_array 	= array[3+plus].split('?'); 
var pagina 		= page_array[0];
var parametro 	= array[4+plus]; 
var utc 		= new Date().toJSON().slice(0,10);

function copyToClipboard(element) {
	
	var $temp = $("<input>");
	$("body").append($temp);
	var texto = $(element).text();
	var texto_trim = texto.trim();
	$temp.val(texto_trim).select();
	document.execCommand("copy");
	$temp.remove();
}

$(document).ready(function(){
	
	/** VERIFICA SE A PLATAFORMA E MOBILE **/
	var isMobile = false;
	
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Opera Mobile|Kindle|Windows Phone|PSP|AvantGo|Atomic Web Browser|Blazer|Chrome Mobile|Dolphin|Dolfin|Doris|GO Browser|Jasmine|MicroB|Mobile Firefox|Mobile Safari|Mobile Silk|Motorola Internet Browser|NetFront|NineSky|Nokia Web Browser|Obigo|Openwave Mobile Browser|Palm Pre web browser|Polaris|PS Vita browser|Puffin|QQbrowser|SEMC Browser|Skyfire|Tear|TeaShark|UC Browser|uZard Web|wOSBrowser|Yandex.Browser mobile/i.test(navigator.userAgent)){
		
		isMobile = true;
	}
	
	
	
	$('body').stellar({
	    horizontalScrolling:false,
	    hideDistantElements: false,
	    responsive: true
	});
	
	
	$('.page-scroll').click(function(e){
		
		if(pagina == 'home'){
			
			e.preventDefault();
			
			var add = ($(window).width() > 768)?($('.navbar-default').height()):(0);		
			var target = e.target;
			
			if(target.hash){
				$('html, body').animate({
			        scrollTop: $(target.hash).offset().top - add
			    }, 700);
			}
		}
	});
		
	/** VALIDA CAMPOS REQUIRED DOS FORMS **/   
   	$('form').submit(function(e){
		$(this).find('input[required]:enabled').each(function(){
			if($(this).val() == ''){
				e.preventDefault();
			}
		});
	});
	

	function validaEmail(email){
		
		var eReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  		
  		return eReg.test(email);
	};
	
	function cidade_estado_ajax(uf){
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'cidade_estado_ajax',
			data: {
				uf: uf
			},
		    success: function(data){
				
				$('.cidade-select').fadeOut(300);
				
				setTimeout(function(){
					
					$('.cidade-select').fadeIn(200);
					$('.cidade-select').html(data);
				}, 500);
		    }
		});
	}
	
	$('.uf-select').change(function(){
		
		var uf = $(this).val();
		
		if(uf == ''){
			
			$(this).closest('form').find('.input-hide').hide();
		}else{
			
			$(this).closest('form').find('.input-hide').css({'display':'block'});
		}
		
		cidade_estado_ajax(uf);	
	});
});

$(window).on('load resize',function(){
	
});

$(window).scroll(function(){
	
	if($(window).width() > 767){
		
		if($(window).scrollTop() > 100){
	    	
	        $('.section-busca').addClass('busca-fixed');
	        $('.busca-interna').fadeIn();
	        $('.busca-home').fadeOut();
	    }else{
	        
	        $('.section-busca').removeClass('busca-fixed');
	        $('.busca-interna').fadeOut();
	        $('.busca-home').fadeIn();
	    }  
	}
});

$(window).load(function(){ 
	            
});
