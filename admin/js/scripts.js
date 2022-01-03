
$(document).on('click', '.ponto', function(){
	
	$(this).remove();
	$('[name="pontos"]').html($('.pontos').html());
});

$(document).on('click', '.confirm', function(e){
		
	e.preventDefault();
	
	var elemento = $(this);
	
	$.confirm({
	    title: '',
	    content: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<b>'+elemento.attr('data-title')+'</b>',
	    buttons: {
	        confirm: {
	        	btnClass: 'btn-primary btn-sm',
	        	text: 'Sim',
		        action: function () {
		            elemento.closest('form').submit();
		        }
	        },
	        cancel: {
				btnClass: 'btn-danger btn-sm',	
				text: 'Não',
		        action: function () {
		            
		        }
			}
	    }
	});
});

$(document).on('click', '.confirmar', function(e){
		
	e.preventDefault();
	
	var elemento = $(this);
	
	$.confirm({
	    title: '',
	    content: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<b>'+elemento.attr('data-title')+'</b>',
	    buttons: {
	        confirm: {
	        	btnClass: 'btn-primary btn-sm',
	        	text: 'Sim',
		        action: function () {
		            window.location.href = elemento.attr('data-href');
		        }
	        },
	        cancel: {
				btnClass: 'btn-danger btn-sm',	
				text: 'Não',
		        action: function () {
		            
		        }
			}
	    }
	});
});

