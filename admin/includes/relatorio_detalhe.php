<style>
	.navbar{
		display: none;
	}
	.barraTopo{
		display: none;
	}
	.telaImpressao{
		width: 100%;
		background: #fff;
		position: absolute;
		top: 0px;
		left: 0px;
		padding-bottom: 30px;
		z-index: 10;
		font-size: 24px !important;
	}
	.tabelaImpressao {
		border: 1px solid #cacaca !important;
		border-radius: 10px !important;
		padding: 5px !important;
		margin-bottom: 5px !important;
		width: 100% !important;
		border-collapse: initial !important;
	}

	.tabelaImpressao tr {
		border: 1px solid black !important;
		height: 18px !important;
		font-size: .9em !important;
	}

	.tabelaImpressao tr:nth-child(even) {
		background-color: #fafafa !important;
	}

	.tabelaImpressao td {
		padding: 3px !important;
	}

	.clearfix:after {
    content: " " !important;
    visibility: hidden !important;
    display: block !important;
    height: 0 !important;
    clear: both !important;
	}

	.wrapper {
		width: 1000px !important;
		margin: 0 auto !important;
		font-size: .7em !important;
	}

	.wrapper h1 {
		border-bottom: 1px solid #cacaca !important;
		margin-bottom: 2px !important;
		font-size: 1.2em !important;
		text-transform: uppercase !important;
		text-align: center !important;
		margin-bottom: 15px !important;
		padding-bottom: 5px !important;
		line-height: normal !important;
	}

	.wrapper h3 {
		margin-bottom: 0 !important;
		font-size: 1em !important;
		line-height: normal !important;
	}

	.wrapper h3 {
		text-align: center !important;
	}

	.wrapper h4 {
		margin-top: 0 !important;
		margin-bottom: 0 !important;
		line-height: normal !important;
	}

	.head {
		background-color: #ececec !important;
		padding: 5px !important;
	}

	.email {
		margin-top: 0 !important;
		font-size: .9em !important;
	}

	.etiquetaD,
	.etiquetaR {
		max-height: 115px !important;
		font-size: 1.3em !important !important;
		line-height: 11px !important;
		margin-top: 5px !important;
		padding: 10px !important;
		border: 1px solid #cacaca !important;
	}

	.etiquetaD {
		width: 45% !important;
		float: left !important;
	}

	.etiquetaR {
		width: 45% !important;
		float: right !important;
	}

	.bold {
		font-weight: bold !important;
	}

	.head > td, .center {
		text-align: center !important;
	}

	.esquerda {
		float: left !important;
		width: 50% !important;
		font-size: 1.4em !important;
	}

	.direita {
		float: right !important;
		width: 50% !important;
		text-align: left !important;
	}
	.tb2 tr:nth-of-type(n+2) td{
		text-align: left;
		width: 50%;
	}
</style>

