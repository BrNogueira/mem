
<?php 
$id_produto = $_POST['id_produto'];
$id_cor 	= $_POST['id_cor'];
$id_tamanho = $_POST['id_tamanho'];
?>

<!--<p><b>Modelo:</b></p>-->

<?php
$select_fields5	= 'rel_produto_var.*, modelo.nome AS modelo, produto.valor_por AS valor_por';			
$select_table5	= 'rel_produto_var';	
$select_join5	= 'INNER JOIN modelo ON modelo.id = rel_produto_var.id_modelo
					INNER JOIN produto ON produto.id = rel_produto_var.id_produto';			
$select_where5	= "WHERE rel_produto_var.estoque > 0 AND rel_produto_var.id_produto = $id_produto AND rel_produto_var.id_tamanho = $id_tamanho AND rel_produto_var.id_cor = $id_cor AND ((
						SELECT COUNT(*) 
						FROM carrinho
						INNER JOIN pedido ON pedido.id = carrinho.id_pedido
					WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
					) = 0 OR rel_produto_var.estoque > (
						SELECT SUM(carrinho.quantidade) 
						FROM carrinho
						INNER JOIN pedido ON pedido.id = carrinho.id_pedido
						WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
					))";
$select_group5	= 'GROUP BY modelo.id';
$select_order5	= 'ORDER BY modelo.ordem DESC';
$select_limit5	= '';
$consulta5 = $select->selectDefault($select_fields5, $select_table5, $select_join5, $select_where5, $select_group5, $select_order5, $select_limit5);

//$valor_troca = $result5['valor_por'] + $result5['valor'];
$valor_troca = $result5['valor'];
?>

<?php if($consulta5->num_rows > 1){ ?>
	
	<style>
		.modelos-ok{ display: block !important; }
	</style>
	
	<?php while($result5 = $consulta5->fetch_array()){ ?>
	<div class="col-xs-3 no-padding">
		<div class="product-chooser-item">
			<figure class="bg-p75">
				<p><?php echo $result5['modelo']; ?></p>
				<input type="radio" name="id_modelo" value="<?php echo $result5['id_modelo']; ?>" required data-rel-id="<?php echo $result5['id']; ?>" data-val="<?php echo ($valor_troca); ?>"/>
			</figure>
			<div class="clearfix"></div>
		</div>
	</div>
	<?php } ?>
	
	<script>
		$(document).ready(function(){
			
			$('.chooser-modelo').click(function(){
					
				setTimeout(function(){
				
					var id_produto 	= $('.id_produto').attr('id');
					var id_cor 		= $('[name=id_cor]:checked').val();
					var id_rel_produto_var = $('[name=id_modelo]:checked').attr('data-rel-id');
					var valor_total = $('[name=id_modelo]:checked').attr('data-val');
					
					valor_total = parseFloat(valor_total).toFixed(2);
					valor_total = valor_total.replace('.', ',');
					
					if(id_modelo != ''){
						
						$('.comprar-ok').fadeIn();
						$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val(id_rel_produto_var);
						$('.valor-final').html(valor_total).effect( "pulsate", {times:3}, 300 );
					}else{
						
						$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val('');
					}
				},500);
			});
		});
	</script>
<?php }elseif($consulta5->num_rows == 1){ ?>
		
	<?php $result5 = $consulta5->fetch_array(); ?>
	
	<?php if($result5['id_modelo'] == 0){ ?>
		<style>
			.modelos-ok{ display: none !important; }
		</style>
	<?php } ?>
		
	<div class="col-xs-3 no-padding">
		<div class="product-chooser-item selected">
			<figure class="bg-p75">
				<p><?php echo $result5['modelo']; ?></p>
				<input type="radio" name="id_modelo" value="<?php echo $result5['id_modelo']; ?>" checked required/>
			</figure>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<?php
	$select_fields0	= 'rel_produto_var.*, produto.valor_por AS valor_por';			
	$select_table0	= 'rel_produto_var';	
	$select_join0	= 'INNER JOIN produto ON produto.id = rel_produto_var.id_produto';			
	$select_where0	= "WHERE rel_produto_var.estoque > 0 AND rel_produto_var.id_produto = $id_produto AND rel_produto_var.id_tamanho = $id_tamanho AND rel_produto_var.id_cor = $id_cor AND rel_produto_var.id_modelo = ".$result5['id_modelo']." AND ((
							SELECT COUNT(*) 
							FROM carrinho
							INNER JOIN pedido ON pedido.id = carrinho.id_pedido
 							WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
						) = 0 OR rel_produto_var.estoque > (
							SELECT SUM(carrinho.quantidade) 
							FROM carrinho
							INNER JOIN pedido ON pedido.id = carrinho.id_pedido
							WHERE carrinho.id_rel_produto_var = rel_produto_var.id AND pedido.id_status IN(1,2)
						))";
	$select_group0	= '';
	$select_order0	= '';
	$select_limit0	= 'LIMIT 1';
	$consulta0 = $select->selectDefault($select_fields0, $select_table0, $select_join0, $select_where0, $select_group0, $select_order0, $select_limit0);
	$result0 = $consulta0->fetch_array();
	
	$id_rel_produto_var = $result0['id'];
	$valor_troca 		= $result0['valor'];
	$valor_total		= Util::fixValor($valor_troca);
	?>

	<script>
		$(document).ready(function(){
			
			var id_produto 			= '<?php echo $id_produto; ?>';
			var id_rel_produto_var 	= '<?php echo $id_rel_produto_var; ?>';
			var valor_total			= '<?php echo $valor_total; ?>';
			
			//valor_total = parseFloat(valor_total).toFixed(2);
			//valor_total = valor_total.replace('.', ',');
			
			$('.comprar-ok').fadeIn();
			$('.comprar-ok').closest('form').find('input[name=id_rel_produto_var]').val(id_rel_produto_var);
			$('.valor-final').html(valor_total).effect( "pulsate", {times:3}, 300 );
		});
	</script>
<?php } ?>
