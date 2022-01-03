
<style>
figcaption{ height: 40px; }
.btn-no-cursor{ cursor: default; }
</style>

<?php $retorno = $_POST['retorno']; ?>

<?php $url_img = 'https://stc.pagseguro.uol.com.br'; ?>

<form method="post" class="form-prevent form-pagamento form-checkout">
	<?php if(1==2){ ?>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
			<div class="form-group">
				<select class="form-control select-metodos" required>
					<option value="">...selecione a forma de pagamento</option>
					<?php foreach($retorno['paymentMethods'] as $var => $metodo){ ?>
						
						<?php if($var == 'CREDIT_CARD'){ ?>
							
							<option value="credito">Cartão de Crédito</option>
						<?php }elseif($var == 'BOLETO'){ ?>
						
							<option value="boleto">Boleto Bancário</option>
						<?php }elseif($var == 'ONLINE_DEBIT'){ ?>
									
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
	<br/>
	<?php } ?>

	<?php foreach($retorno['paymentMethods'] as $var => $metodo){ ?>
					
		<?php if(1==2 /*$var == 'BOLETO'*/){ ?>
			
			<div class="row display-none" data-metodo="boleto">
				<div class="col-xs-12">
					<h5 class="text-uppercase">Clique no botão abaixo para gerar o Boleto de Pagamento:</h5>
					<br/>
				</div>
				<?php foreach($metodo['options'] as $var2 => $opcao){ ?>
					<div class="col-xs-6 col-sm-2">
						<div class="pull-left text-center">
							<figure>
								<img src="<?php echo $url_img.$opcao['images']['MEDIUM']['path']; ?>"/>
								<figcaption class="text-center"><?php echo $opcao['displayName']; ?></figcaption>
							</figure>
							<br/>
							<button type="button" class="btn btn-success btn-sm text-center text-uppercase btn-payment" data-post-metodo="boleto" data-forma-pagamento="Boleto Bancário">Gerar Boleto</button>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php }elseif(1==2 /*$var == 'ONLINE_DEBIT'*/){ ?>
			
			<div class="row display-none" data-metodo="debito">
				<div class="col-xs-12">
					<h5 class="text-uppercase">Selecione abaixo o seu banco para Débito Online:</h5>
					<br/>
				</div>
				<?php foreach($metodo['options'] as $var2 => $opcao){ ?>
					<?php
					switch($var2){
						case 'BANCO_BRASIL'	: $banco = 'bancodobrasil'; break;
						case 'BANRISUL'		: $banco = 'banrisul'; 		break;
						case 'BRADESCO'		: $banco = 'bradesco'; 		break;
						case 'HSBC'			: $banco = 'hsbc'; 			break;
						case 'ITAU'			: $banco = 'itau'; 			break;
					}
					?>
					<div class="col-xs-4 col-sm-2">
						<div class="pull-left text-center" data-mh="item-pagamento">
							<figure>
								<img src="<?php echo $url_img.$opcao['images']['MEDIUM']['path']; ?>"/>
								<figcaption class="text-center"><?php echo $opcao['displayName']; ?></figcaption>
							</figure>
							<br/>
							<button type="button" class="btn btn-success btn-sm text-center text-uppercase btn-payment" data-bank="<?php echo $banco; ?>" data-post-metodo="eft" data-forma-pagamento="Débito Online">Selecionar</button>
							<div class="clearfix"></div>
							<br/><br/>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php }elseif($var == 'CREDIT_CARD'){ ?>
			
			<input type="hidden" name="tipo_pagamento" value="credito"/>
			<input type="hidden" name="forma_pagamento" value="Cartão de Crédito"/>
			<div class="row" data-metodo="credito">
				<div class="col-xs-12">
					<div class="row">
						<div class="col-xs-12">	
							<hr class="hr-default"/>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h5 class="text-uppercase">Informe abaixo os dados do seu Cartão de Crédito:</h5>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<label for="cardNumber">Número do Cartão de Crédito:</label>
										<input type="text" class="form-control cardNumber" name="cardNumber" data-brand="" required/>
									</div>
								</div>
								<fieldset class="dados-cartao">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="creditCardHolderName">Nome (como está impresso no Cartão):</label>
											<input type="text" class="form-control" name="creditCardHolderName" required/>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5">
							<div class="row">
								<fieldset class="dados-cartao">
									<div class="col-xs-12 form-inline">
										<label for="creditCardHolderName">Válidade do Cartão (formato: mm/aaaa):</label><br/>
										<div class="form-group" style="margin-bottom: 15px;">
											<select class="form-control" name="expirationMonth" required>
												<option value=""></option>
												<?php for($i = 1; $i <= 12; $i++){ ?>
													<option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></option>
												<?php } ?>
											</select>
											<select class="form-control" name="expirationYear" required>
												<option value=""></option>
												<?php for($i = date('Y'); $i <= (date('Y') + 20); $i++){ ?>
													<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label for="cvv">Código de Segurança <small>(geralmente encontrado atrás do Cartão)</small></label>
											<input type="text" class="form-control" name="cvv" required/>
										</div>
									</div>	
								</fieldset>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-xs-12">
							<button type="button" class="btn btn-info btn-sm btn-validar-cartao">Validar dados</button>
							<br/>
						</div>
					</div>
				</div>
				<div class="col-xs-12 parcelamento-cartao"></div>
				<div class="clearfix"></div>
				<br/>
				<div class="row">
					<div class="col-xs-12">	
						<hr class="hr-default"/>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h5 class="text-uppercase">Você pode pagar com:</h5>
					</div>
				</div>
				<br/>
				<div class="col-xs-12">
					<div class="row">
						<?php foreach($metodo['options'] as $var2 => $opcao){ ?>
							<div class="col-xs-4 col-sm-2">
								<div class="pull-left text-center" data-mh="item-pagamento">
									<figure>
										<img src="<?php echo $url_img.$opcao['images']['MEDIUM']['path']; ?>"/>
										<figcaption class="text-center"><?php echo $opcao['displayName']; ?></figcaption>
									</figure>
									<div class="clearfix"></div>
									<br/>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
</form>

<script>
	$('.select-metodos').change(function(){
		
		var metodo = $('option:selected', this).val();
		
		$('.area-pagamento').empty();
		$('.btn-payment').removeAttr('disabled');
		$('[data-metodo]').hide();
		$('[data-metodo='+metodo+']').fadeIn();
	});
	
	$('.btn-payment').click(function(){
		
		var senderHash 		= PagSeguroDirectPayment.getSenderHash();
		var paymentMethod 	= $(this).attr('data-post-metodo');
		var bankName 		= $(this).attr('data-bank');
		var forma_pagamento	= $(this).attr('data-forma-pagamento');
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				
		$.ajax({
			type: 'POST',
			url: urlC+'checkout_ajax',
			data: {
				senderHash: senderHash,
				paymentMethod: paymentMethod,
				bankName: bankName,
				forma_pagamento: forma_pagamento
			},
		    success: function(data){
				$('.area-pagamento').html(data);
		    },
			beforeSend: function(){
				$('.loader').fadeIn(100);
			},
			complete: function(){
				$('.loader').fadeOut(100);
			}
		});	
	});
	
	$('input.cardNumber').blur(function(){
		
		PagSeguroDirectPayment.getBrand({
			cardBin: $(this).val(),
			success:function(response){
				
				var bandeira = response.brand.name;
				
				$('input.cardNumber').css({'background':'url(https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/'+bandeira+'.png) no-repeat 97% center'});
				$('.cardNumber').attr('data-brand', bandeira);
			},
			error:function(response){
				//tratamento do erro
			},
			complete:function(response){
				//tratamento comum para todas chamadas
			}
		});
	});
	
	$('[name="cardNumber"]').change(function(){
		
		$('.parcelamento-cartao').empty();
		$('fieldset.dados-cartao select, fieldset.dados-cartao input').val('');
	});
	
	$('fieldset.dados-cartao select, fieldset.dados-cartao input').change(function(){
		
		$('.parcelamento-cartao').empty();
	});
	
	$('.btn-validar-cartao').click(function(e){
		
		e.preventDefault();
		
		var fields = $('fieldset.dados-cartao select, fieldset.dados-cartao input');
		var emptyFields = false;
		
	    for(var i = 0; i < fields.length; i++){
	        if($(fields[i]).val() == ''){
				emptyFields = true;
	        }
	    }
	    
	    if(emptyFields === false){
			
			PagSeguroDirectPayment.createCardToken({
				cardNumber: $('[name="cardNumber"]').val(),
				brand: $('[name="cardNumber"]').attr('data-brand'),
				cvv: $('[name="cvv"]').val(),
				expirationMonth: $('[name="expirationMonth"] option:selected').val(),
				expirationYear: $('[name="expirationYear"] option:selected').val(),
				success:function(response){
					getInstallments(response.card.token);
				},
				error:function(response){
					//tratamento do erro
				},
				complete:function(response){
					if($.isEmptyObject(response.card)){							
						alert('Não pudemos validar os dados do seu Cartão de Crédito! Por favor, verifique se digitou os dados corretamente.');
					}
				}
			});
		}else{
			
			alert('preencha os dados do cartão corretamente!');
		}
	});
	
	function getInstallments(token){
				
		PagSeguroDirectPayment.getInstallments({
			amount: "<?php echo $_SESSION['valor_total'] ?>",
			brand: $('[name="cardNumber"]').attr('data-brand'),
			maxInstallmentNoInterest: "<?php echo $_SESSION['max_sem_juros'] ?>",
			success:function(response){
				
				var dir 	= window.location.href.split('/');
				var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				
				$.ajax({
					type: 'POST',
					url: urlC+'checkout_parcelamento_ajax',
					data: {
						retorno: response,
						token: token
					},
				    success: function(data){
						$('.parcelamento-cartao').html(data);
				    },
					beforeSend: function(){
						$('.loader').fadeIn(100);
					},
					complete: function(){
						$('.loader').fadeOut(100);
					}
				});
			},
			error:function(response){
				//tratamento do erro
			},
			complete:function(response){
				//tratamento comum para todas chamadas
			}
		});				
	}
</script>