<?php if(isset($_SESSION['login'])){ ?>
	
	<?php
	$id_pedido = $parametro;
	
	$select_fields0	= 'pedido.id as id_pedido, pedido.*, usuario.nome as nome_cliente, status.nome as status';
	$select_table0	= 'pedido';	
	$select_join0	= 'LEFT JOIN usuario ON usuario.id = pedido.id_usuario 
						LEFT JOIN status ON status.id = pedido.id_status';	
	$select_where0	= "WHERE pedido.id = ".$parametro;
	$select_group0	= 'GROUP BY pedido.id';
	$select_order0	= '';
	$select_limit0	= '';
	$consulta0 = $select->selectDefault($select_fields0, $select_table0, $select_join0, $select_where0, $select_group0, $select_order0,
		$select_limit0);
	$result0 = $consulta0->fetch_array();
	
	
	$select_fields4	= 'usuario.*';			
	$select_table4	= 'usuario';	
	$select_join4	= 'LEFT JOIN pedido ON pedido.id_usuario = usuario.id';			
	$select_where4	= 'WHERE pedido.id = '.$id_pedido;
	$select_group4	= '';
	$select_order4	= '';
	$select_limit4 	= 'LIMIT 1';
	$consulta4 = $select->selectDefault($select_fields4, $select_table4, $select_join4, $select_where4, $select_group4, $select_order4,
		$select_limit4);	
	$result_cliente = $consulta4->fetch_array();
	
	
	$select_fields6	= '*';		
	$select_table6	= 'pedido_entrega';	
	$select_join6	= '';			
	$select_where6	= 'WHERE id_pedido = '.$id_pedido;
	$select_group6	= '';
	$select_order6	= '';
	$select_limit6 	= '';
	$consulta6 = $select->selectDefault($select_fields6, $select_table6, $select_join6, $select_where6, $select_group6, $select_order6,
		$select_limit6);	
	$result6 = $consulta6->fetch_array();
	
	$queryC = $conn->query("SELECT SUM(valor_total) AS total_carrinho FROM carrinho WHERE id_pedido = {$id_pedido}");
	$resultC = $queryC->fetch_array();
	?>
	
		<div class="telaImpressao">
		
			<div class="wrapper">

				<h1><?php echo $result_info['nome']; ?> - Relatório do pedido</h1>



					<h3 style="margin-top:-10px;" class="clearfix"><span class="esquerda">Pedido Nº <?php echo $id_pedido; ?><br/><small>Cód. transação: <?php echo $result0['codigo_transacao']; ?></small></span>
					<span class="direita">Status: <b><?php echo $result0['status']; ?></b><br>
					<?php echo $result_cliente['nome'].' '.$result_cliente['sobrenome']; ?>
					<p class="email">(<?php echo $result_cliente['email']; ?>)<i style="display: none;"><?php echo $result_cliente['id']; ?></i></p></span></h3>

					

				<table class="tabelaImpressao">
					<tbody>

						<tr>
							<td class="head" colspan="2"><h4>Dados para entrega:</h4></td>
						</tr>

						<tr>
							<td>Data da compra</td>
							<td><?php echo $result0['data_hora']; ?></td>
						</tr>

						<tr>
							<td>Endereço</td>
							<td><?php echo $result6['endereco'].', '.$result6['numero'].' - '.$result6['complemento']; ?></td>
						</tr>

						<tr>
							<td>Bairro</td>
							<td><?php echo $result6['bairro']; ?></td>
						</tr>

						<tr>
							<td>Cidade</td>
							<td><?php echo $result6['cidade']; ?></td>
						</tr>

						<tr>
							<td>Estado</td>
							<td><?php echo $result6['uf']; ?></td>
						</tr>

						<tr>
							<td>País</td>
							<td>Brasil</td>
						</tr>

						<tr>
							<td>CEP</td>
							<td><?php echo $result6['cep']; ?></td>
						</tr>

						<tr>
							<td>Telefone</td>
							<td><?php echo $result_cliente['telefone_contato']; ?></td>
						</tr>

					</tbody>

				</table>
				
				<table class="tabelaImpressao">
					<tbody>

						<tr class="head bold center">
							<td>Código</td>
							<td>Produto</td>
							<td>Referência</td>
							<td>Cor</td>
							<td>Tamanho</td>
							<td>Quantidade</td>
							<td>Preço</td>
							<td>Sub-total</td>
						</tr>
						<?php
						$select_fields	= '*';			
						$select_table	= 'carrinho';	
						$select_join	= '';			
						$select_where	= 'WHERE carrinho.id_pedido = '.$id_pedido;
						$select_group	= '';
						$select_order	= 'ORDER BY nome_produto ASC';
						$select_limit 	= '';
						$consulta = $select->selectDefault($select_fields, $select_table, $select_join, $select_where, $select_group, $select_order,
							$select_limit);	
						
						while($result = $consulta->fetch_array()){ ?>
						
							<tr class="head">
								<td><?php echo $result['id_produto']; ?></td>
								<td><?php echo $result['nome_produto']; ?></td>
								<td><?php echo (!empty($result['referencia']))?($result['referencia']):('-'); ?></td>
								<td><?php echo (!empty($result['cor']))?($result['cor']):('-'); ?></td>
								<td class="small"><?php echo (!empty($result['tamanho']))?($result['tamanho']):('-'); ?></td>
								<td><?php echo $result['quantidade']; ?></td>
								<td>R$ <?php echo Util::fixValor($result['valor_corrente']); ?></td>
								<td>R$ <?php echo Util::fixValor($result['valor_total']); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php $desconto_real = 0; ?>
				<?php if(!empty($result0['cupom_codigo'])){ ?>
					<?php $desconto_real = ($result0['cupom_tipo'] == 'r')?($result0['cupom_valor']):($resultC['total_carrinho'] * ($result0['cupom_valor'] / 100)); ?>
					<table class="tabelaImpressao tb2">
						<tbody>
							<tr>
								<td class="head" colspan="2"><h4>Cupom de Desconto</h4></td>
							</tr>
							<tr>
								<td>Nome do Cupom:</td>
								<td><?php echo $result0['cupom_nome']; ?></td>
							</tr>
							<tr>
								<td>Código do Cupom:</td>
								<td><?php echo $result0['cupom_codigo']; ?></td>
							</tr>
							<tr>
								<td>Valor do Desconto:</td>
								<td>
									<?php echo $desconto_compra = ($result0['cupom_tipo'] == 'r')?('R$ '.Util::fixValor($result0['cupom_valor'])):('<small>('.$result0['cupom_valor'].'%)</small> R$ '.Util::fixValor($resultC['total_carrinho'] * ($result0['cupom_valor'] / 100))); ?>
								</td>
							</tr>
						</tbody>
					</table>
				<?php } ?>
				<table class="tabelaImpressao tb2">
					<tbody>
						<tr>
							<td class="head" colspan="2"><h4>Valores</h4></td>
						</tr>
						<tr>
							<td>Total em produtos:</td>
							<td>R$ <?php echo Util::fixValor($resultC['total_carrinho']); ?></td>
						</tr>
						<tr>
							<td>Valor do frete:</td>
							<td><?php echo $frete = ($result0['valor_entrega'] > 0)?('R$ '.Util::fixValor($result0['valor_entrega'])):('Grátis'); ?><?php echo ' ('.$result0['tipo_entrega'].')'; ?></td>
						</tr>
						<?php if(!empty($result0['cupom_codigo'])){ ?>
						<tr>
							<td>Desconto:</td>
							<td><?php echo $desconto_compra; ?></td>
						</tr>
						<?php }else{ ?>
						<tr>
							<td>Desconto:</td>
							<td>-</td>
						</tr>
						<?php } ?>
						<tr>
							<td>Total do pedido:</td>
							<td>R$ <?php echo Util::fixValor($resultC['total_carrinho'] + $result0['valor_entrega'] - $desconto_real); ?></td>
						</tr>
					</tbody>
				</table>
				<table class="tabelaImpressao tb2">
					<tbody>
						<tr>
							<td class="head" colspan="2"><h4>Pagamento</h4></td>
						</tr>
						<tr>
							<td>Código da transação:</td>
							<td>
								<?php echo $result0['codigo_transacao']; ?>	
							</td>
						</tr>
						<tr>
							<td>Forma de Pagamento:</td>
							<td>
								<?php echo ($result0['forma_pagamento'] == 'boleto')?('Boleto'):('Cartão de Crédito'); ?>
								<?php echo (!empty($result0['bandeira']))?(' ( '.ucfirst($result0['bandeira']).' ) '):(NULL); ?>	
							</td>
						</tr>
						<tr>
							<td>Parcelamento:</td>
							<td><?php echo $result0['parcelamento'].'x'; ?> <?php echo ($result0['juros'] == 't')?('com juros'):('sem juros'); ?></td>
						</tr>
						<tr>
							<td>Total a Pagar:</td>
							<td>R$ <?php echo Util::fixValor($result0['valor_pagar']); ?></td>
						</tr>
						<tr>
							<td>Status do Pagamento:</td>
							<td class="bold"><?php echo $result0['status']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
<?php }else{ header("location:".$urlC."login"); }?>