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

$(document).mouseleave(function(e){
		
	if(!$('body').hasClass('modal-open') && !$('body').hasClass('pause') && (e.pageY < 0 || e.pageX < 0 || e.pageX > $(window).width())){
		
		$('#modal-sair').modal('show');
		
		$('body').addClass('pause');
		
		setTimeout(function(){
			$('body').removeClass('pause');
		},60000);
	}
});

$(document).on('click', '.product-chooser .product-chooser-item', function(){
	
	$(this).parent().parent().find('div.product-chooser-item').removeClass('selected');
	$(this).addClass('selected');
	$(this).find('input[type="radio"]').prop("checked", true);	
});

function validarCPF(cpf) {	
	cpf = cpf.replace(/[^\d]+/g,'');	
	if(cpf == '') return false;	
	// Elimina CPFs invalidos conhecidos	
	if (cpf.length != 11 || 
		cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999")
			return false;		
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9)))		
			return false;		
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10)))
		return false;		
	return true;   
}

$(document).ready(function(){
	
	/** VERIFICA SE A PLATAFORMA E MOBILE **/
	var isMobile = false;
	
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Opera Mobile|Kindle|Windows Phone|PSP|AvantGo|Atomic Web Browser|Blazer|Chrome Mobile|Dolphin|Dolfin|Doris|GO Browser|Jasmine|MicroB|Mobile Firefox|Mobile Safari|Mobile Silk|Motorola Internet Browser|NetFront|NineSky|Nokia Web Browser|Obigo|Openwave Mobile Browser|Palm Pre web browser|Polaris|PS Vita browser|Puffin|QQbrowser|SEMC Browser|Skyfire|Tear|TeaShark|UC Browser|uZard Web|wOSBrowser|Yandex.Browser mobile/i.test(navigator.userAgent)){
		
		isMobile = true;
	}
	
	$('[name=cpf]').blur(function(){
		
		var elemento = $(this);
		var cpf = elemento.val();
		var placeholder = elemento.attr('placeholder');
		
		if(validarCPF(cpf) == false){
			
			elemento.attr('placeholder', cpf);
			elemento.val('');
			alert('CPF inválido! Por favor, confira o CPF digitado.');
			elemento.attr('placeholder', placeholder);
		}
	}); 
	
	$('.form-filtro :radio').mousedown(function(e){
	  var $self = $(this);
	  if( $self.is(':checked') ){
	    var uncheck = function(){
	      setTimeout(function(){$self.removeAttr('checked');},0);
	    };
	    var unbind = function(){
	      $self.unbind('mouseup',up);
	    };
	    var up = function(){
	      uncheck();
	      unbind();
	    };
	    $self.bind('mouseup',up);
	    $self.one('mouseout', unbind);
	  }
	});
	
	/*setTimeout(function(){
		$('body').animate({'opacity':'1'});
	}, 550);*/
		
	$('.bg-cover > img, .bg-contain > img').each(function(){
		
		if($(this).attr('data-src')){
			
			var src = $(this).attr('data-src');
		}else{
			
			var src = $(this).attr('src');
		}
		
		$(this).hide();
		$(this).parent().css({ 'background-image': 'url('+src+')' });
	});
	
		var target_date = new Date("april 30, 2020").getTime();
		var dias, horas, minutos, segundos;
		var regressiva = document.getElementById("regressiva");

		/*setInterval(function () {

		    var current_date = new Date().getTime();
		    var segundos_f = (target_date - current_date) / 1000;

			dias = parseInt(segundos_f / 86400);
		    segundos_f = segundos_f % 86400;
		    
		    horas = parseInt(segundos_f / 3600);
		    segundos_f = segundos_f % 3600;
		    
		    minutos = parseInt(segundos_f / 60);
		    segundos = parseInt(segundos_f % 60);
		    
		    horas = (horas < 10)?('0'+horas):(horas);
		    minutos = (minutos < 10)?('0'+minutos):(minutos);
		    segundos = (segundos < 10)?('0'+segundos):(segundos);

		    document.getElementById('dia').innerHTML = dias;
			document.getElementById('hora').innerHTML = horas;
			document.getElementById('minuto').innerHTML = minutos;
			document.getElementById('segundo').innerHTML = segundos;
		}, 1000);*/
	
	
	$('[data-mh]').each(function() {
        $(this).matchHeight();
    });
    
    $('.li-departamentos').mouseover(function(){
    	
    	$(this).find('.box-submenu').fadeIn();
    }).mouseleave(function(){
    	
    	$(this).find('.box-submenu').fadeOut();
    });
	
	$('.btn-search').click(function(){
		
		$('.form-busca-mobile').fadeToggle();
	});
	
	$('.link-tab').click(function(){
		
		var href = $(this).attr('href');
		window.location.href = href;
	});
	
	setTimeout(function(){
  		
  		$('.balao-frete').popover('show');
  	},3000);
  	
  	setInterval(function(){
		
		$('.element-blink').effect('pulsate', {times:3}, 1000);
	},5000);
	
	
	$('.pagination a').click(function(){
		
		$(this).closest('.pagination').find('li').removeClass('active');
		$(this).closest('li').addClass('active');
	});
	
	$('[data-scroll-trigger]').click(function(){
		
		var id = $(this).attr('data-scroll-trigger');
		var navElement = ($(window).width() < 768)?($('.navbar-header')):($('nav'));
		
		$('html, body').animate({ scrollTop: $('[data-scroll-target="'+id+'"]').offset().top - navElement.innerHeight() }, 500);
	});
	
	$('.dot').each(function(){
		
		var elemento = $(this);
		var height = $(this).attr('data-dot');
		
		elemento.css({'max-height':height+'px'});
		
		setTimeout(function(){
			
			elemento.dotdotdot({
				height: parseInt(height)
			});
		}, 300);
	});
	
	$('.main-menu li a').each(function(){
		
		var href = $(this).attr('href');
		
		if(pagina != 'home' && (href == window.location || href == $('[data-link-active]').attr('data-link-active'))){
			
			$(this).not('.link-home').parents('li').addClass('active');
		}
	});
	
	var avaliacao = $('.form-avaliacao i.fa-star').length;
	
	$('.form-avaliacao span button').mouseover(function(){
		
		var opcao = $(this).index();
		
		$('.form-avaliacao span button').each(function(){
			if($(this).index() <= opcao){
				$(this).find('i').removeClass('fa-star-o').addClass('fa-star');
			}else{
				$(this).find('i').removeClass('fa-star').addClass('fa-star-o');				
			}
		})
	}).mouseleave(function(){
			
		$('.form-avaliacao span button').each(function(){
			if($(this).index() < avaliacao){
				$(this).find('i').removeClass('fa-star-o').addClass('fa-star');
			}else{
				$(this).find('i').removeClass('fa-star').addClass('fa-star-o');				
			}
		})	
	});
	
	$('#tabs').tabs();
		
	$('.light-gallery').each(function(){
		
		$(this).lightGallery({
			mode: 'lg-fade',
			download: false
		}); 
	});
	
	var owl_1 = $('.owl-1').owlCarousel({
	    loop: true,
	    margin: 30,
	    responsiveClass: true,
	    nav: false,
	    dots: false,
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 3
	        },
	        992:{
	            items: 3
	        },
	        1200:{
	            items: 3
	        }
	    }
	});
	
	$('.owl-nav-1.owl-prev').click(function(){
		owl_1.trigger('prev.owl.carousel');
	});
	$('.owl-nav-1.owl-next').click(function(){
		owl_1.trigger('next.owl.carousel');
	});
	
	var owl_2 = $('.owl-2').owlCarousel({
	    margin: 30,
	    responsiveClass: true,
	    nav: false,
	    dots: false,
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 3
	        },
	        992:{
	            items: 4
	        },
	        1200:{
	            items: 5
	        }
	    }
	});
	
	$('.owl-nav-2.owl-prev').click(function(){
		owl_2.trigger('prev.owl.carousel');
	});
	$('.owl-nav-2.owl-next').click(function(){
		owl_2.trigger('next.owl.carousel');
	});
	
	var owl_3 = $('.owl-3').owlCarousel({
	    margin: 30,
	    responsiveClass: true,
	    nav: false,
	    dots: false,
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 3
	        },
	        992:{
	            items: 4
	        },
	        1200:{
	            items: 5
	        }
	    }
	});
	
	$('.owl-nav-3.owl-prev').click(function(){
		owl_3.trigger('prev.owl.carousel');
	});
	$('.owl-nav-3.owl-next').click(function(){
		owl_3.trigger('next.owl.carousel');
	});
	
	var owl_4 = $('.owl-4').owlCarousel({
	    margin: 30,
	    responsiveClass: true,
	    nav: false,
	    dots: false,
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 2
	        },
	        992:{
	            items: 3
	        },
	        1200:{
	            items: 3
	        }
	    }
	});
	
	$('.owl-nav-4.owl-prev').click(function(){
		owl_4.trigger('prev.owl.carousel');
	});
	$('.owl-nav-4.owl-next').click(function(){
		owl_4.trigger('next.owl.carousel');
	});
	
	
	
	$('.owl-zoom a').click(function(e){
		
		e.preventDefault();
		
		var href = $(this).attr('href');
		
		if($(this).find('figure img').attr('data-src')){
			
			var imagem = $(this).find('figure img').attr('data-src');
		}else{
			
			var imagem = $(this).find('figure img').attr('src');
		}
				
		$(this).closest('.area-zoom').find('a[data-light-gallery]').attr('href',href);
		$(this).closest('.area-zoom').find('.img-maior img').attr('src',imagem);
		$(this).closest('.area-zoom').find('.img-maior').css('background-image','url('+imagem+')');
	});
	
	$('.owl-rel').owlCarousel({
		autoHeight: true,
	    loop: false,
	    margin: 0,
	    responsiveClass: true,
	    nav: true,
	    dots: false,
	    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	    responsive: {
	        0:{
	            items: 1
	        }
	    }
	});
	
	
	$('.owl-zoom a').click(function(e){
		
		e.preventDefault();
		
		var imagem = $(this).attr('href');
				
		$(this).closest('.area-galeria-produto').find('a[data-light-gallery]').attr('href',imagem);
		$(this).closest('.area-galeria-produto').find('a[data-light-gallery] figure img').attr('src',imagem);
		$(this).closest('.area-galeria-produto').find('a[data-light-gallery] figure').css('background-image','url('+imagem+')');
	});
	
	$('.owl-marcas').owlCarousel({
	    loop: true,
	    margin: 30,
	    responsiveClass: true,
	    nav: false,
	    dots: false,
	    autoplay: true,
	    autoplaySpeed: 1000,
	    autoplayTimeout: 2000,
	    autoplayHoverPause: true,
	    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	    responsive: {
	        0:{
	            items: 3
	        },
	        768:{
	            items: 4
	        },
	        992:{
	            items: 5
	        }
	    }
	});
	
	$('.owl-destaques').owlCarousel({
	    loop: true,
	    margin: 30,
	    responsiveClass: true,
	    nav: true,
	    dots: false,
	    autoplayHoverPause: true,
	    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 3
	        },
	        992:{
	            items: 4
	        },
	        1200:{
	            items: 5
	        }
	    }
	});
	
	$('.owl-blog').owlCarousel({
	    loop: true,
	    margin: 30,
	    responsiveClass: true,
	    nav: true,
	    dots: false,
	    autoplayHoverPause: true,
	    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	    responsive: {
	        0:{
	            items: 1
	        },
	        768:{
	            items: 2
	        },
	        992:{
	            items: 3
	        }
	    }
	});
		
	
	$('[data-light-gallery]').click(function(e){
		
		e.preventDefault();
		
		var dado = $(this).attr('href');
		
		$('.light-gallery a[href="'+dado+'"]').click();
	});
	
	$('.chooser-cor').click(function(){
		
		setTimeout(function(){
			
			var opcao = $('[name=id_cor]:checked').val();
		
			if(opcao > 0){
				
				$('[data-cor-galeria]').hide();
				$('[data-cor-galeria="'+opcao+'"]').fadeIn();
			}else{
				
				$('[data-cor-galeria]').hide();
				$('[data-cor-galeria]:first-of-type').fadeIn();
			}
			
			var id_produto = $('.id_produto').attr('id');
			var id_cor = opcao;
			
			$('.tamanhos-ok').html('');
			$('.modelos-ok').html('');
			
			$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val('');
			
			if(id_cor != ''){
				
				$.ajax({
			 	
					type: "POST",
					url: urlC+'tamanhos_ajax',
					data: {
						id_produto: id_produto,
						id_cor: id_cor
					},
				    success: function(data){
						
						setTimeout(function(){
							
							$('.tamanhos-ok[data-select='+id_produto+']').html(data);
							$('.tamanhos-ok[data-select='+id_produto+']').fadeIn(500);
						}, 500);
				    },
					beforeSend: function(){
						$('.loader').fadeIn(100);
					},
					complete: function(){
						$('.loader').fadeOut(100);
					}
				});
			}else{
				
				$('.tamanhos-ok').html('');
			}
		},500);
	});
	
	$('.number-spin').each(function(){
		
		$(this).TouchSpin({
			min: 1,
			max: $(this).attr('data-stock')
		});
	});
	
	$('.chosen-select').chosen();
	
	$(window).on('load resize scroll',function(){
		
	});
	
	$('body').stellar({
	    horizontalScrolling:false,
	    hideDistantElements: false,
	    responsive: true
	});
	
	$('.number-spin').each(function(){
		
		$(this).TouchSpin({
			min: 1,
			max: 1000
		});
	});
	
	$('.btn-fecha-pagamento').click(function(){
		
		var modo = $(this).data('modo');
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'pagar_ajax',
			data: {
				modo: modo
			},
		    success: function(data){
				
				window.location.replace(urlC);
		    },
			beforeSend: function(){
				$('.loader').fadeIn(100);
			},
			complete: function(){
				$('.loader').fadeOut(100);
			}
		});
	});
	
	setInterval(function(){
		
		$('.icone-frete').animate({'left':'-300px'},2000).animate({'left':$(window).width()},0).animate({'left':'0px'},3000).effect('pulsate', {times:3}, 1500).delay(3000);
	},2000);
	
	$('select[name="parcelamento"]').change(function(e){
		
		var total_carrinho = $('option:selected', this).data('total-carrinho');
		var total_compra = $('option:selected', this).data('total-compra');
		
		$('.total-carrinho').html(total_carrinho).effect('pulsate', {times:3}, 1000);
		$('.total-compra').html(total_compra).effect('pulsate', {times:3}, 1000);
	});
	
	$('[data-tipo-pagamento]').click(function(){
		
		var opcao = $(this).data('tipo-pagamento');
		var total_carrinho = $(this).data('total-carrinho');
		var total_compra = $(this).data('total-compra');
		
		if(opcao != 'credito'){
			
			$('.total-carrinho').html(total_carrinho).effect('pulsate', {times:3}, 1000);	
			$('.total-compra').html(total_compra).effect('pulsate', {times:3}, 1000);	
			$('form.form-pagar-cielo').trigger('reset');		
		}else{
			
			var total_carrinho = $('select[name="parcelamento"] option:selected').data('total-carrinho');
			var total_compra = $('select[name="parcelamento"] option:selected').data('total-compra');
			
			$('.total-carrinho').html(total_carrinho).effect('pulsate', {times:3}, 1000);
			$('.total-compra').html(total_compra).effect('pulsate', {times:3}, 1000);
		}
		
		if(opcao == 'credito'){
			
			$('.desconto-boleto, .desconto-deposito').hide();			
		}else if(opcao == 'boleto'){
			
			$('.desconto-boleto').show();
			$('.desconto-deposito').hide();
		}else if(opcao == 'deposito'){
			
			$('.desconto-boleto').hide();
			$('.desconto-deposito').show();
		}
	});
	
	$('.input-quantidade').change(function(){
		
		var element = $(this);
		var quantidade = element.val();
		var data_var = element.attr('data-var');
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'quantidade_ajax',
			data: {
				quantidade: quantidade,
				data_var: data_var
			}
		});
	});
	
	$('.campo-observacao').focusout(function(){
		
		var element = $(this);
		var observacao = element.val();
		var data_var = element.attr('data-var');
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'observacao_ajax',
			data: {
				observacao: observacao,
				data_var: data_var
			}
		});
		
		$('.btn-enviar-orcamento').removeAttr('disabled');
	});
	
	$('.btn-excluir').click(function(){
		
		var element = $(this);
		var data_var = element.attr('data-var');
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'excluir_ajax',
			data: {
				data_var: data_var
			},
		    success: function(data){
				
				element.closest('tr').fadeOut();
		    }
		});
	});
	
	$('.campo-observacao').focusin(function(){
		
		$('.btn-enviar-orcamento').attr('disabled','disabled');
	});
	
	$('.btn-remover-visitado').click(function(){
		
		var element = $(this);
		var id = element.data('id');
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'remover_visitado_ajax',
			data: {
				id: id
			},
		    success: function(data){
				
				element.closest('.owl-item').fadeOut(function(){
					
					element.remove();
				});
		    }
		});
	});
	
	if(pagina == 'home'){
		
		$('#modal-cupons').modal('show');
		
		/*setTimeout(function(){
			
			$('#modal-visitados').modal('show');
			
			setTimeout(function(){
				match_height();
			}, 700);
		}, 100000);*/
	}
	
	$('[name="cartao"]').focusout(function(){
		
		var element = $(this);
		var dado = element.val();
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'cartao_ajax',
			data: {
				dado: dado
			}
		});
		
		$('.btn-enviar-orcamento').removeAttr('disabled');
	});
	
	$('.box-observacao').focusout(function(){
		
		var element = $(this);
		var dado = element.val();
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'observacoes_ajax',
			data: {
				dado: dado
			}
		});
	});
	
	$('select.select-frete').change(function(){
		
		var element = $(this);
		var valor = $('option:selected', element).data('valor');
		
		$('.frete-cidade').html(valor).addClass('font-bold text-custom-2').effect('pulsate', {times:3}, 1000);
	});
	
	$('[name="tipo_pessoa"]').change(function(){
		
		var element = $(this);
		var opcao = $('option:selected', element).val();
		
		if(opcao == 'j'){
			
			element.closest('form').find('.campo-pf').hide();
			element.closest('form').find('.campo-pf input').attr('disabled', 'disabled');
			element.closest('form').find('.campo-pj').fadeIn();
			element.closest('form').find('.campo-pj input').removeAttr('disabled');
		}else{
			
			element.closest('form').find('.campo-pj').hide();
			element.closest('form').find('.campo-pj input').attr('disabled', 'disabled');
			element.closest('form').find('.campo-pf').fadeIn();
			element.closest('form').find('.campo-pf input').removeAttr('disabled');
		}
	});
	
	$('.btn-foto :file').filestyle({
		buttonText : '&nbsp;&nbsp;Foto',
		placeholder: 'Nenhum arquivo selecionado'
	});
	
	$('.btn-arquivo :file').filestyle({
		buttonText : '&nbsp;&nbsp;Arquivo',
		placeholder: 'Nenhum arquivo selecionado'
	});
	
	$('.btn-arquivos :file').filestyle({
		buttonText : '&nbsp;&nbsp;Fotos/Planta do Ambiente',
		placeholder: 'Nenhum arquivo selecionado'
	});
	
	
	/*var filterList = {
	
		init: function () {
			
			$('#portfoliolist').mixItUp({
				selectors: {
					target: '.portfolio',
					filter: '.filter'	
  		 		},
  		  		load: {
	    		  filter: 'all'
	    		}   
			});	
		}
	};
	
	filterList.init();*/
	
	$('[data-filter]').click(function(){
		
		var data_filter = $(this).attr('data-filter');
		
		$('[data-intro]').hide();
		$('[data-intro="'+data_filter+'"]').fadeIn();
	});
	
	$('.page-scroll').click(function(e){
		
		if(1==1/*pagina == 'home'*/){
			
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
	
	if(hash && hash != '' && pagina == 'home'){
		
		var add = ($(window).width() > 768)?($('.navbar-default').height()):(0);		
		
		$('html, body').animate({
	        scrollTop: $('#'+hash).offset().top - add
	    }, 700);
	}
	
	$('#carousel-banner').carousel({
	    interval: 7000
	});
	
	$('.no-interval').carousel({
	    interval: false
	});
		
	$('#carousel-equipe, #carousel-processos-1, #carousel-processos-2, #carousel-noticias, #carousel-noticia').carousel({
	    interval: false
	});
	
	$('#carousel-noticias').on('slid.bs.carousel', function () {
				
		$('[data-ellipsis]').each(function(){
		
			$(this).ellipsis({
				row: $(this).attr('data-ellipsis'),
				char: '...',
				onlyFullWords: true
			});
		});
	});
	
	
	$('.selectpicker').selectpicker();

	$('.tabs').tabs();
	$('.ui-tabs').tabs();
	
	/* V-ALIGN */
	$('.v-align').each(function(){
		
        $(this).children().wrapAll('<div class="wrap-v-align" style="position:relative;"></div>');
        var div = $(this).children('div.wrap-v-align');
        var ph = $(this).innerHeight();
        var dh = div.height();
        var mh = (ph - dh) / 2;
        div.css('top', mh);
	});	
	
	$('[data-toggle-trigger]').click(function(){
		
		var idTarget = $(this).attr('data-toggle-trigger');
		
		$('[data-toggle-target="'+idTarget+'"]').toggle('slide');
	});
	
	$('[data-slidetoggle-trigger]').click(function(){
		
		var idTarget = $(this).attr('data-slidetoggle-trigger');
		
		$('[data-slidetoggle-target="'+idTarget+'"]').slideToggle();
	});
	
	$('[data-fadetoggle-trigger]').click(function(){
		
		var idTarget = $(this).attr('data-fadetoggle-trigger');
		
		$('[data-fadetoggle-target="'+idTarget+'"]').fadeToggle(500);
	});
	
	$('[data-enable-trigger]').click(function(){
		
		var idEnable = $(this).attr('data-enable-trigger');
		
		$('[data-enable-target]').hide().attr('disabled','disabled');
		$('[data-enable-target]').find('*').removeAttr('required');
		$('[data-enable-target="'+idEnable+'"]').fadeIn().removeAttr('disabled');
		$('[data-enable-target="'+idEnable+'"]').find('*').attr('required','required');
	});
	
	$('[data-accordion-trigger]').click(function(){
		
		var opcao = $(this).attr('data-accordion-trigger');
		
	    $('[data-accordion-target]').slideUp();
	    $('[data-accordion-target="'+opcao+'"]').slideDown(function(){
	    
		    $('html, body').animate({
		        scrollTop: $('html').offset().top
		    }, 700);
	    });
	});
	
	$('.accordion-first').each(function(){
		
		$(this).accordion({
			header: '.header-accordion',
			active: false,
  			collapsible: true,
  			active: $('.accordion-first .index').index()
		});
	});
	
	$(window).on('load resize',function(){
				
		if($(window).width() < 768){
	
			/*$('.nav a').on('click', function(){
				
				$('.btn-navbar').click();
				$('.navbar-toggle').click();
			});	*/
		}
	});
	
	$('div[data-accordion="true"]').each(function(){
		
		$(this).accordion({
			header: '.header-accordion',
			active: false,
  			collapsible: true
		});
	});
	
	$('.accordion-first').each(function(){
		
		$(this).accordion({
			header: '.header-accordion',
			active: false,
  			collapsible: true,
  			active: $('.accordion-first .index').index()
		});
	});
	
	$('.format-table table').addClass('table').addClass('table-striped');
	
	if(pagina == 'institucional' && string[1] != ''){
		
		var opcao = string[1];
		
	    $('[data-accordion-target="'+opcao+'"]').show();
	}
		   
  	$('.var-carousel').each(function(){
		
		$(this).carousel({
			interval: false
		});
	});
	
	$('[data-ellipsis]').each(function(){
		
		$(this).ellipsis({
			row: $(this).attr('data-ellipsis'),
			char: '...',
			onlyFullWords: true
		});
	});
  	  
  	$('[data-toggle="popover"]').popover();
  	$('[data-toggle="popover"][data-timeout]').on('shown.bs.popover', function() {
	    this_popover = $(this);
	    setTimeout(function () {
	        this_popover.popover('hide');
	    }, $(this).data("timeout"));
	});
	
  	$('[data-toggle="tooltip"]').tooltip({ tooltipClass:'tooltip-class' }); 
  	
  	//$('.tooltip-montagem').tooltip({ tooltipClass:'tooltip-class', delay: { "show": 500, "hide": 100 } }).mouseover();
  	
  	$('.btn-slide-search').click(function(){
  		$('input[name=busca]').animate({width:'toggle'}, 500);
  	});
  		
  	/** CONSULTA CEP E CARREGA SELECTS **/
  	$('[data-id-cep]').blur(function(){
  		
  		var idCep = $(this).attr('data-id-cep');
  		var cep = $('[data-id-cep="'+idCep+'"]').val();
  		
		$.ajax({
			url: 'https://viacep.com.br/ws/'+cep+'/json/unicode/',
			dataType: 'json',
			success: function(resposta){
				
				$('[data-id-endereco="'+idCep+'"]').val(resposta.logradouro);
                $('[data-id-bairro="'+idCep+'"]').val(resposta.bairro);
                $('[data-id-cidade="'+idCep+'"]').val(resposta.localidade);
                $('[data-id-uf="'+idCep+'"]').val(resposta.uf);
                $('[data-id-numero="'+idCep+'"]').focus();
			}
		});
	});
  	   
	/** VALIDA CAMPOS REQUIRED DOS FORMS **/   
   	$('form').submit(function(e){
		$(this).find('input[required]:enabled').each(function(){
			if($(this).val() == ''){
				e.preventDefault();
			}
		});
	});
	
	$('.btn-exe').click(function(){
		
		var pendente = 0;
		
		$(this).closest('form').find('input[required]:enabled').each(function(){
			if($(this).val() == ''){
				
				pendente++;
			}
		});
		
		if(pendente == 0){
			
			$('.loader').fadeIn(100);
		}
	});
	
	$('.finaliza-compra').click(function(e){
		
		e.preventDefault();
		
		$('#form-finaliza-pedido').submit();
	});
   	
   	/** SELECAO DE FRETE **/
   	$('.radio-frete').click(function(){
		
		if($(this).val() == 'pac'){
			
			$('.total-pac').show();
			$('.total-sedex').hide();
		}else if($(this).val() == 'sedex'){
			
			$('.total-pac').hide();
			$('.total-sedex').show();
		}else if($(this).val() == 'transportadora'){
			
			$('.total-retirar').hide();
			$('.total-transportadora').show();
		}else if($(this).val() == 'retirar'){
			
			$('.total-transportadora').hide();
			$('.total-retirar').show();
		}
		
		var element = $(this);
		var opcao = element.val();
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'frete_ajax',
			data: {
				opcao: opcao
			}
		});
	});
   
	/** ATUALIZA QUANTIDADE **/
	$('.atualiza-quantidade').change(function(){
		
		$('.loader').fadeIn(100);
		$(this).closest('form').submit();
	});
   
	/** MARCA MONTAGEM **/
	$('.marca-montagem').change(function(){
		
		$('.loader').fadeIn(100);
		$(this).closest('form').submit();
	});
   
	/** MARCA DESMONTAGEM **/
	$('.marca-desmontagem').change(function(){

		$('.loader').fadeIn(100);
		$(this).closest('form').submit();
	});
   
	/** REMOVE CARRINHO **/
	$('.remove-carrinho').click(function(){

		$('.loader').fadeIn(100);
		$('.form-remove-carrinho').submit();
	});
   
   /** BLOQUEIA TECLA ENTER **/
   $('.form-prevent input').keydown(function(e){
		
	    if(e.keyCode == 13){
	    	
	      e.preventDefault();
	      
	      return false;
	    }
	});
	
	$('.input-upper').on('focusout keyup', function(){
		
		var dado = $(this).val();
		dado = dado.toUpperCase();
        $(this).val(dado);
	});
	
	/** VERIFICA SE E-MAIL JÁ ESTÁ CADASTRADO **/
	$('.form-insert input[type=email]').on('focusout keypress keyup', function(){
			
		var email = $(this).val();
		var alt = $(this).attr('alt');
		
		if(email != '' && validaEmail(email)){
			
			$.ajax({
	 	
				type: "POST",
				url: urlC+'valida_email_ajax',
				data: {
					email: 	email,
					alt:	alt
				},
			    success: function(data){
			    	
			    	var retorno = null;
			    	
			    	if(data == 1){
						
						$('.form-insert input[type=email]').css({'border-color':'#ff4444', 'background-color':'#ffc6c6', 'color':'#ff4444'});
						$('.form-insert input[type=email]').attr('title','E-mail já cadastrado!');
						$('.form-insert [type=submit]').css({'cursor':'not-allowed'});
						$('.form-insert [type=submit]').attr('disabled','disabled');
					}else{
						
						$('.form-insert input[type=email]').css({'border-color':'#44c45e', 'background-color':'#d0f0d7', 'color':'#000'});
						$('.form-insert input[type=email]').attr('title','E-mail disponível!');
						$('.form-insert [type=submit]').css({'cursor':'pointer'});
						$('.form-insert [type=submit]').removeAttr('disabled');
					}
			    }
			});
		}else{
			
			$('.form-insert input[type=email]').removeAttr('style');
			$('.form-insert input[type=email]').removeAttr('title');
			$('.form-insert [type=submit]').removeAttr('style');
			$('.form-insert [type=submit]').removeAttr('disabled');
		}
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
	
	$('.codigo-cupom').blur(function(){
		
		var codigo = $(this).val();
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'cupom_ajax',
			data: {
				codigo: codigo
			},
		    success: function(data){
				
				$('.label-cupom').hide();
				$('.label-cupom').fadeIn();
				$('.label-cupom').html(data);
		    },
			beforeSend: function(){
				$('.loader').fadeIn(100);
			},
			complete: function(){
				$('.loader').fadeOut(100);
			}
		});
	});
	
	$('.colorselector').each(function(){
			
		$(this).colorselector({
	          callback: function(value, color, title){
	              $('.btn-colorselector').html(title);
	          }
	    });
	});
	
	$('.btn-colorselector').html($('.colorselector option:selected').html());
		
	
	$('.add-trigger').click(function(e){
		
		if($(this).closest('form').find('input[name=id_rel_produto_var]').val() == ''){
			
			alert('Selecione as opções do produto!');
			
			/*$(this).popover({ placement: 'top', content: 'Selecione as opções do produto!' }).popover('show');
			setTimeout(function () {
		        $('*').popover('destroy');
		    }, 3000);
			e.preventDefault();*/
		}
	});
	
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

function match_height(){
	
	setTimeout(function(){
		
		var cont = 0; 
		var matches = new Array();
		
		$('[data-height]').each(function(){
			
			matches[cont] = $(this).attr('data-height');
			cont++; 
		});
		
		var unicos = $.unique(matches);
		
		for(i = 0; i < unicos.length; i++){
			
			var cont2 = 0;
			var valores = new Array();
			
			$('[data-height="'+unicos[i]+'"]').each(function(){
			
				valores[cont2] = $(this).height();
				cont2++;			
			});
			
			var maximo = Math.max(...valores);
			
			$('[data-height="'+unicos[i]+'"]').height(maximo);
		}
	}, 1000);
	
}

match_height();

$(window).on('load resize',function(){
	
});

$(window).scroll(function(){
	
});


$(window).load(function(){ 
	            
    
});