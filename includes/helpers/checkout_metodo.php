
<?php
if($xml->error){ ?>
	
	<div class="modal fade modal-form" id="modal-aviso-pagamento" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h3 class="text-uppercase">Aviso!</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<h3>Não foi possível efetuar o pagamento!</h3>
								<p>Verifique se os seus dados foram preenchidos corretamente.</p>
							</div>
						</div>
					</div>
				</div>
				<br/><br/>
			</div>
		</div>
	</div>
	<script>
		$('#modal-aviso-pagamento').modal('show');
	</script>
<?php }else{
		
	include('includes/acoes/fecha_pedido.php');
	
	$codigo_transacao = $xml->code;
	$id_pedido = $xml->reference;
	$id_status = $xml->status;
		
	$conn->query("UPDATE pedido SET codigo_transacao = '$codigo_transacao' WHERE id = $id_pedido");
	
	$queryR = $conn->query("SELECT id_status FROM pedido WHERE id = $id_pedido");
	$resultR = $queryR->fetch_array();
	
	if($id_status != $resultR['id_status'] && $id_status == 3){
		
		$queryS = $conn->query("SELECT * FROM carrinho WHERE id_pedido = $id_pedido");
		
		while($result2 = $query2->fetch_array()){
			
			$id_produto = $result2['id_produto'];
			$vendido 	= $result2['quantidade'];
			
			$conn->query("UPDATE produto SET estoque = (estoque - $vendido) WHERE id = $id_produto");
		}
	}
	
	$conn->query("UPDATE pedido SET id_status = $id_status, codigo_transacao = '$codigo_transacao' WHERE id = $id_pedido AND metodo_atualizacao = 'auto'");
	
	$conn->query("UPDATE usuario SET sessao_carrinho = '' WHERE id = {$_SESSION['cliente_dados']['id']}");
	
	$_SESSION['cliente_dados']['sessao_carrinho'] = '';
	
	unset($_SESSION['id_novo_pedido']);
	unset($_SESSION['novo_endereco']);
	unset($_SESSION['carrinho_item']);
	unset($_SESSION['cupom']);
	unset($_SESSION['cupom_valido']);
	unset($_SESSION['valor_total']);
	unset($_SESSION['total_carrinho']);
	unset($_SESSION['frete']);
	unset($_SESSION['produto_distribuidor']);
	unset($_SESSION['carrinho_ok']);
	unset($_SESSION['frete_pac']);
	unset($_SESSION['frete_sedex']);
	unset($_SESSION['subtotal']);
	unset($_SESSION['pagseguro']);
	unset($_SESSION['cliente_pg']);
	unset($_SESSION['frete_escolhido']);
	unset($_SESSION['lista']);
	unset($_SESSION['cartao']);
	
	
	if($paymentMethod == 'boleto'){ ?>

		<?php $link_pagamento = (string)$xml->paymentLink; ?>
		
		<script>
			$('.btn-payment').attr('disabled', 'disabled');
			/*window.open('<?php echo $link_pagamento ?>', '_blank');*/
			window.location = '<?php echo $link_pagamento ?>';
		</script>
	<?php }elseif($paymentMethod == 'eft'){ ?>

		<?php $link_pagamento = (string)$xml->paymentLink; ?>
		
		<script>
			/*window.open('<?php echo $link_pagamento ?>', '_blank');*/
			window.location = '<?php echo $link_pagamento ?>';
		</script>
	<?php }else{ ?>
	
		<script>
		    window.location = '<?php echo $urlC."home" ?>';
		</script>
	<?php } ?>
<?php } ?>