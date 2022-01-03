<?php 
if(!isset($_SESSION['carrinho_item']) || count($_SESSION['carrinho_item']) == 0){
	
	unset($_SESSION['novo_endereco']);
	
	header('Location:'.$urlC);
}

if($_SESSION['carrinho_ok'] === FALSE){
	
	header('Location:'.$urlC.'carrinho');
}

//var_dump($_SESSION['endereco_entrega']);
?>


<?php $desconto_real = 0; ?>

<?php if(isset($_SESSION['cupom'])){
	
	$desconto_real = ($_SESSION['cupom']['tipo'] == 'r')?($_SESSION['cupom']['valor']):(number_format(($_SESSION['total_carrinho'] * ($_SESSION['cupom']['valor'] / 100)), 2, '.', ''));
} ?>

<?php $_SESSION['valor_total'] = $_SESSION['total_carrinho'] + $_SESSION['frete'] - $desconto_real; ?>

<div class="banner inner-banner1">
	<div class="container">
		<section class="banner-detail center-xs">
			<div class="bread-crumb right-side float-none-xs">
				<ul>
					<li><a href="<?php echo $urlC.'home'; ?>"><i class="fa fa-home"></i>Home</a>/</li>
					<li><span>Pagamento</span></li>
				</ul>
			</div>
		</section>
	</div>
</div>

<section class="ptb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-part">
					<h2 class="main_title heading">Pagamento</h2>
				</div>
			</div>
		</div>
		<div class="row">
            <div class="col-12">
                <p>Total em Produtos: <span class="pull-right"><b><?php echo 'R$ '.Util::fixValor($_SESSION['total_carrinho']); ?></b></span></p>
                <p>Desconto Cupom: <span class="pull-right"><b><?php echo $desconto_pagamento = ($desconto_real > 0)?('- R$ '.Util::fixValor($desconto_real)):('-'); ?></b></span></p>
                <?php $frete_pagamento = ($_SESSION['frete'] == 0)?('Grátis'):('R$ '.Util::fixValor($_SESSION['frete'])); ?>
                <p>Frete: <span class="pull-right"><b><?php echo $frete_pagamento; ?></b></span></p>
                <p>TOTAL DA COMPRA: <span class="pull-right"><b><big class="valor-final"><?php echo 'R$ '.Util::fixValor($_SESSION['valor_total']); ?></big></b></span></p>
            </div>
        </div>
		<div class="row">
			<div class="col-12">	
				<hr class="hr-default"/>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-12">	
				<p class="font-700 text-uppercase">Selecione uma Forma de Pagamento:</p>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-12">
				<div class="ui-tabs tabs-login">
					<ul>
						<li><a href="#tabs-1"><i class="fa fa-credit-card"></i>&nbsp;&nbsp;Cartão de Crédito</a></li>
						<li><a href="#tabs-2"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Boleto Bancário</a></li>
					</ul>
					<div id="tabs-1">
						<form method="post" action="<?php echo $urlC.'acao'; ?>" class="form-prevent">					
							<div class="row">
								<div class="col-12 col-sm-6 col-md-5">
									<div class="row">
										<div class="col-12">
											<div class="form-group">
												<label for="cardNumber">Número do Cartão de Crédito:</label>
												<input type="text" class="form-control numero-cartao-mask" name="cardNumber" data-brand="" required/>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="creditCardHolderName">Nome (como está impresso no Cartão):</label>
												<input type="text" class="form-control input-upper" name="creditCardHolderName" required/>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-6 col-md-5">
									<div class="row">
										<div class="col-12">
											<label for="creditCardHolderName">Válidade do Cartão (formato: MM/AA):</label><br/>
											<div class="form-group">
												<input type="text" class="form-control mm-aa-mask" name="expiration" required/>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="cvv">Código de Segurança <small>(CVV)</small></label>
												<input type="text" class="form-control codigo-seguranca-mask" name="cvv" required/>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="parcelamento-cartao"></div>
									<div class="row dados-cartao" style="display: none;">
										<div class="col-12">
											<br/>
											<h5 class="">
												<span class="text-uppercase">Os dados para cobrança são os mesmos do seu cadastro?</span><br/>
												<small>Confira abaixo e caso necessário informe os dados atualizados:</small>
											</h5>
										</div>
										<div class="col-12 dados-cartao">
											<div class="row">
												<div class="col-12 col-sm-6 col-md-5">
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
												<div class="col-12 col-sm-6 col-md-5">
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
												<div class="col-12">
													<big class="totalAmount"></big>
												</div>
												<div class="col-12">
													<br/>
													<input type="hidden" name="psToken" value=""/>
													<input type="hidden" name="psHash" value=""/>
													<input type="hidden" name="bandeira" value=""/>
													<input type="hidden" name="acao" value="pagar_ps"/>
													<button type="submit" class="btn btn-success btn-credit-payment btn-exe">Concluir pagamento</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div id="tabs-2">
						<div class="row">
							<div class="col-12">
								<button class="btn btn-custom gera-boleto">Fechar pedido e gerar o boleto</button>
								<div class="box-boleto"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