$(document).ready(function(){
	
	/** VARIAVEIS DE URL **/
	var urlHashStrip 	= window.location.href;
	var stringHash 		= urlHashStrip.split('#');
	var stringStrip 	= stringHash[0].split('/');
	var pagina 			= stringStrip[4];/**/
	var subpagina 		= stringStrip[4];
	var parametro		= stringHash[1];
	var dir 			= window.location.href.split('/');
	var urlC 			= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/admin/'):(location.protocol+'//'+document.domain+'/admin/');
	
	$('.bg-cover img, .bg-contain img').each(function(){
		
		var src = $(this).attr('src');
		
		$(this).hide();
		$(this).parent().css({ 'background-image': 'url('+src+')' });
	});
	
	$('.input-upper').on('focusout keyup', function(){
		
		var dado = $(this).val();
		dado = dado.toUpperCase();
        $(this).val(dado);
	});
	
	$('[data-toggle="tooltip"]').tooltip({
				
		delay: {show: 200, hide: 200}
	}); 
	
	$('.imagem-interativa img').click(function(e){
		
		var element = $(this);
		var parent 	= $(this).parent('figure');
		
		var posX 	= parent.offset().left;
        var posY 	= parent.offset().top;
		var posLeft = e.pageX - posX;
		var posTop 	= e.pageY - posY;
		
		var percentX 	= posLeft / element.width() * 100;
		var percentY	= posTop / element.height() * 100;
		
		$('.pontos').append('<span class="ponto" style="left: '+percentX+'%; top: '+percentY+'%;"></span>');
		
		$('[name="pontos"]').html($('.pontos').html());
	});
	
	$('.fancybox').fancybox();
	
	$('.chosen-select').chosen();
	
	$('[data-video]').click(function(){
		
		var dado = $(this).attr('data-video');
		
		$('.area-video').html('<iframe src="'+dado+'" frameborder="0" allowfullscreen class="video-embed"></iframe>');
	});
		
	$('.btn-preview').click(function(){
		
		for ( instance in CKEDITOR.instances ){
			
    		CKEDITOR.instances[instance].updateElement();
		}
		
		$.ajax({
			 	
			type: "POST",
			url: urlC+'session_ajax',
			data: $('.form-session').serialize(),
		    success: function(data){
				
		    }
		});
	});
	
	/* DATA TABLE */
	$('.datatable').each(function(){
		
		$(this).on('page.dt', function(){
				
				setTimeout(function(){
					
					$('[data-toggle="confirmation"]').confirmation({
						title: 'Tem certeza?',
						singleton: true,
						popout: true,
						btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
						btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
						btnOkClass: 'btn-primary',
						btnCancelClass: 'btn-danger',
						placement: 'left',
						onConfirm: function(){
							$(this).closest('form').submit();
						}
					});
					
					$('.btn-file-gallery :file').filestyle({
						buttonText : ''
					});
					
					$('.btn-file-lg :file').filestyle({
						buttonText : ' Arquivo...'
					});
					
					$('.btn-file-sm :file').filestyle({
						buttonText : '&nbsp;Arquivo...',
						size : 'sm'
					});
					
					$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
						console.log(numFiles);
						console.log(label);
					});
				}, 500);
			}).DataTable({
			ordering: false,
	        'pageLength': (typeof $(this).data('rows') !== 'undefined')?($(this).data('rows')):(10),
	        'sDom':'<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>'
		});
	});
	
	$('.datatable-ordering').each(function(){
		
		$(this).on('page.dt', function(){
				
				setTimeout(function(){
					
					$('[data-toggle="confirmation"]').confirmation({
						title: 'Tem certeza?',
						singleton: true,
						popout: true,
						btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
						btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
						btnOkClass: 'btn-primary',
						btnCancelClass: 'btn-danger',
						placement: 'left',
						onConfirm: function(){
							$(this).closest('form').submit();
						}
					});
					
					$('.btn-file-gallery :file').filestyle({
						buttonText : ''
					});
					
					$('.btn-file-lg :file').filestyle({
						buttonText : ' Arquivo...'
					});
					
					$('.btn-file-sm :file').filestyle({
						buttonText : '&nbsp;Arquivo...',
						size : 'sm'
					});
					
					$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
						console.log(numFiles);
						console.log(label);
					});
				}, 500);
			}).DataTable({
	        'sDom':'<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>'
		});
	});
	
	$('span[data-active]').each(function(){
		
		var dado = $(this).attr('data-active');
		
		$('li[data-active="'+dado+'"]').addClass('active');
	});
	
	$('.datatable-reorder').each(function(){
		
		$(this).on('page.dt', function(){
				
				setTimeout(function(){
					
					$('[data-toggle="confirmation"]').confirmation({
						title: 'Tem certeza?',
						singleton: true,
						popout: true,
						btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
						btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
						btnOkClass: 'btn-primary',
						btnCancelClass: 'btn-danger',
						placement: 'left',
						onConfirm: function(){
							$(this).closest('form').submit();
						}
					});
					
					$('.btn-file-gallery :file').filestyle({
						buttonText : ''
					});
					
					$('.btn-file-lg :file').filestyle({
						buttonText : ' Arquivo...'
					});
					
					$('.btn-file-sm :file').filestyle({
						buttonText : '&nbsp;Arquivo...',
						size : 'sm'
					});
					
					$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
						console.log(numFiles);
						console.log(label);
					});
				}, 500);
			}).DataTable({
			rowReorder: true,
	        'sDom':'<"col-xs-12"f><"col-xs-12"p>t<"col-xs-12"l><"col-xs-12"i><"col-xs-12"p>',
	        'order': [[ 0, 'desc']],
	        'pageLength': (typeof $(this).data('rows') !== 'undefined')?($(this).data('rows')):(10),
	        columnDefs: [
	            { orderable: true, className: 'reorder', targets: 0 },
	            { orderable: false, targets: '_all' }
	        ]
		});
	});
	
	/* DATA TABLE - REORDER AND AJAX */
	$('.reorder').click(function(e){
		e.preventDefault();
	});
	
	$('.btn-reorder').click(function(){
		
		var element = $(this);
		var this_html = element.html();
		var table = element.attr('data-table');
		var array_id = [];
		var array_ordem = [];
		var count = 0;
		
		element.html('Salvando...').removeClass('btn-warning').addClass('btn-default').attr('disabled','disabled');
		
		$('.datatable-reorder tr td[data-reorder-id]').each(function(){
			
			array_id[count] = $(this).attr('data-reorder-id');
			array_ordem[count] = $(this).html();
			count++;
		});
		
		$.ajax({
		 	
			type: "POST",
			url: urlC+'reorder_ajax',
			data: {
				table: table,
				array_id: array_id,
				array_ordem: array_ordem
			},
		    success: function(data){
				
				setTimeout(function(){
					
					element.html(this_html).removeClass('btn-default').addClass('btn-warning').removeAttr('disabled');
				}, 2000);
		    }
		});
	});
	
	/*$('.paginate_button').click(function(){
		
		$('[data-toggle="confirmation"]').confirmation({
			title: 'Tem certeza?',
			singleton: true,
			popout: true,
			btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
			btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
			btnOkClass: 'btn-primary',
			btnCancelClass: 'btn-danger',
			placement: 'left',
			onConfirm: function(){
				$(this).closest('form').submit();
			}
		});
	});*/
	
	var roxyFileman = '/fileman/index.html';
		
	$('textarea:not(.full-editor):not(.textarea-table)').each(function(){		
	
		CKEDITOR.replace( this, {
			enterMode: CKEDITOR.ENTER_P,
			extraPlugins: 'uploadimage,image2,youtube,colorbutton,font,justify,colordialog',
			removePlugins: 'stylescombo,format',
			height: 300,

			stylesSet: [
				{ name: 'Narrow image', type: 'widget', widget: 'image', attributes: { 'class': 'image-narrow' } },
				{ name: 'Wide image', type: 'widget', widget: 'image', attributes: { 'class': 'image-wide' } }
			],

			contentsCss: [ CKEDITOR.basePath + 'contents.css', CKEDITOR.basePath + '../../assets/css/widgetstyles.css' ],

			image2_alignClasses: [ 'image-align-left', 'image-align-center', 'image-align-right' ],
			image2_disableResizer: true,
			
			removeButtons: 'Maximize,ShowBlocks,About,Styles,Format,Youtube,Flash,Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,PasteText,PasteFromWord,Paste,Replace,Find,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Superscript,Subscript,Strike,Outdent,Indent,CreateDiv,Blockquote,BidiLtr,BidiRtl,Language,Anchor,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Scayt',
			
			filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload'
		} );
		
		$(this).after('<label class="editor_aviso">Após inserir o texto no editor, selecione-o novamente (ctrl+a) e aperte no icone <div class="cke_button__removeformat"><span style="background-image:url('+CKEDITOR.basePath+'plugins/icons.png?t=F7J9);background-position:0 -1680px;background-size:auto;float:none;" class="cke_button_icon cke_button__removeformat_icon">&nbsp;</span></div> para remover a formatação externa, então, após feito isso, faça a formatação desejada no texto.<label>');
	});
		
	$('textarea.full-editor').each(function(){		
	
		CKEDITOR.replace( this, {
			enterMode: CKEDITOR.ENTER_P,
			extraPlugins: 'uploadimage,image2,youtube,colorbutton,font,justify,colordialog',
			removePlugins: 'stylescombo,format',
			height: 300,

			stylesSet: [
				{ name: 'Narrow image', type: 'widget', widget: 'image', attributes: { 'class': 'image-narrow' } },
				{ name: 'Wide image', type: 'widget', widget: 'image', attributes: { 'class': 'image-wide' } }
			],

			contentsCss: [ CKEDITOR.basePath + 'contents.css', CKEDITOR.basePath + '../../assets/css/widgetstyles.css' ],

			image2_alignClasses: [ 'image-align-left', 'image-align-center', 'image-align-right' ],
			image2_disableResizer: true,
			
			filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload'
		} );
		
		$(this).after('<label class="editor_aviso">Após inserir o texto no editor, selecione-o novamente (ctrl+a) e aperte no icone <div class="cke_button__removeformat"><span style="background-image:url('+CKEDITOR.basePath+'plugins/icons.png?t=F7J9);background-position:0 -1680px;background-size:auto;float:none;" class="cke_button_icon cke_button__removeformat_icon">&nbsp;</span></div> para remover a formatação externa, então, após feito isso, faça a formatação desejada no texto.<label>');
	});
	
	$('.textarea-table').each(function(){
		
		CKEDITOR.replace(this, {
			extraPlugins: 'colorbutton,font,colordialog',
			height: 400,
			contentsCss: 'body {font-size: 11px; font-family: Arial}',
			removeButtons: 'Maximize,ShowBlocks,About,Styles,Format,Youtube,Flash,Source,Save,NewPage,Preview,Print,Templates,Cut,Copy,PasteText,PasteFromWord,Paste,Replace,Find,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Superscript,Subscript,Strike,Outdent,Indent,CreateDiv,Blockquote,BidiLtr,BidiRtl,Language,Anchor,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Scayt,Bold,Italic,Underline,NumberedList,BulletedList,Image,Link,Unlink'
		});
		
		$(this).after('<label class="editor_aviso"><b>ATENÇÃO! </b>Não é necessário formatar o visual da tabela! Basta inserir os dados e ela será formatada automaticamente no site.<br/>Obs.: Utilize sempre apenas 2 colunas na tabela. O número de linhas é livre.');
	});
	
	$('[data-toggle="confirmation"]').confirmation({
		title: 'Tem certeza?',
		singleton: true,
		popout: true,
		btnOkLabel: '<i class="fa fa-check-circle" style="color: #fff;"></i> Sim',
		btnCancelLabel: '<i class="fa fa-times-circle" style="color: #fff;"></i> Não',
		btnOkClass: 'btn-primary',
		btnCancelClass: 'btn-danger',
		placement: 'left',
		onConfirm: function(){
			$(this).closest('form').submit();
		}
	});
	
	$('.btn-file-gallery :file').filestyle({
		buttonText : ''
	});
	
	$('.btn-file-lg :file').filestyle({
		buttonText : ' Arquivo...'
	});
	
	$('.btn-file-sm :file').filestyle({
		buttonText : '&nbsp;Arquivo...',
		size : 'sm'
	});
	
	$('.btn-files :file').filestyle({
		buttonText : '&nbsp;Arquivos...',
		size : 'sm'
	});
	
	$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		console.log(numFiles);
		console.log(label);
	});
	
	$('[role="iconpicker"]').iconpicker({
		align: 'center',
		cols: 5,
		rows: 5,
		labelHeader: '&nbsp;Selecione um ícone!&nbsp;',
		placement: 'bottom',
        hideOnSelect: true,
        search: false,
    	iconset: 'fontawesome',
    	selectedClass: 'btn-success'     
    }).on('change', function(e) { 
		
		$(this).closest('.form-group').find('[data-target-icp]').val(e.icon);
	});
	
	$('.lista-item a img').each(function(){
		var src = $(this).attr('src');
		$(this).closest('a').css({
			'background-image':'url('+src+')',
			'background-repeat':'no-repeat',
			'background-position':'center center',
			'background-size':'contain',
			'background-color':'#ffffff'
		});
	});
	
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
					$('.chosen-select').trigger('chosen:updated');
					$('.cidade-select').hide();
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
	
	$('[data-select="fieldset"]').change(function(){
		
		var valor = $(this).val();
		
		if(valor == 't'){
			
			$('[data-select-target="fieldset"]').slideUp();
			$('[data-select-target="fieldset"]').attr('disabled','disabled');
		}else{
			
			$('[data-select-target="fieldset"]').slideDown();
			$('[data-select-target="fieldset"]').removeAttr('disabled');
		}
		
		cidade_estado_ajax(uf);	
	});
	
	/** CONSULTA CEP E CARREGA SELECTS **/
  	$('[data-cep]').blur(function(){
  	
       var idCep = $(this).attr('data-cep'); 
       
       $.ajax({
            url : urlC+'includes/consultar_cep.php',
            type : 'POST',
            data: 'cep='+$('[data-cep="'+idCep+'"]').val(),
            dataType: 'json',
            success: function(data){
            	
                if(data.sucesso == 1){
                	
                    $('[data-endereco="'+idCep+'"]').val(data.endereco);
                    $('[data-bairro="'+idCep+'"]').val(data.bairro);
                    $('[data-cidade="'+idCep+'"]').val(data.cidade);
                    $('[data-uf="'+idCep+'"]').val(data.estado);

                    $('[data-numero="'+idCep+'"]').focus();
                }
            }
       	});   
   		return false;    
   });
});

$(document).on('change', '.btn-file :file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});