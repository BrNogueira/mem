
<?php
$parcelamento 	= $_POST['retorno'];
$token 			= $_POST['token'];
?>

<?php if($parcelamento['error'] == 'false'){ ?>
	
	<br/>
	<div class="row">
		<div class="col-xs-12">	
			<hr class="hr-default"/>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h5 class="text-uppercase">Parcelamento:</h5>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-5">
			<div class="form-group">
				<label for="cardNumber">Escolha uma forma de parcelamento:</label>
				<select class="form-control select-parcelamento" required>
					<option value="">...selecione a quantidade de parcelas</option>
					<?php foreach($parcelamento['installments'] as $var => $item_parcelamento){ ?>
						<?php foreach($item_parcelamento as $var2 => $parcelas){ ?>
							<?php $sem_juros = ($parcelas['interestFree'] == 'true')?('s/ juros'):('c/ juros'); ?>
							<option value="credito" data-quantity="<?php echo $parcelas['quantity']; ?>" data-totalAmount="<?php echo $parcelas['totalAmount']; ?>" data-fixTotalAmount="<?php echo 'R$ '.Util::fixValor($parcelas['totalAmount']); ?>" data-installmentAmount="<?php echo $parcelas['installmentAmount']; ?>">
								<?php echo $parcelas['quantity'].'x de R$ '.Util::fixValor($parcelas['installmentAmount']).' '.$sem_juros; ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-xs-12">
			<big class="totalAmount"></big>
		</div>
		<div class="col-xs-12">
			<br/>
			<h5 class="text-uppercase">
				Os dados para cobrança são os mesmos do seu cadastro?<br/>
				<small>Confira abaixo e caso necessário informe os dados atualizados:</small>
			</h5>
		</div>
		<div class="col-xs-12 col-md-10 dados-cartao">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label for="titular_cpf">CPF do Titular:</label>
						<input type="text" name="creditCardHolderCPF" class="form-control cpf-mask" value="<?php echo $_SESSION['cliente_dados']['cpf']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_nascimento">Data de Nascimento do Titular:</label>
						<input type="text" name="creditCardHolderBirthDate" class="form-control data-mask" value="<?php echo Util::fixData($_SESSION['cliente_dados']['nascimento']); ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_telefone">Telefone do Titular:</label>
						<input type="tel" name="holderPhone" class="form-control fone-mask" value="<?php echo $_SESSION['cliente_dados']['telefone_contato']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_telefone">UF de Cobrança:</label>
						<input type="tel" name="billingAddressState" class="form-control uf-mask" value="<?php echo $_SESSION['cliente_dados']['uf']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_telefone">Cidade de Cobrança:</label>
						<input type="tel" name="billingAddressCity" class="form-control" value="<?php echo $_SESSION['cliente_dados']['cidade']; ?>" required>
					</div>     
				</div>
				<div class="col-xs-12 col-sm-6">
					<div class="form-group">
						<label for="titular_cep">CEP de Cobrança:</label>
						<input type="text" name="billingAddressPostalCode" data-id-cep="0" class="form-control cep-mask" value="<?php echo $_SESSION['cliente_dados']['cep']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_endereco">Endereço de Cobrança:</label>
						<input type="text" name="billingAddressStreet" data-id-endereco="0" class="form-control" value="<?php echo $_SESSION['cliente_dados']['endereco']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_bairro">Bairro de Cobrança:</label>
						<input type="text" name="billingAddressDistrict" data-id-bairro="0" class="form-control" value="<?php echo $_SESSION['cliente_dados']['bairro']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_numero">Número de Cobrança:</label>
						<input type="text" name="billingAddressNumber" data-id-numero="0" class="form-control" value="<?php echo $_SESSION['cliente_dados']['numero']; ?>" required>
					</div>
					<div class="form-group">
						<label for="titular_complemento">Complemento de Cobrança:</label>
						<input type="text" name="billingAddressComplement" class="form-control" value="<?php echo $_SESSION['cliente_dados']['complemento']; ?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<br/>
			<button type="submit" class="btn btn-success btn-credit-payment display-none" data-post-metodo="creditCard">PAGAR</button>
		</div>
	</div>
<?php } ?>

<script>
	
	var dir	= window.location.href.split('/');
	var urlC = (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
	
	$('.select-parcelamento').change(function(){
		
		if($('option:selected', this).val() != ''){
			
			var totalAmount = $('option:selected', this).attr('data-fixTotalAmount');
			
			labelTotalAmount = '<div class="btn btn-primary btn-no-cursor"><b>TOTAL:</b> '+totalAmount+'</div>';
			
			$('.totalAmount').html(labelTotalAmount).effect( "pulsate", {times:3}, 300 );
			$('.btn-credit-payment').fadeIn().removeAttr('disabled');
		}else{
			
			$('.btn-credit-payment').fadeOut().attr('disabled', 'disabled');
		}
	});
	
	/*$('.btn-credit-payment').click(function(){*/
	$('.form-checkout').submit(function(e){
		
		e.preventDefault();
		
		var senderHash 		= PagSeguroDirectPayment.getSenderHash();
		var paymentMethod 	= $(this).find('.btn-credit-payment').attr('data-post-metodo');
		var token 			= "<?php echo $token ?>";
		var forma_pagamento	= $('[name="forma_pagamento"]').val();
		var tipo_pagamento	= $('[name="tipo_pagamento"]').val();
		
		var installmentQuantity 		= $('.select-parcelamento option:selected').attr('data-quantity');
		var installmentValue 			= $('.select-parcelamento option:selected').attr('data-installmentAmount');
		var totalAmount 				= $('.select-parcelamento option:selected').attr('data-totalAmount');
		var creditCardHolderName 		= $('[name="creditCardHolderName"]').val();
		var creditCardHolderCPF 		= $('[name="creditCardHolderCPF"]').val();
		var creditCardHolderBirthDate 	= $('[name="creditCardHolderBirthDate"]').val();
		var holderPhone 				= $('[name="holderPhone"]').val();
		var billingAddressStreet 		= $('[name="billingAddressStreet"]').val();
		var billingAddressNumber 		= $('[name="billingAddressNumber"]').val();
		var billingAddressComplement 	= $('[name="billingAddressComplement"]').val();
		var billingAddressDistrict 		= $('[name="billingAddressDistrict"]').val();
		var billingAddressPostalCode 	= $('[name="billingAddressPostalCode"]').val();
		var billingAddressCity 			= $('[name="billingAddressCity"]').val();
		var billingAddressState 		= $('[name="billingAddressState"]').val();
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				
		$.ajax({
			type: 'POST',
			url: urlC+'checkout_ajax',
			data: {
				senderHash: senderHash,
				paymentMethod: paymentMethod,
				token: token,
				tipo_pagamento: tipo_pagamento,
				forma_pagamento: forma_pagamento,
				installmentQuantity: installmentQuantity,
				installmentValue: installmentValue,
				totalAmount: totalAmount,
				creditCardHolderName: creditCardHolderName,
				creditCardHolderCPF: creditCardHolderCPF,
				creditCardHolderBirthDate: creditCardHolderBirthDate,
				holderPhone: holderPhone,
				billingAddressStreet: billingAddressStreet,
				billingAddressNumber: billingAddressNumber,
				billingAddressComplement: billingAddressComplement,
				billingAddressDistrict: billingAddressDistrict,
				billingAddressPostalCode: billingAddressPostalCode,
				billingAddressCity: billingAddressCity,
				billingAddressState: billingAddressState
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
	
	$('.uf-select').change(function(){
		
		var uf = $(this).val();
		
		if(uf == ''){
			
			$(this).closest('form').find('.input-hide').hide();
		}else{
			
			$(this).closest('form').find('.input-hide').css({'display':'block'});
		}
		
		cidade_estado_ajax(uf);	
	});
	
	function cidade_estado_ajax(uf){
		
		var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				
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
	
	$('[data-id-cep]').blur(function(){
  	
       	var idCep = $(this).attr('data-id-cep'); 
       
       	var dir 	= window.location.href.split('/');
		var urlC 	= (document.domain == 'localhost')?(location.protocol+'//'+document.domain+'/'+dir[3]+'/'):(location.protocol+'//'+document.domain+'/');
				
       	$.ajax({
            url : urlC+'includes/consultar_cep.php',
            type : 'POST',
            data: 'cep='+$('[data-id-cep="'+idCep+'"]').val(),
            dataType: 'json',
            success: function(data){
            	
                if(data.sucesso == 1){
                	
                    $('[data-id-endereco="'+idCep+'"]').val(data.endereco);
                    $('[data-id-bairro="'+idCep+'"]').val(data.bairro);
                    $('[data-id-cidade="'+idCep+'"]').val(data.cidade);
                    $('[data-id-uf="'+idCep+'"]').val(data.estado);
                    $('[data-id-numero="'+idCep+'"]').focus();
                }
            }
       	});   
   		return false;    
   });
</script>

<script src="<?php echo $urlC; ?>assets/js/masks.js"></script>
